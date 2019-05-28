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
            if ($access['route'] === '*') {
                $data['god']['name'] = $access['name'];
                //unset($accessLists[$k]);
                continue;
            }
            if (\Str::contains($access['route'], '*')) {
                $route = str_replace('admin.', '', $access['route']);
                $prefix = substr($route, 0, strpos($route, '.')+1);
                $data[$prefix]['name'] = $access['name'];
                unset($accessLists[$k]);
            }
        }
        foreach ($data as $prefix => $name) {
            foreach ($accessLists as $access) {
                if ($access['route'] === '*' && $prefix === 'god') {
                    $data[$prefix]['child'][$access['id']] = $access;
                    continue;
                }
                $route = str_replace('admin.', '', $access['route']);
                if (\Str::startsWith($route, $prefix)) {
                    $data[$prefix]['child'][$access['id']] = $access;
                }
            }
        }
        return $data;
    }
}