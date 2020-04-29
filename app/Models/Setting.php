<?php
/**
 * Note: 设置
 * User: Liu
 * Date: 2018/3/12
 * Time: 22:11
 */
namespace App\Models;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use ModelTrait;

    public $table = 'settings';

    public $timestamps = false;

    protected $fillable = [
        'item',
        'name',
        'value',
    ];
}
