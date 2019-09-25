<?php
/*
 * 所有权限使用 config/routes.php中的配置
 *
 * */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AuthService;
use App\Models\RoleAccess;

class SyncAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync config/menus.php to role_access table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param AuthService $authService
     * @param RoleAccess $roleAccess
     */
    public function handle(AuthService $authService, RoleAccess $roleAccess)
    {
        $routes = config('menus');
        $ingnoreGroups = $authService->getIgnorePermissionGroups();
        foreach ($routes as $route => $name) {
            foreach ($ingnoreGroups as $group) {
                if (\Str::startsWith($route, $group)) {
                    unset($routes[$route]);
                }
            }
        }
        if ($routes) {
            $roleAccess->truncate();
            $this->line('Access表已清空');
        }
        $data = [];
        $data[] = [
            'name' => '所有权限',
            'route' => '*'
        ];
        foreach ($routes as $route => $name) {
            $data[] = [
                'name' => $name,
                'route' => $route
            ];

        }
        $roleAccess->insert($data);
        $this->line('Access表更新成功');
    }
}
