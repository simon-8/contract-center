<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractFolder extends Model
{
    protected $table = 'contract_folder';

    protected $fillable = [
        'name',
        'thumb',
        'userid',
        'contract_id',
    ];

    /**
     * 用户id
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfUserid($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('userid', $data);
    }
}
