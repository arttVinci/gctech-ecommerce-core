<?php

declare(strict_types=1);

namespace App\States\SalesOrder;

use App\States\SalesOrder\SalesOrderState;

class Pending extends SalesOrderState
{
    public function label(): string
    {
        return "Menunggu Pembayaran";
    }
}
