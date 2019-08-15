<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContractTplSection extends Base
{
    use ModelTrait;

    protected $table = 'contract_tpl_section';

    protected $fillable = [
        'catid',
        'players',
        'name',
        'listorder',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

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
}
