<?php

namespace App\Filters;

use Closure;

class TaskCreatorFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->filled('created_by') && request()->input('created_by') != null) {
            $query->where('created_by', request()->input('created_by'));
        }
        return $next($query);
    }
}
