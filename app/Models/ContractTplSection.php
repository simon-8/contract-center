<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContractTplSection extends Base
{
    use ModelTrait;

    // 参与者类型 (双方合同  三方合同)
    const PLAYERS_NORMAL = 0;
    const PLAYERS_TWO = 2;
    const PLAYERS_THREE = 3;

    protected $table = 'contract_tpl_section';

    protected $fillable = [
        'catid',
        'players',
        'name',
        'is_hide',
        'listorder',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'player_text',
    ];

    /**
     * @param $value
     * @return mixed|string
     */
    public function getPlayerTextAttribute($value)
    {
        return $this->getPlayersText($value);
    }

    /**
     * 合同分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractCategory()
    {
        return $this->belongsTo('App\Models\ContractCategory', 'catid', 'id');
    }

    /**
     * 关联模板
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractTpl()
    {
        return $this->hasMany('App\Models\ContractTpl', 'section_id', 'id');
    }

    /**
     * 名称
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfName(Builder $query, $data = '')
    {
        if (empty($data)) return $query;
        return $query->where('name', 'like', '%'.$data.'%');
    }

    /**
     * 参与人类型
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfPlayers(Builder $query, $data = '')
    {
        if (empty($data)) return $query;
        return $query->where('players', $data);
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
}
