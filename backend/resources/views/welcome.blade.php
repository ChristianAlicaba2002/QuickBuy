<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/shop.png" type="image/x-icon">
    <link rel="stylesheet" href="css/admin.css">
    <title>QuickBuy Admin</title>
</head>
<body>
        @if (session('error'))
            <label for="">{{session('error')}}</label>
        @endif
        <div class="main-container">
            <form action="{{route('admin.login')}}" method="post">
                @csrf
                <div class="forms">

                    <h1>Welcome Admin</h1>
                    <p>login to managed your products</p>
                    <label for="">Email</label>
                    <input type="email" name="email" placeholder="Enter your email">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password">
                    <label for="showPassword">
                        <input type="checkbox" name="" id="showPassword">
                        Show password
                    </label>
                    <div class="button">
                        <button type="submit">login</button>
                    </div>
                </div>
            </form>
        </div>
            

        <script>
            const password  = document.getElementById('password');
            document.getElementById('showPassword').addEventListener('click', () => {
                password.type == 'password' ? password.type = 'text' : password.type = 'password';
            })
        </script>
</body>
</html>