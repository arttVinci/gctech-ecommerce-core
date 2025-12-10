<?php

namespace App\Livewire;

use Exception;
use Throwable;
use App\Data\CartData;
use Livewire\Component;
use App\Data\RegionData;
use App\Data\CheckoutData;
use App\Data\CustomerData;
use App\Data\ShippingData;
use Illuminate\Support\Number;
use App\Rules\ValidPaymentHash;
use App\Rules\ValidShippingHash;
use App\Service\CheckoutService;
use App\Events\SalesOrderCreated;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Service\RegionQueryService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Contract\CartServiceInterface;
use App\Service\ShippingMethodService;
use Spatie\LaravelData\DataCollection;
use App\Service\PaymentMethodQueryService;

class Checkout extends Component
{
    protected Collection $daftarItem;

    public array $data = [
        'full_name' => null,
        'no_telp' => null,
        'email' => null,
        'address_line' => null,
        'destination_region_code' => null,
        'shipping_hash' => null,
        'payment_method_hash'  =>  null
    ];
    public array $summaries = [
        'sub_total' => 0,
        'sub_total_formatted' => '-',
        'shipping_total' => 0,
        'shipping_total_formatted' => '-',
        'grand_total' => 0,
        'grand_total_formatted' => '-'
    ];
    public array $region_selector = [
        'keyword' => null,
        'region_selected' => null
    ];
    public array $shipping_selector = [
        'shipping_method' => null
    ];

    public array $payment_selector = [
        'payment_selected'  =>  null
    ];

    public function mount()
    {
        if (!Gate::inspect('is_stock_available')->allowed()) {
            redirect()->route('cart');
        }

        if ($this->cart->total_quantity < 0) {
            redirect()->route('cart');
        }

        $this->calculatedTotal();
    }

    public function render()
    {
        return view('livewire.checkout', [
            'cart' => $this->cart
        ]);
    }

    public function rules()
    {
        return [
            'data.full_name' => ['required', 'min:3', 'max:50'],
            'data.email' => ['required', 'email', 'max:50'],
            'data.no_telp' => ['required', 'min:7', 'max:13'],
            'data.address_line' => ['required', 'max:255'],
            'data.destination_region_code' => ['required', 'exists:regions,code'],
            'data.shipping_hash' => ['required', new ValidShippingHash()],
            'data.payment_method_hash'  => ['required', new ValidPaymentHash()]
        ];
    }

    public function getCartProperty(CartServiceInterface $cart): CartData
    {
        return $cart->all();
    }

    public function getRegionsProperty(RegionQueryService $region_service): DataCollection
    {
        if (!data_get($this->region_selector, 'keyword')) {
            $data = [];
            return new DataCollection(RegionData::class, $data);
        }

        return $region_service->searchRegionByName(data_get($this->region_selector, 'keyword'));
    }

    public function getRegionProperty(RegionQueryService $region_service): ?RegionData
    {
        $region_selected = data_get($this->region_selector, 'region_selected');

        if (!$region_selected) {
            return null;
        }

        return $region_service->searchRegionByCode($region_selected);
    }

    public function getShippingMethodsProperty(
        RegionQueryService $region_query,
        ShippingMethodService $shipping_service
    ): DataCollection|Collection {
        if (!data_get($this->data, 'destination_region_code')) {
            return new DataCollection(ShippingData::class, []);
        }

        $origin_code = config('shipping.shipping_origin_code');
        return $shipping_service->getShippingMethods(
            $region_query->searchRegionByCode($origin_code),
            $region_query->searchRegionByCode(str(data_get($this->data, 'destination_region_code'))),
            $this->cart
        )->toCollection()->groupBy('service');
    }

    public function getShippingMethodProperty(ShippingMethodService $shipping_service): ?ShippingData
    {
        if (!data_get($this->data, 'shipping_hash') || !data_get($this->data, 'destination_region_code')) {
            return null;
        }

        $data = $shipping_service->getShippingMethod(data_get($this->data, 'shipping_hash'));

        if ($data == null) {
            $this->addError('shipping_hash', 'Shipping Cost Missing!');
            redirect()->route('checkout');
        }

        return $data;
    }

    public function getPaymentMethodsProperty(PaymentMethodQueryService $payment_service): DataCollection
    {
        return $payment_service->getPaymentMethods();
    }

    public function calculatedTotal()
    {
        data_set($this->summaries, 'sub_total', $this->cart->total);
        data_set($this->summaries, 'sub_total_formatted', $this->cart->total_price);

        $shipping_cost = $this->shipping_method?->cost ?? 0;
        data_set($this->summaries, 'shipping_total', $shipping_cost);
        data_set($this->summaries, 'shipping_total_formatted', Number::currency($shipping_cost));

        $grand_total = $this->cart->total + $shipping_cost;
        data_set($this->summaries, 'grand_total', $grand_total);
        data_set($this->summaries, 'grand_total_formatted', Number::currency($grand_total));
    }

    public function updatedRegionSelectorRegionSelected($value)
    {
        data_set($this->data, 'destination_region_code', $value);
    }

    public function updatedShippingSelectorShippingMethod($value)
    {
        data_set($this->data, 'shipping_hash', $value);
        $this->calculatedTotal();
    }

    public function updatedPaymentSelectorPaymentSelected($value)
    {
        data_set($this->data, 'payment_method_hash', $value);
    }

    public function placeAnOrder(CartServiceInterface $cart)
    {
        $validation = $this->validate();

        try {
            $shipping_method = app(ShippingMethodService::class)->getShippingMethod(data_get($validation, 'data.shipping_hash'));
            $payment_method  = app(PaymentMethodQueryService::class)->getPaymentMethodHash(data_get($validation, 'data.payment_method_hash'));

            $data_checkout = CheckoutData::from([
                'customer'      =>      CustomerData::from(data_get($validation, 'data')),
                'address_line'  =>      data_get($validation, 'data.address_line'),
                'origin'        =>      $shipping_method->origin,
                'destination'   =>      $shipping_method->destination,
                'cart'          =>      $this->cart,
                'shipping'      =>      $shipping_method,
                'payment'       =>      $payment_method
            ]);
            $service = app(CheckoutService::class);
            $sales_order = $service->makeAnOrder($data_checkout);
            $cart->clear();

            return redirect()->route('order-confirmed', $sales_order->rtx_id);
        } catch (Exception $e) {
            Log::error("Error Checkout: " . $e->getMessage());
        }
    }
}
