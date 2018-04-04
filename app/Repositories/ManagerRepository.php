<?php
/**
 * Note: 后台管理员
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Manager;

class ManagerRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Manager());
    }
    /**
     * 密码校验
     * @param $input_password
     * @param $password
     * @return bool
     */
    //public function compare_password($input_password , $password)
    //{
    //    return password_verify($input_password , $password);
    //}
}