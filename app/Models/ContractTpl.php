<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContractTpl extends Base
{
    use ModelTrait;

    protected $table = 'contract_tpl';

    protected $fillable = [
        'section_id',
        'content',
        'listorder',
    ];

    /**
     * 合同类型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractCategory()
    {
        return $this->belongsTo('App\Models\ContractCategory', 'catid', 'id');
    }

    /**
     * 合同模块
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractTplSection()
    {
        return $this->belongsTo('App\Models\ContractTplSection', 'section_id', 'id');
    }

    /**
     * @param Builder $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfContent(Builder $query, $data = '')
    {
        if (empty($data)) return $query;
        return $query->where('content', 'like', "%{$data}%");
    }

    /**
     * @param Builder $query
     * @param int $data
     * @return Builder
     */
    public function scopeOfTypeid(Builder $query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('typeid', $data);
    }

    /**
     * @param Builder $query
     * @param int $data
     * @return Builder
     */
    public function scopeOfSectionId(Builder $query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('section_id', $data);
    }
}
