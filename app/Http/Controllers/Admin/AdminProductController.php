<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Product;
use App\Models\Category;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index');
    }


    /**
     * Load products data
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

            $productPath = config('constant.PRODUCT');

            $orderDir = $request->order[0]['dir'];
            $orderColumnId = $request->order[0]['column'];
            $orderColumn = str_replace('"','', $request->columns[$orderColumnId]['name']);

            $query = Product::selectRaw('products.id,products.is_active,
            (select CONCAT("'.$productPath.'", IFNULL(product_images.image,"default-user.png")) from product_images where product_images.product_id=products.id and product_images.is_primary=1) as product_image,
            products.product_name,categories.category')
            ->leftJoin('categories', 'categories.id', 'products.category_id');
            
            
            $query->where(function($query) use($request){
                $query->orWhere('categories.category', 'like', '%'.$request->search['value'].'%')
                ->orWhere('products.product_name', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $products = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $products['recordsFiltered'] = $products['recordsTotal'] = $products['total'];

            foreach($products['data'] as $key => $product)
            {
                
                $params = [
                    'product' => $product['id']
                ];

                $deleteRoute = route('products.destroy', $params);
                $viewRoute = route('products.show', $params);
                $statusRoute = route('products.status', $params);
                $editRoute = route('products.edit', $params);

                $status = ($product['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                
                $products['data'][$key]['product_image'] = '<img src="'.$product['product_image'].'" class="rounded-circle" width="40" height="40">';
                $products['data'][$key]['status'] = '<a href="javascript:void(0);" data-url="' . $statusRoute . '" class="btnChangeStatus">'. $status.'</a>';
                $products['data'][$key]['action'] ='<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit product"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                $products['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="product" data-type="confirm" title="delete product"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($products);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::selectRaw('categories.id,categories.category')
        ->get();

        return view('admin.products.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'product_name' => 'required|unique:products',
            'price' => 'required'
        ]);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->description = $request->description;

        if($product->save())
        {
            return redirect(route('products.index'))->with('success', trans('messages.products.add.success'));
        }

        return redirect(route('products.index'))->with('error', trans('messages.products.add.error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Change category status
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeStatus(Product $product)
    {
        if (empty($product))
        {
            return redirect(route('products.index'))->with('error', trans('messages.products.not_found_admin'));
        }

        $product->is_active = !$product->is_active;
        
        if ($product->save()) 
        {
            $status = $product->is_active ? 'Active' : 'Inactive';

            return redirect(route('products.index'))->with('success', trans('messages.products.status.success', ['status' => $status]));
        }

        return redirect(route('products.index'))->with('error', trans('messages.products.status.error'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'product_name' => 'required',
            'price' => 'required'
        ]);

        
        $product->category_id = $request->category_id;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->description = $request->description;

        if($product->save())
        {
            return redirect(route('products.index'))->with('success', trans('messages.products.update.success'));
        }

        return redirect(route('products.index'))->with('error', trans('messages.products.update.error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if($product->delete())
        {
            return redirect(route('products.index'))->with('success', trans('messages.products.delete.success'));
        }
        return redirect(route('products.index'))->with('error', trans('messages.products.delete.error'));
    }
}
