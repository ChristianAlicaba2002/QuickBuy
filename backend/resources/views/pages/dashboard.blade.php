<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/shop.png" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard Admin</title>
</head>

<body>
    <nav>
        @include('components.sidebar')
        @yield('navigation')
    </nav>

    @if (session('error'))
        <script>
            alert("{{ session('error') }}")
        </script>
    @endif
    @if (session('success'))
        <script>
            alert("{{ session('success') }}")
        </script>
    @endif

    <div class="main-container">

         <div class="header-section" style="">
            <div class="box" style="">
                <h3>Total Products</h3>
                <p style="">{{ count($products) ?? 0}}</p>
            </div>
            <div class="box" ">
                <h3>Low Stock</h3>
                <p style="color: red">{{ $lowStockCount ?? 0}}</p>
            </div>
            <div class="box">
                <h3>Total Revenue</h3>
                <p>&#8369;{{ number_format($totalRevenue ?? 0, 2) }}</p>
            </div>
            <div class="box">
                <h3>Total Orders</h3>
                <p>{{ $totalOrders ?? 0 }}</p>
            </div>
        </div>


        {{-- Add Product Modal Section --}}
        <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <div class="modal-header">
                    <img src="../../../assets/add.png" class="addLogo" alt="">
                    <h2>Add Product</h2>
                </div>
                <form action="{{ route('create.product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div>
                        <label for="category">Category:</label>
                        <input type="text" id="category" name="category" required>
                    </div>
                    <div>
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>
                    <div>
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" required>
                    </div>
                    <div>
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    <div>
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" required>
                    </div>
                    <div>
                        <img src="" alt="" id="imagePreview" srcset=""
                            style="max-width: 100%; display: none;">
                    </div>
                    <div style="margin-top: 10px;">
                        <button class="submit-btn" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- End of Add Product Modal Section --}}


        {{-- Edit Product Modal Section --}}
         <div id="editProductModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeEditModal">&times;</span>
                <div class="modal-header">
                    <img src="../../../assets/pencil.png" class="addLogo" alt="">
                    <h2>Edit Product</h2>
                </div>
                <form method="POST" class="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name">Product Name:</label>
                        <input type="text" id="nameId" name="name" required>
                    </div>
                     <div>
                        <label for="categoryId">Category:</label>
                        <input type="text" id="categoryId" name="category" readonly>
                    </div>
                    <div>
                        <label for="price">Price:</label>
                        <input type="number" id="priceId" name="price" step="0.01" required>
                    </div>
                    <div>
                        <label for="stock">Stock:</label>
                        <input type="number" id="stockId" name="stock" required>
                    </div>
                    <div>
                        <label for="description">Description:</label>
                        <textarea id="descriptionId" name="description" required></textarea>
                    </div>
                    <div>
                        <label for="image">Image:</label>
                        <input type="file" id="imageId" name="image" required>
                    </div>
                    <div>
                        <img src="" alt="" id="imagePreviewId" srcset=""
                            style="max-width: 100%; display: none;">
                    </div>
                    <div style="margin-top: 10px;">
                        <button class="submit-btn" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- End of Edit Product Modal Section --}}

        {{-- Add Product Button --}}
        <button id="addProductBtn">Add Product</button>
    
        {{-- Table Section --}}
        <div class="table-container">
            <div class="search-container">
                <input type="search" class="" name="search" id="search" placeholder="Search products...">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($products) > 0)
                        @foreach ($products as $item)
                            <tr>
                                <td>{{ $item->product_id }}</td>
                                <td>
                                    <img src="{{ asset('/images/' . $item->image) }}" alt="{{ $item->name }}"
                                        width="100px" height="50px">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category }}</td>
                                <td>&#8369;{{ $item->price }}</td>
                                <td>{{ $item->stock }}</td>
                                <td><textarea name="description" id="" cols="20" rows="5" readonly>{{ $item->description }}</textarea></td>
                               <td>{{ $item->created_at->format('F d, Y') }}</td>
                                <td>
                                    <div class="action-btn">
                                        
                                        <button title="edit" class="edit-btn" type="button" onclick="editProduct('{{ $item->product_id }}' , '{{ $item->name }}' ,'{{$item->category}}','{{ $item->description }}' , '{{ $item->price }}' , '{{ $item->stock }}' , '{{ $item->image }}')">
                                            <img  src="../../assets/edit.png" alt="Edit icon">
                                        </button>
                                        <form action="{{route('archive.product', $item->product_id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button title="archive" class="delete-btn" type="submit">
                                                <img  src="../../assets/archive (1).png" alt="Delete icon">   
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="text-align: center; color: red; font-size: 1.1rem; padding: 15px 0;">No products available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>

    <script>
        const modal = document.getElementById('productModal');
        const btn = document.getElementById('addProductBtn');
        const editbtn = document.getElementById('closeEditModal');
        const span = document.getElementById('closeModal');
        btn.onclick = function() {
            modal.style.display = 'block';
        }
        span.onclick = function() {
            modal.style.display = 'none';
        }
        editbtn.onclick = function() {
            const editModal = document.getElementById('editProductModal');
            editModal.style.display = 'none';
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Function to handle image preview
        document.getElementById('image').addEventListener('change', function(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });

        // Function to populate the modal with product data for editing
        function editProduct(id, name,category, description, price, stock, image) {
            const modal = document.getElementById('editProductModal');
            modal.style.display = 'block';

            document.getElementById('nameId').value = name;
            document.getElementById('categoryId').value = category;
            document.getElementById('descriptionId').value = description;
            document.getElementById('priceId').value = price;
            document.getElementById('stockId').value = stock;
            document.getElementById('imageId').value = ''; // Reset file input
            document.getElementById('imagePreviewId').src = `/${image}/`;

            // Update form action to include product ID for editing
            const form = modal.querySelector('form');
            form.method = "POST";
            form.enctype = "multipart/form-data";
            form.action =  `update/${id}`;
        }


        // Search functionality
        // This script filters the table rows based on the search input
        document.getElementById('search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let found = false;

                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                    }
                });

                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
