<?php
/**
 * Note: 后台管理员资源库
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Manager;
use Illuminate\Support\Facades\Cache;

class ManagerRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Manager());
    }

    public function setAccess()
    {

    }
}