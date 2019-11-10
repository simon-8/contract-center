<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/11
 * Time: 10:41
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ContractCategory extends Base
{
    use ModelTrait;

    protected $table = 'contract_category';

    protected $fillable = [
        'name',
        'pid',
        'players',
        'company_id',
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
     * @param int $companyid
     * @return \Illuminate\Support\Collection
     */
    public static function getCats($companyid = 0)
    {
        if ($companyid) {
            return self::select(['id', 'name'])->where('company_id', $companyid)->get()->pluck('name', 'id');
        } else {
            return self::select(['id', 'name'])->where('company_id', 0)->get()->pluck('name', 'id');
        }
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

    /**
     * 公司
     * @param Builder $query
     * @param int $data
     * @return Builder
     */
    public function scopeOfCompanyId(Builder $query, $data = '')
    {
        if ($data === '') return $query;
        return $query->where('company_id', $data);
    }

    /**
     * @param int $companyid
     * @return \Illuminate\Support\Collection
     */
    public static function getParents($companyid = 0)
    {
        return self::select(['id', 'name'])
            ->where('pid', 0)
            ->where('company_id', $companyid)
            ->get();
    }
}
