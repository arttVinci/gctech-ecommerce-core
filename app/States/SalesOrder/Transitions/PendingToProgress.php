<?php

declare(strict_types=1);

namespace App\States\SalesOrder\Transitions;

use App\Models\SalesOrder;
use App\Data\SalesOrderData;
use Spatie\ModelStates\Transition;
use App\States\SalesOrder\Progress;
use App\Events\SalesOrderProgressEvent;
use Illuminate\Support\Carbon;

class PendingToProgress extends Transition
{
    public function __construct(public SalesOrder $sales_order) {}

    public function handle()
    {
        $this->sales_order->update([
            'status'   =>   Progress::class,
            'payment_pay_at' => Carbon::now()
        ]);

        event(new SalesOrderProgressEvent(
            SalesOrderData::fromModel($this->sales_order)
        ));

        return $this->sales_order;
    }
}
