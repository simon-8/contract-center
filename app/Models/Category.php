<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/4/8
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categorys';

    public $fillable = [
        'pid',
        'name',
        'listorder'
    ];

    public function child()
    {
        return $this->hasMany('App\Models\Category', 'pid', 'id');
    }

    //public function allChildrenCategorys()
    //{
    //    return $this->childCategory()->with('allChildrenCategorys');
    //}

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'pid', 'id');
    }
}