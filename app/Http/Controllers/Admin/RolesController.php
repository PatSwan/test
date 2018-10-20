<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\RoleService;
use App\Services\Admin\UserService;

class RolesController extends Controller
{
    //定义service变量
    protected $roleService;
    protected $userService;

    /**
     * 初始化service
     */
    public function __construct()
    {
        $this->roleService = new RoleService();
        $this->userService = new UserService();
    }

    /**
     * 角色列表
     */
    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('admin.roles.rolelist',['roles'=>$roles]);
    }

    /**
     * 添加角色
     */
    public function create()
    {
        $menus = new \App\Services\Admin\MenuService();
        $menus = $menus->getMenus();
        return view('admin.roles.rolecreate',['menus'=>$menus]);
    }

    /**
     * 执行添加角色
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request,[
                'role_name' => 'required|unique:roles,role_name',
                'menus' => 'required',
            ]);
        }
        $result = $this->roleService->createRole($request);
        if ($result) {
            $this->roleService->insertAccess();
            return redirect('/warning')->with(['message'=>'添加成功','url'=>'/admin/roles','jumpTime'=>3,'status'=>true]);
        } else {
            return redirect('/warning')->with(['message'=>'添加失败','url'=>'/admin/roles/create','jumpTime'=>3,'status'=>false]);
        }
    }
}