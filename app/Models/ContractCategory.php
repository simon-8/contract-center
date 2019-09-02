<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/11
 * Time: 10:41
 */
namespace App\Models;

use App\Traits\ModelTrait;

class ContractCategory extends Base
{
    use ModelTrait;

    protected $table = 'contract_category';

    protected $fillable = [
        'name',
        'players',
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
     * @return ContractCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCats()
    {
        return $this->select(['id', 'name'])->get()->pluck('name', 'id');
    }
}
