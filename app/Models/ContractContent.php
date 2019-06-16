<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractContent extends Model
{
    protected $table = 'contract_content';

    protected $fillable = [
        'content',
    ];

    public $timestamps = false;

    /**
     * @param $value
     * @return mixed
     */
    public function getContentAttribute($value)
    {
        return unserialize($value);
    }

    /**
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = serialize($value);
    }
}
