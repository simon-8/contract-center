<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/11
 * Time: 14:53
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getIndex() {
        var_dump(1);
        exit();
        return admin_view('index.index');
    }

    public function getCreate()
    {
        var_dump(2);
        exit();
    }

    public function getDelete()
    {
        var_dump(3);
        exit();
    }
}