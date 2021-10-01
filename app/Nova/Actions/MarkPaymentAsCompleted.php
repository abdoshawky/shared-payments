<?php

namespace App\Nova\Actions;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MarkPaymentAsCompleted extends Action
{
    public $name = "Mark as completed";

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach($models as $model) {
            $model->update(['completed' => true]);
        }
    }
}
