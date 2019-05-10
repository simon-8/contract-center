<?php
/**
 * Note: 广告
 * User: Liu
 * Date: 2018/3/14
 * Time: 22:59
 */
namespace App\Repositories;

use App\Models\Ad;

class AdRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Ad());
    }
}