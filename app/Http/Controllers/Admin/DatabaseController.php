<?php
/**
 * Note: 数据管理
 * User: Liu
 * Date: 2018/03/18
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class DatabaseController extends Controller
{
    /**
     * 显示所有表信息
     * @return mixed
     */
    public function getIndex()
    {
        $sql = 'SHOW TABLE STATUS FROM ' .  config('database.connections.mysql.database');
        $lists = \DB::select($sql);

        $data = [
            'lists' => $lists
        ];
        return admin_view('database.index' , $data);
    }

    /**
     * 获取当前表字段信息
     * @param \Request $request
     * @return array
     */
    public function getFields(\Request $request)
    {
        $sql = 'SHOW FULL COLUMNS FROM `' . $request::input('table') . '`';
        $lists = \DB::select($sql);
        return $lists;
    }

    /**
     * 修复表
     * @param \Request $request
     * @return int
     */
    public function getRepair(\Request $request)
    {
        $table = $request::input('table');
        $sql = 'REPAIR TABLE `'.$table.'`';
        $result = \DB::query($sql);
        return $result ? 1 : 0;
    }

    /**
     * 优化表
     * @param \Request $request
     * @return int
     */
    public function getOptimize(\Request $request)
    {
        $table = $request::input('table');
        $sql = 'OPTIMIZE TABLE `'.$table.'`';
        $result = \DB::query($sql);
        return $result ? 1 : 0;
    }
}