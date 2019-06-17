<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractData extends Model
{
    protected $table = 'contract_data';

    protected $fillable = [
        'userid',
        'contract_id',
        'folder_id',
        'name',
        'linkurl',
        'filetype',
        'filesize',
    ];
}
