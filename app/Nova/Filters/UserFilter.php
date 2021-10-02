<?php

namespace App\Nova\Filters;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class UserFilter extends Filter
{
    public $name = "Users";

    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('user_id', $value);
    }

    public function options(Request $request): array
    {
        return User::pluck('id', 'name')->toArray();
    }
}
