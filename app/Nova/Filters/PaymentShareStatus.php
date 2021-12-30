<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class PaymentShareStatus extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('completed', $value);
    }

    public function options(Request $request): array
    {
        return [
            'Completed' => 1,
            'In-Completed' => 0
        ];
    }
}
