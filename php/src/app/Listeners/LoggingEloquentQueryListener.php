<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LoggingEloquentQueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($query)
    {
        if (app()->environment() !== 'production' || config('logging.query_logging')) {

			$message = [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
                'connection' => $query->connectionName,
            ];

            Log::channel('sql')->info(json_encode($message, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
       }
    }
}
