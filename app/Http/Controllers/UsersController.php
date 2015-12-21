<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\QueryException;
use KouTsuneka\FlashMessage\Flash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user_index', ['users' => $users]);
    }

    public function delete($id)
    {
         try
        {
            if(User::destroy($id))
                Flash::push("Xóa user thành công", 'Hệ thống');
            else
                Flash::push("Xóa user thất bại", 'Hệ thống', 'error');
        }
        catch(QueryException $ex)
        {
            Flash::push("Xóa user thất bại", 'Hệ thống', 'error');
        }
        return redirect(action('UsersController@index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user_edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:user,email,' . $id,
            'password' => 'min:6|max:60',
        ]);


        $user = User::findOrFail($id);

        $input = $request->all();

        if(!empty($input['password']))
            $user->password = bcrypt($input['password']);

        if($user->update($input))
            Flash::push("Sửa người dùng thành công \\\"$user->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Sửa người dùng thất bại", 'Hệ thống', "error");
        return redirect(action('UsersController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
