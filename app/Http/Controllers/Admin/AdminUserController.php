<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\User;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the users resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.users.index');
    }


    /**
     * Load users list with filters 
     * @param Request $request
     * 
     * @return Reesponse Json
     */
    public function search(Request $request)
    {
        if($request->ajax())
        {
            $currentPage = ($request->start == 0) ? 1 : (($request->start / $request->length) + 1);

            Paginator::currentPageResolver(function() use($currentPage){
                return $currentPage;
            });

            $avatarPath = url(config('constant.AVATAR'));

            $orderDir = $request->order[0]['dir'];
            $orderColumnId = $request->order[0]['column'];
            $orderColumn = str_replace('"','', $request->columns[$orderColumnId]['name']);

            $query = User::selectRaw('users.id,phone_number,CONCAT(first_name," ",last_name) AS name,
            users.email,users.is_active,CONCAT("'.$avatarPath.'","/",IFNULL(profile_image,"default-user.png")) AS profile_image');
            
            $query->where(function($query) use($request){
                $query->orWhere('users.first_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('users.last_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('users.phone_number', 'like', '%'.$request->search['value'].'%')
                ->orWhere('users.email', 'like', '%'.$request->search['value'].'%');
            });

            $users = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $users['recordsFiltered'] = $users['recordsTotal'] = $users['total'];

            foreach($users['data'] as $key => $user)
            {
                
                $params = [
                    'user' => $user['id']
                ];

                $deleteRoute = route('users.destroy', $params);
                $viewRoute = route('users.show', $params);
                $statusRoute = route('users.status', $params);
                $editRoute = route('users.edit', $params);

                $status = ($user['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                
                $users['data'][$key]['profile_image'] = '<img src="'.$user['profile_image'].'" class="rounded-circle" width="40" height="40">';
                $users['data'][$key]['status'] = '<a href="javascript:void(0);" data-url="' . $statusRoute . '" class="btnChangeStatus">'. $status.'</a>';
                //$users['data'][$key]['action'] ='<a href="' . $viewRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="View users"><i class="zmdi zmdi-eye"></i></a>&nbsp&nbsp';
                $users['data'][$key]['action'] = '<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit users"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                $users['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="user" data-type="confirm" title="delete user"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }  
        }
        return json_encode($users);
    }

    /**
     * Show the form for creating a new user resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'phone_number' => 'required',
            'profile_image' => 'nullable'
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->password = \bcrypt($request->password);

        if($request->has('profile_image'))
        {
            $imageName = time().'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/images/avatar'), $imageName);
            
            $user->profile_image = $imageName;
    
        }
        
        if($user->save())
        {
            return redirect(route('users.index'))->with('success', trans('messages.users.create.success'));
        }

        return redirect(route('users.index'))->with('error', trans('messages.users.create.error'));
    }

    /**
     * Change user status
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeStatus(User $user)
    {
        if (empty($user))
        {
            return redirect(route('users.index'))->with('error', trans('messages.users.not_found_admin'));
        }

        $user->is_active = !$user->is_active;
        
        if ($user->save()) 
        {
            $status = $user->is_active ? 'Active' : 'Inactive';

            return redirect(route('users.index'))->with('success', trans('messages.users.status.success', ['status' => $status]));
        }

        return redirect(route('users.index'))->with('error', trans('messages.users.status.error'));
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
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $avatarPath = url(config('constant.AVATAR'));

        $userDetail = User::where('id', $user->id)->selectRaw('users.id,phone_number,first_name,last_name,
        users.email,users.is_active,CONCAT("'.$avatarPath.'","/",IFNULL(profile_image,"default-user.png")) AS profile_image')
        ->first();

        return view('admin.users.create', compact('userDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
       
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'phone_number' => 'required'
        ]);

        $user->fill($request->all());

        if($request->has('profile_image'))
        {
            $imageName = time().'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/images/avatar'), $imageName);
            
            $user->profile_image = $imageName;
    
        }

        if($user->save())
        {
            return redirect(route('users.index'))->with('success', trans('messages.users.update.success'));
        }

        return redirect(route('users.index'))->with('error', trans('messages.users.update.error'));
        
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if($user->delete())
        {
            return redirect(route('users.index'))->with('success', trans('messages.users.delete.success'));
        }
        return redirect(route('users.index'))->with('error', trans('messages.users.delete.error'));
    }
}
