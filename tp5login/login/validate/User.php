<?php
/**
 * Created by PhpStorm.
 * User: 84333
 * Date: 2019/3/22
 * Time: 17:21
 */
namespace app\login\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name'  =>  'require|length:4,10',
        'password' =>  'require|min:6|confirm',
    ];
    protected $message = [
        'name.require'  =>  '用户名不能为空',
        'name.length:4,10' => '用户名长度在4-10位之间',
        'password.require' =>  '密码不能为空',
        'password.min:6' => '密码长度不能小于6位',
        'password.confirm' => '密码不一致请重新输入',
    ];

}