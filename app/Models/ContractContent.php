<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class ContractContent extends Model
{
    use ModelTrait;

    protected $table = 'contract_content';

    protected $fillable = [
        'tpl',
        'fill',
    ];

    public $timestamps = false;

    /**
     * @param $value
     * @return mixed
     */
    //public function getTplAttribute($value)
    //{
    //    return json_decode($value, true);
    //}

    /**
     * @param $value
     */
    public function setTplAttribute($value)
    {
        $this->attributes['tpl'] = json_encode($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    //public function getFillAttribute($value)
    //{
    //    return json_decode($value, true);
    //}

    /**
     * @param $value
     */
    public function setFillAttribute($value)
    {
        $this->attributes['fill'] = json_encode($value, JSON_FORCE_OBJECT);
    }
}
