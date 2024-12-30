<?php

namespace App\Filters;

use Closure;

class TaskPriorityFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->filled('priority') && request()->input('priority') != null) {
            $query->where('priority', request()->input('priority'));
        }
        return $next($query);
    }
}
