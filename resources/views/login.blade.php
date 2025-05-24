<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="{{ asset('/') }}template/logo.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .login-heading {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            font-size: 24px;
            color: #343a40;
        }

        .form-label {
            font-weight: bold;
            color: #495057;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .form-check {
            margin-bottom: 15px;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        .login-options {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: center;
        }

        .login-options button {
            flex: 1;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: #fff;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .login-options button:hover {
            background-color: #e9ecef;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            color: #6c757d;
        }

        .signup-link {
            text-align: right;
            margin-top: 10px;
        }

        .signup-link a {
            text-decoration: none;
            color: #007bff;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .password-input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            background: none;
            border: none;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="text-center">
            <img src="{{ asset('/') }}template/logo.png" width="80" alt="" alt="">
        </div>
        <h2 class="login-heading">Login</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('do_login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Email Address" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="password-input-group">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Toggle the eye icon
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>

</html>
