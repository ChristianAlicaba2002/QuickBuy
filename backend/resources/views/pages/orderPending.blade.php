<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/pendingOrder.css">
    <title>Order Pending</title>
</head>

<body>
    <nav>
        @include('components.sidebar')
        @yield('navigation')
    </nav>
    <main class="pendingOrder-container">
        <div class="pending-order-title">
            <h1>Pending Orders</h1>
        </div>
        <table class="pendingOrder-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Product ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($orders) > 0)
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>
                                <img src="{{ asset('/images/' . $order->image) }}" alt="{{ $order->name }}"
                                    width="50" height="50">
                            </td>
                            <td>{{ $order->product_id }}</td>
                            <td>********</td>
                            <td>{{ $order->product_name }}</td>
                            <td>&#8369;{{ number_format($order->price, 2) }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>&#8369;{{ number_format($order->total_price, 2) }}</td>
                            <td
                                style="color: {{ $order->status == 'Pending' ? 'orange' : ($order->status == 'Accepted' ? 'green' : 'red') }}">
                                <label for=""
                                    class="{{ $order->status == 'Pending' ? 'isPending' : ($order->status == 'Accepted' ? 'isAccepted' : 'red') }}">{{ $order->status }}</label>
                            </td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('pending.order', $order->order_id) }}" method="post">
                                    @csrf
                                    @if ($order->status == 'Accepted')
                                        <button disabled type="submit" style="cursor: not-allowed">Accept</button>
                                    @else
                                        <button type="submit" onclick="return confirm('Are you sure you want to accept this order?')">Accept</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="11" style="text-align: center; color: red; font-size: 1.1rem; padding: 15px 0;">
                            No Orders Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </main>
</body>

</html>
