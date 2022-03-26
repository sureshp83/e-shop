<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Pagination\Paginator;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index');
    }


    /**
     * Load categories data
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function search(Request $request)
    {
       
        if($request->ajax())
        {
            $currentPage = ($request->start == 0) ? 1 : (($request->start / $request->length) + 1);

            Paginator::currentPageResolver(function() use($currentPage){
                return $currentPage;
            });

            $orderDir = $request->order[0]['dir'];
            $orderColumnId = $request->order[0]['column'];
            $orderColumn = str_replace('"','', $request->columns[$orderColumnId]['name']);

            $query = Category::selectRaw('categories.id,categories.category,
            categories.parent_id,parent.category as parent_category,categories.is_active')
            ->leftJoin('categories as parent', 'parent.id', 'categories.parent_id');
            
            $query->where(function($query) use($request){
                $query->orWhere('categories.category', 'like', '%'.$request->search['value'].'%')
                ->orWhere('parent.category', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $categories = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $categories['recordsFiltered'] = $categories['recordsTotal'] = $categories['total'];

            foreach($categories['data'] as $key => $category)
            {
                
                $params = [
                    'category' => $category['id']
                ];

                $deleteRoute = route('categories.destroy', $params);
                $editRoute = route('categories.edit', $params);
                $statusRoute = route('categories.status', $params);
                
                $status = ($category['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                
                $categories['data'][$key]['status'] = '<a href="javascript:void(0);" data-url="' . $statusRoute . '" class="btnChangeStatus">'. $status.'</a>';
                $categories['data'][$key]['action'] ='<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit category"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                $categories['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="category" data-type="confirm" title="delete category"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($categories);
    }


    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::where(['is_active' => 1])
        ->whereNull('parent_id')
        ->selectRaw('categories.id,categories.category')
        ->get();

        return view('admin.category.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required'
        ]);
        
        $category = new Category();
        $category->fill($request->all());
        
        if($category->save())
        {
            if($request->has('category_image'))
            {
                $imageName = time().'.'.$request->category_image->getClientOriginalExtension();
                $request->category_image->move(public_path('/images/category'), $imageName);
                
                $category->category_image = $imageName;
                $category->save();

            }
            
            return redirect(route('categories.index'))->with('success', trans('messages.categories.add.success'));
        }

        return redirect(route('categories.index'))->with('error', trans('messages.categories.add.error'));
    }


     /**
     * Change category status
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeStatus(Category $category)
    {
        if (empty($category))
        {
            return redirect(route('categories.index'))->with('error', trans('messages.categories.not_found_admin'));
        }

        $category->is_active = !$category->is_active;
        
        if ($category->save()) 
        {
            $status = $category->is_active ? 'Active' : 'Inactive';

            return redirect(route('categories.index'))->with('success', trans('messages.categories.status.success', ['status' => $status]));
        }

        return redirect(route('categories.index'))->with('error', trans('messages.categories.status.error'));
    }

    /**
     * Display the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $avatarPath = url(config('constant.CATEGORY'));

        $parentCategories = Category::where(['is_active' => 1])
        ->whereNull('parent_id')
        ->selectRaw('categories.id,categories.category,
        CONCAT("'.$avatarPath.'","/",IFNULL(category_image,"default-user.png")) AS category_image')
        ->get();

        $categoryDetail = Category::where('id', $category->id)
        ->selectRaw('categories.id,categories.category,
        CONCAT("'.$avatarPath.'","/",IFNULL(category_image,"default-user.png")) AS category_image')
        ->first();

        //dd($categoryDetail);
        return view('admin.category.create', compact('parentCategories','categoryDetail'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'category' => 'required'
        ]);

        $category = Category::find($category->id);
        $category->fill($request->all());

        if ($category->save()) 
        {
            if($request->has('category_image'))
            {
                $imageName = time().'.'.$request->category_image->getClientOriginalExtension();
                $request->category_image->move(public_path('/images/category'), $imageName);
                
                $category->category_image = $imageName;
                $category->save();

            }
            
            return redirect(route('categories.index'))->with('success', trans('messages.categories.update.success'));
        }

        return redirect(route('categories.index'))->with('error', trans('messages.categories.update.error'));
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        
        if($category->delete())
        {
            return redirect(route('categories.index'))->with('success', trans('messages.categories.delete.success'));
        }
        return redirect(route('categories.index'))->with('error', trans('messages.categories.delete.error'));
    }
}
