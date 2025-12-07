<?php

declare(strict_types=1);

namespace App\States\SalesOrder;

use App\States\SalesOrder\SalesOrderState;

class Cancel extends SalesOrderState
{
    public function label(): string
    {
        return "Pesanan di Batalkan";
    }
}
