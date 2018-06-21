<?php
/**
 * Note: 角色资源库
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Roles as Roles;

class RolesRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Roles());
    }
}