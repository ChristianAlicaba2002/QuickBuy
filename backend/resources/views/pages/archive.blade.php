<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/shop.png" type="image/x-icon">
    <link rel="stylesheet" href="css/archive.css">
    <title>Archive Page</title>
</head>

<body>
    <nav>
        @include('components.sidebar')
        @yield('navigation')
    </nav>
    <div class="table-container">
        <h2>Archived Products</h2>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vel, eveniet.</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archiveProducts as $product)
                    <tr>
                        <td>{{ $product->product_id }}</td>
                        <td>
                            <img src="{{ asset('/images/' . $product->image) }}" alt="Product Image">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td> <textarea name="" id="" cols="20" rows="5" readonly>{{ $product->description }}</textarea></td>
                        <td>{{ $product->created_at}}</td>
                        <td class="action-btn">
                            <form action="{{ route('restore.product', $product->product_id )}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button title="restore" type="submit">
                                    <img src="../../assets/archive (1).png" alt="Delete icon">
                                </button>
                            </form>
                            <form action="{{ route('delete.product', $product->product_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit">
                                    <img src="../../assets/delete.png" alt="Delete icon">
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
