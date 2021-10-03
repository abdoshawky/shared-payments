<?php

namespace App\Nova\Actions;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MarkPaymentShareAsCompleted extends Action
{
    public $name = "Mark as completed";

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $paymentShare) {
            // update the share to be completed
            $paymentShare->update(['completed' => true]);

            // if all the siblings are completed the update the payment to be completed
            if($paymentShare->payment->shares()->where('completed', 0)->count() == 0) {
                $paymentShare->payment()->update(['completed' => true]);
            }
        }
    }
}
