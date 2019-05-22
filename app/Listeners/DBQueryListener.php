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
        $tmp = str_replace('?', '"'.'%s'.'"', $event->sql);
        $qBindings = [];
        foreach ($event->bindings as $key => $value) {
            if ($value instanceof \DateTime) {
                $value = $value->format('Y-m-d H:i:s');
            }
            if (is_numeric($key)) {
                $qBindings[] = $value;
            } else {
                $tmp = str_replace(':'.$key, '"'.$value.'"', $tmp);
            }
        }
        $tmp = vsprintf($tmp, $qBindings);
        $tmp = str_replace("\\", "", $tmp);
        \Log::info(' [sql] ('.$event->time.'ms) '.$tmp);
        //if (env('APP_ENV', 'production') == 'local') {
        //
        //}
    }
}
