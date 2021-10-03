<?php

namespace App\Nova\Filters;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SharePaidBy extends Filter
{
    public $name = "Paid by";

    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->whereRelation('paidBy', 'users.id', $value);
    }

    public function options(Request $request): array
    {
        return User::pluck('id', 'name')->toArray();
    }
}
