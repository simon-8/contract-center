<?php

namespace App\Listeners;

use Log;

class DBQueryListener
{
    /**
     * @param $event
     */
    public function handle($event)
    {
        if (env('APP_ENV', 'production') == 'local') {
            $sql = str_replace("?", "'%s'", $event->sql);

            $log = vsprintf($sql, $event->bindings);

            Log::info($log);
        }
    }
}
