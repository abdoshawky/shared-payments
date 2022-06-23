<?php

namespace App\Nova;

use App\Nova\Actions\MarkPaymentAsCompleted;
use Benjacho\BelongsToManyField\BelongsToManyField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use PosLifestyle\DateRangeFilter\DateRangeFilter;

class Payment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Payment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')
                ->sortable(),
            Text::make('Name')
                ->rules(['required']),
            Number::make('Amount')
                ->step('0.01')
                ->rules(['required']),
            BelongsTo::make('Paid by', 'paidBy', User::class),
            BelongsTo::make('Created by', 'createdBy', User::class)
                ->onlyOnDetail(),
            Boolean::make('Completed')
                ->exceptOnForms(),

            BelongsToManyField::make('Users', 'activeUsers', User::class)
                ->options(\App\Models\User::where('active', true)->get())
                ->rules(['required'])
                ->canSelectAll(),

            DateTime::make('Created at')->format('YYYY-MM-DD h:mm A')->exceptOnForms(),

            HasMany::make('Payment shares', 'shares', PaymentShare::class)
        ];
    }

    public function actions(Request $request): array
    {
        return [
            MarkPaymentAsCompleted::make()
        ];
    }

    public function filters(Request $request): array
    {
        return [
            new DateRangeFilter('Created at', 'created_at')
        ];
    }
}
