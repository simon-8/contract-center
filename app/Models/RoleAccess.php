<?php
/**
 * Note: 权限
 * User: Liu
 * Date: 2018/11/20
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    public $table = 'role_access';

    public $timestamps = false;

    public $fillable = [
        'name',
        'route'
    ];

    /**
     * @return array
     */
    public function accessLists()
    {
        $accessLists = $this->all()->toArray();
        $data = [];
        foreach ($accessLists as $k => $access) {
            if (\Str::contains($access['route'], '*')) {
                $prefix = substr($access['route'], 0, strpos($access['route'], '.')+1);
                $data[$prefix]['name'] = $access['name'];
                unset($accessLists[$k]);
            }
        }
        foreach ($data as $prefix => $name) {
            foreach ($accessLists as $access) {
                if (\Str::startsWith($access['route'], $prefix)) {
                    $data[$prefix]['child'][$access['id']] = $access;
                }
            }
        }
        return $data;
    }
}