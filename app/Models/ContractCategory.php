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

    // 用户类型 first甲 second乙 three居间
    const USER_TYPE_FIRST = 'first';
    const USER_TYPE_SECOND = 'second';
    const USER_TYPE_THREE = 'three';

    const PLAYERS_NORMAL = 0;
    const PLAYERS_TWO = 2;
    const PLAYERS_THREE = 3;

    protected $table = 'contract_category';

    protected $fillable = [
        'name',
        'pid',
        'players',
        'user_type',
        'company_id',
        'introduce',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'player_text',
        'user_type_text',
    ];

    /**
     * @param $value
     * @return mixed|string
     */
    public function getUserTypeTextAttribute($value)
    {
        if ($this->user_type === self::USER_TYPE_FIRST) {
            return '甲方';
        } else if ($this->user_type === self::USER_TYPE_SECOND) {
            return '乙方';
        } else if ($this->user_type === self::USER_TYPE_THREE) {
            return '居间人';
        }
        return '';
    }

    /**
     * 合同参与人类型
     * @param $value
     * @return mixed|string
     */
    public function getPlayerTextAttribute($value)
    {
        return $this->getPlayersText($this->players);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tplSection()
    {
        return $this->hasMany('App\Models\ContractTplSection', 'catid', 'id');
    }

    /**
     * 关联 公司
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    /**
     * 关联 数据存证 场景
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function eviScene()
    {
        return $this->hasOne('App\Models\EsignEviScene', 'catid', 'id');
    }

    /**
     * 参与者类型
     * @return array
     */
    public static function getPlayers()
    {
        $arr = [
            //self::PLAYERS_NORMAL => '单方',
            self::PLAYERS_TWO => '双方',
            self::PLAYERS_THREE => '三方'
        ];
        return $arr;
    }

    /**
     * 参与者类型
     * @param null $type
     * @return mixed|string
     */
    public function getPlayersText($type = null)
    {
        if ($type === null) $type = $this->players;
        return self::getPlayers()[$type] ?? 'not fund';
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
        //$cats = Cache::remember(__CLASS__.'.cats', now()->addHour(), function() {
        //    return self::getCats();
        //});
        return self::find($catid)->name;
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
     * 关键词
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfKeyword(Builder $query, $data = '')
    {
        if (!$data) return $query;
        return $query->where('name', 'like', '%'.$data.'%');
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
