<?php
namespace app\login\controller;
use think\Db;
use think\Controller;

 
class Register extends Controller
{
    public function index()
    {
    	return $this->fetch();
    }
	public function register(){
		$param = input('post.');
    	if(empty($param['user_name'])){

    		$this->error('用户名不能为空');
    	}

	
	
    	if(empty($param['user_pwd'])){

    		$this->error('密码不能为空');
    	}

    	if (empty($param['user_pwd_re'])){
    	    $this->error('请再次输入密码');
        }
    	if ($param['user_pwd'] !== $param['user_pwd_re']){
    	    $this->error('密码不一致');
        }
        $has = db('users')->where('user_name', $param['user_name'])->find();

        if(!empty($has)){
            $this->error('用户名已存在');
        }
		$param['user_pwd'] = md5($param['user_pwd']);
    	$data = ['user_name'=>$param['user_name'],'user_pwd'=>$param['user_pwd']];

		db('users')->insert($data);



        cookie('user_id', $has['id'], 3600);  // 一个小时有效期
        cookie('user_name', $has['user_name'], 3600);
        $this->success('注册成功','login/index');
	}
}
