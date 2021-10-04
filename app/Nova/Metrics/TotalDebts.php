<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalDebts extends Value
{
    public $name = "Debts";
    
    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        if($request->range == 'total') {
            return $this->result($request->user()->debts)
                ->allowZeroResult()
                ->format('0,0.00');
        }

        $user = User::find($request->range);
        return $this->result($request->user()->getDebitsToUser($user))
            ->allowZeroResult()
            ->format('0,0.00');
    }

    public function ranges()
    {
        $ranges = [
            'total' => 'Total'
        ];

        $ranges += User::where('id', '!=', auth()->id())->pluck('name', 'id')->toArray();

        return $ranges;
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'total-debts';
    }
}
