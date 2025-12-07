<?php

declare(strict_types=1);

namespace App\States\SalesOrder;

use App\States\SalesOrder\SalesOrderState;

class Shipping extends SalesOrderState
{
    public function label(): string
    {
        return "Pesanan Sedang dalam Pengiriman";
    }
}
