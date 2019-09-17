<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class ContractTplRule extends Base
{
    use ModelTrait;

    protected $table = 'contract_tpl_rules';

    protected $fillable = [
        'catid',
        'content',
        'listorder',
    ];

    /**
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfContent($query, $data = '')
    {
        if (empty($data)) return $query;
        return $query->where('content', 'like', "%{$data}%");
    }
}
