<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/5/29
 */
namespace App\Presenters;

class AuthPresenter
{
    /**
     * 显示用户名
     * @return mixed
     */
    public function showUserName()
    {
        return auth()->guard('admin')->user()->username;
    }

    /**
     * 显示真实姓名
     * @return mixed
     */
    public function showTrueName()
    {
        return auth()->guard('admin')->user()->truename;
    }

    /**
     * 显示头像
     * @return mixed
     */
    public function showAvatar()
    {
        return auth()->guard('admin')->user()->avatar;
    }
}