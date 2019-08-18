<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContractTpl extends Base
{
    use ModelTrait;

    const FILL_STRING = '__填空__';

    protected $table = 'contract_tpl';

    protected $fillable = [
        'section_id',
        'catid',
        'players',
        'content',
        'formdata',
        'listorder',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function getContentAttribute($value)
    {
        return $value ? strip_tags($value) : '';
    }

    public function getFormdataAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setFormdataAttribute($value)
    {
        $this->attributes['formdata'] = json_encode($value);
    }

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
    public function scopeOfSectionId(Builder $query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('section_id', $data);
    }

    /**
     * @param Builder $query
     * @param int $data
     * @return Builder
     */
    public function scopeOfPlayers(Builder $query, $data = '')
    {
        if ($data === '') return $query;
        return $query->where('players', $data);
    }
}
