<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContractContent
 *
 * @property int $id
 * @property mixed $content
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractContent whereId($value)
 * @mixin \Eloquent
 */
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
