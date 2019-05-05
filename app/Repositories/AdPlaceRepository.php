<?php
/**
 * Note: 广告位
 * User: Liu
 * Date: 2018/3/14
 * Time: 22:59
 */
namespace App\Repositories;

use App\Models\AdPlace;

class AdPlaceRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new AdPlace());
    }
}