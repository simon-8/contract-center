<?php
/**
 * Note: 权限资源库
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\RoleAccess;

class RoleAccessRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new RoleAccess());
    }
}