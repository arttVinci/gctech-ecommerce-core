<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

/*
 * ===== MODEL / DATA =====
 */

class Controller {}

class mobil
{
    public function __construct(
        public string $merk,
        public string $warna,
        public int $kecepatan = 0
    ) {}

    public function jalan(int $kecepetan): int
    {
        return $this->kecepatan = $kecepetan;
    }

    public function berhenti(int $kecepatan): int
    {
        return $this->kecepatan = $kecepatan;
    }
}

class bankAccount
{
    public function __construct(
        public string $nama,
        public int $saldo = 0
    ) {}

    public function deposit($depo)
    {
        return $this->saldo + $depo;
    }

    public function tarik($tarik)
    {
        return $this->saldo - $tarik;
    }

    public function cekSaldo()
    {
        return $this->saldo;
    }
}

class user
{
    public function __construct(
        public string $name,
        public string $email
    ) {}
}

class EmailService
{
    public function kirim(User $user, $pesan)
    {
        echo "Email terkirim ke $user->email: $pesan";
    }
}

class Produk
{
    public function __construct(
        public string $name,
        public int $harga
    ) {}
}

class Keranjang
{
    public Produk $produk;

    public function tambahProduk(Produk $produk)
    {
        return $this->produk->harga + $produk->harga;
    }

    public function totalHarga()
    {
        return $this->produk->harga;
    }
}
