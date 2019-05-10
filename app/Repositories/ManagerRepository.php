<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/5/10
 */
namespace App\Repositories;

use App\Models\Manager as Model;

class ManagerRepository
{
    static $model;

    public function __construct()
    {
        self::$model = new Model();
    }
}