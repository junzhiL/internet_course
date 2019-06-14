<?php

namespace app\common\model;

use think\Db;
use think\Model;

class Common extends Model
{
    public function notification_count()
    {
        $count = Db::table('work_order')->where('work_order_status',0)->count();
        return $count;
    }

    public function notification_info(){
        $info = db('work_order')->alias('wo')
            ->where('wo.work_order_status',0)
            ->join('customer_info ci','ci.customer_id = wo.customer_id')
            ->field('wo.description,ci.customer_name,wo.create_time,wo.work_order_id')
            ->select();
        return $info;
    }

    public function get_menu_id($module,$controller,$action){
        $menu_id = Db::table('menu')->where('module',$module)
            ->where('controller',$controller)
            ->where('action',$action)
            ->field('menu_id')
            ->find();
        return $menu_id['menu_id'];
    }

    public function get_menu_info(){
        $menu_info = Db::table('menu')->where('is_delete',0)
            ->order('number')
            ->select();
        return $menu_info;
    }
}