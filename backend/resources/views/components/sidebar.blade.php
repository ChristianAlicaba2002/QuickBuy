@section('navigation')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/navbar.css">
    <title>QuickBuy Admin</title>
</head>

<body>
            <nav class="nav-container">
        <div class="logo">
            <img id="logoimg" src="../../../assets/shop.png" alt="logo img">
        </div>
        <div class="other-categories" id="other-categories">
            <ul>
                <li>
                    <img src="../../../assets/dashboard.png" alt="logo img">
                    <a href="{{route('dashboard')}}" class="list-item">
                        Dashboard
                    </a>
                </li>
                <li>
                    <img src="../../../assets/user.png" alt="logo img">
                    <a href="{{route('user-management')}}" class="list-item">
                        User Management
                    </a>
                </li>
                <li>
                    <img src="../../../assets/wall-clock.png" alt="logo img">
                    <a href="{{route('order-pending')}}" class="list-item">
                        Order's Pending
                    </a>
                </li>
                <li>
                    <img src="../../../assets/archive.png" alt="logo img">
                    <a href="{{route('archive')}}" class="list-item">
                        Archived
                    </a>
                </li>
            </ul>
        </div>
        <div class="logout-button">
            <form action="{{ route('admin.logout') }}" method="post">
                @csrf
                <button type="submit">
                    <img src="../../../assets/logout.png">
                </button>
            </form>
        </div>
    </nav>
    
    
    <script>
        const lists = document.querySelectorAll('.list-item');
        const categories = document.querySelector('.nav-container');
        
        categories.addEventListener('mouseover', () => {
            categories.style.maxWidth = '220px';
            categories.style.boxShadow = '0 4px 16px rgba(0, 0, 0, 0.2)';
            lists.forEach(element => {
                element.style.display = 'block';
            });
        });
        
        categories.addEventListener('mouseout', () => {
            categories.style.maxWidth = '80px';
            categories.style.boxShadow = 'none';
            lists.forEach(element => {
                element.style.display = 'none';
            });
            
        });
        
    </script>
</body>

</html>
    @endsection
