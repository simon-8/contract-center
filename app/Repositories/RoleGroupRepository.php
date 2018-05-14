<?php
/**
 * Note: 管理员组
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\RoleGroup;

class RoleGroupRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new RoleGroup());
    }
}