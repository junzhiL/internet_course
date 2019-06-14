<?php
/**
 * Created by PhpStorm.
 * User: 84333
 * Date: 2019/4/14
 * Time: 0:25
 */

namespace app\manageconfig\controller;

use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use think\Db;
use app\common\controller\Common;
use app\logmanage\model\Log as LogModel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use think\Request;


class Whitelist extends Common
{
    public function index()
    {
        $whitelist = model('Whitelist');
        $info = $whitelist->getinfo();
        foreach ($info as $key => $value) {
            if ($info[$key]['type_id'] == 0) {
                $info[$key]['type'] = '普通用户';
            } elseif ($info[$key]['type_id'] == 1) {
                $info[$key]['type'] = '院领导';
            } elseif ($info[$key]['type_id'] == 2) {
                $info[$key]['type'] = '部门领导';
            } elseif ($info[$key]['type_id'] == 3) {
                $info[$key]['type'] = '系领导';
            } else {
                $info[$key]['type'] = '空';
            }
        }
        $this->assign('info', $info);

        return $this->fetch();
    }

    public function addwhitelist()
    {
        $data = input('post.');
        if (empty($data['work_id'])) {
            $this->error('输入不可为空');
        }
        $whitelist = model('Whitelist');

        $exist_work_id = $whitelist->exist_work_id($data['work_id']);
        if ($exist_work_id) {
            $this->error('请先将该人员添加到用户中');
        }
        $exist_white_list = $whitelist->exist_white_list($data['work_id']);
        if ($exist_white_list) {
            $this->error('该用户已在白名单中');
        }
        $is_add = $whitelist->add($data['work_id']);


        if ($is_add) {
            $this->success('添加成功');
        } else {
            $this->error('添加失败');
        }
    }
}