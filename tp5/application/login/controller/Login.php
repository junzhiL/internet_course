<?php
namespace app\login\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    // 处理登录逻辑
    public function doLogin()
    {
        $param = input('post.');
        if(empty($param['user_name'])){
            return alert_error('用户名不能为空！');
        }

        if(empty($param['user_pwd'])){
            return alert_error('密码不能为空！');
        }

        // 验证用户名
        $user=\app\personal\model\Personal::search($param['user_name']);
        if(empty($user)){
            return alert_error('用户名或密码错误！');
        }

        //验证用户是否已被冻结
        if($user['status'] == 0){
            return alert_error('该账户已被冻结！');
        }

        // 验证密码
        if($user['password'] != md5($param['user_pwd'])){
            return alert_error('用户名或密码错误！');
        }

        // 用户
        session('user', $user);

        return alert_success('您好，欢迎登陆！','/order/searchorder/index');
    }

    // 退出登录
    public function loginOut()
    {
        session('user', null);
        return alert_success('成功退出！','/login/login/index');
    }



}
