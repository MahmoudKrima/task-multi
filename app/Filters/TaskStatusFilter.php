<?php

namespace App\Filters;

use Closure;

class TaskStatusFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->filled('status') && request()->input('status') != null) {
            $query->where('status', request()->input('status'));
        }
        return $next($query);
    }
}
