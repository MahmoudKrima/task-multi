<?php

namespace App\Filters;

use Closure;

class TaskDueDateFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->filled('due_date') && request()->input('due_date') != null) {
            $query->where('due_date', request()->input('due_date'));
        }
        return $next($query);
    }
}
