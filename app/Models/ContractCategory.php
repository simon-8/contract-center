<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/11
 * Time: 10:41
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Support\Facades\Cache;

class ContractCategory extends Base
{
    use ModelTrait;

    protected $table = 'contract_category';

    protected $fillable = [
        'name',
        'players',
        'introduce',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tplSection()
    {
        return $this->hasMany('App\Models\ContractTplSection', 'catid', 'id');
    }

    /**
     * 获取所有分类
     * @return ContractCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getCats()
    {
        return self::select(['id', 'name'])->get()->pluck('name', 'id');
    }

    /**
     * 获取分类名称
     * @param null $catid
     * @return mixed
     */
    public static function getCatName($catid = null)
    {
        $cats = Cache::remember(__CLASS__.'.cats', now()->addHour(), function() {
            return self::getCats();
        });
        return $cats[$catid];
    }
}
