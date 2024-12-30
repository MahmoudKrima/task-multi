<?php

namespace App\Filters;

use Closure;

class TitleFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->filled('title') && request()->input('title') != null) {
            $query->where('title', 'LIKE', '%' . request()->input('title') . '%');
        }
        return $next($query);
    }
}
