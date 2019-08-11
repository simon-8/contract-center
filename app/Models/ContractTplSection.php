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
        'player_type',
        'name',
        'listorder',
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
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfName(Builder $query, $data = '')
    {
        if (empty($data)) return $query;
        return $query->where('name', 'like', '%'.$data.'%');
    }
}
