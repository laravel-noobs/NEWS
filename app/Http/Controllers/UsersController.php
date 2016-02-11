<?php

namespace App\Http\Controllers;

use App\Events\UserWasBanned;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use KouTsuneka\FlashMessage\Flash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UsersController extends Controller
{
    /**
     * @var string
     */
    protected $config_key = '_user';

    /**
     * @var array
     */
    protected $configs = [
        'filter' => [
            'status_type' => 'verified',
            'role' => null,
            'search_term' => null
        ]
    ];

    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.search_term' => 'min:4,max:255',
        'filter.role' => 'exists:role,id'
    ];

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        $this->load_config('filter');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs = $this->read_configs(['filter.search_term', 'filter.status_type', 'filter.role']);

        $users = User::with('role', 'postsCount', 'feedbacksCount')
            ->hasStatus($configs['filter_status_type']);

        if($configs['filter_role'])
            $users = $users->hasRole($configs['filter_role']);

        if($configs['filter_search_term'])
            $users = $users->searchByTerm($configs['filter_search_term']);

        $users = $users->paginate(20);

        $roles = Role::all(['id', 'name']);

        return view('admin.user_index', array_merge(compact('users', 'roles'), $configs));
    }

    /**
     * @param $id
     * @return Redirect
     */
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

    /**
     * @param Request $request
     */
    public function ban(Request $request)
    {
        $input = $request->input();
        if(empty($input['user_id']))
            throw new BadRequestHttpException();

        $user = User::findOrFail($input['user_id']);
        $user->ban(!empty($input['expired_at']) ? $input['expired_at'] : null);

        event(new UserWasBanned($user, Auth::user(), $input['reason'], $input['message']));
        return Redirect::back();
    }

    /**
     * @param $verify_token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getVerifyEmailByLink($verify_token)
    {
        return $this->verifyEmail($verify_token);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getVerifyEmail()
    {
        return view('unify.email_verify_prompt');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postVerifyEmail(Request $request)
    {
        return $this->verifyEmail($request->request->get('verify_token'));
    }

    /**
     * @param $verify_token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function verifyEmail($verify_token)
    {

        $validator = Validator::make(['verify_token' => $verify_token], [
            'verify_token' => 'required|min:10|max:10'
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::whereVerifyToken($verify_token)->first();

        if($user == null)
        {
            $validator->errors()->add('verify_token', 'Mã xác thực không tồn tại');
            return Redirect::action('UsersController@getVerifyEmail')
                ->withErrors($validator)
                ->withInput();
        }

        $user->verifyEmail();
        return view('unify.email_verified_welcome');
    }
}
