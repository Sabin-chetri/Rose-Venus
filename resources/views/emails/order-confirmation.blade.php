<x-mail::message>
# Thank you for your order!

Hi **{{ $order->user->name }}**,

Your order **#{{ $order->id }}** has been placed successfully.

## Order Summary
| Item | Qty | Price |
|:-----|:---:|------:|
@foreach ($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | Rp {{ number_format($item->subtotal, 0, ',', '.') }} |
@endforeach

**Total: Rp {{ number_format($order->total, 0, ',', '.') }}**

### Shipping Address
{{ $order->shipping_address }}

@if ($order->phone)
**Phone:** {{ $order->phone }}
@endif

We'll notify you when your order ships.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
