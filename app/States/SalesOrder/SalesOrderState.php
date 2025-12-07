<?php

declare(strict_types=1);

namespace App\States\SalesOrder;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use App\States\SalesOrder\Transitions\PendingToCancel;
use App\States\SalesOrder\Transitions\PendingToProgress;
use App\States\SalesOrder\Transitions\ProgressToShipping;
use App\States\SalesOrder\Transitions\ProgressToCompleted;
use App\States\SalesOrder\Transitions\ShippingToCompleted;

abstract class SalesOrderState extends State
{
    abstract public function label(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->AllowTransition(Pending::class, Progress::class, PendingToProgress::class)
            ->allowTransition(Pending::class, Cancel::class, PendingToCancel::class)
            ->allowTransition(Progress::class, Completed::class, ProgressToCompleted::class)
            ->allowTransition(Progress::class, Shipping::class, ProgressToShipping::class)
            ->allowTransition(Shipping::class, Completed::class, ShippingToCompleted::class);
    }
}
