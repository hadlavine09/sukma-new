<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets_backend/css/main.css')}}"> --}}
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        .material-half-bg {
            height: 100vh;
            background-color: #e7e7e7;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }

        .material-half-bg .cover {
            background-color: #00695C;
            height: 50vh;
        }

        * {
            box-sizing: border-box;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            /* background: linear-gradient(135deg, #4caf50, #a5d6a7); Green gradient */
            font-family: 'Poppins', sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-content {
            width: 100%;
            max-width: 100%;
            padding: 40px 32px 48px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-content h3 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 12px;
            color: #5a34ff;
            letter-spacing: 1.3px;
        }

        .login-content p.subtitle {
            margin: 0 0 36px;
            color: #666;
            font-weight: 500;
            font-size: 1rem;
            text-align: center;
        }

        form {
            width: 100%;
        }

        .form-group {
            position: relative;
            margin-bottom: 34px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 16px 12px 16px 12px;
            font-size: 1rem;
            border: 2px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease;
            background: transparent;
            font-weight: 600;
            color: #222;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #00695C;
            box-shadow: 0 0 8px #00695C;
        }

        label {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            background: transparent;
            padding: 0 6px;
            color: #999;
            font-size: 1rem;
            pointer-events: none;
            font-weight: 500;
            transition: all 0.25s ease;
            user-select: none;
        }

        input:focus+label,
        input:not(:placeholder-shown)+label {
            top: -10px;
            font-size: 0.8rem;
            color: #00695C;
            ;
            font-weight: 700;
            letter-spacing: 0.7px;
        }

        button.login-btn {
            width: 100%;
            padding: 15px 0;
            background-color: #00695C;
            ;
            color: white;
            font-weight: 700;
            font-size: 1.15rem;
            border: none;
            border-radius: 10px;
            box-shadow: 0 8px 18px #028f7f;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button.login-btn:hover,
        button.login-btn:focus {
            background-color: #00695C;
            box-shadow: 0 12px 30px #00695C;
            outline: none;
        }

        .error-message {
            color: #d9534f;
            background-color: #f9d6d5;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 24px;
            font-weight: 600;
            display: none;
            user-select: none;
        }

        @media (max-width: 480px) {
            .login-content {
                padding: 32px 24px 40px;
                width: 90%;
            }

            .login-content h3 {
                font-size: 2rem;
            }
        }
    </style>

</head>

<body>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        {{-- <img class="login-head" src="{{ asset('logo/logosukma2.svg') }}" style="padding-bottom: 22px;" alt="Login Icon"> --}}
        <svg style="padding-right: 20px " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120" height="108" viewBox="0 0 200 108">
            <image id="logosukma" x="58" y="15" width="127" height="85" xlink:href="data:img/png;base64,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"/>
          </svg>
        <div id="error-message" class="error-message" role="alert" aria-live="assertive"></div>
        <form class="login-form" method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder=" " name="email" value="{{ old('email') }}" required autofocus>
                <label for="email">EMAIL</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder=" " name="password" required>
                <label for="password">PASSWORD</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 btn-container d-grid">
                <button type="submit" class="login-btn">
                    <i class="bi bi-box-arrow-in-right me-2 fs-5"></i>SIGN IN
                </button>
            </div>
            <a href="{{ route('auth.google') }}" class="btn btn-danger">
                <i class="fab fa-google"></i> Login with Google
            </a>
            <a href="{{ route('register2') }}" class="btn btn-danger">
                <i class="fab fa-google"></i> Register
            </a>
        </form>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('assets_backend/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets_backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets_backend/js/main.js') }}"></script>
    <script type="text/javascript">
        // Login Page Flipbox control
        $('.login-content [data-toggle="flip"]').click(function() {
            $('.login-box').toggleClass('flipped');
            return false;
        });
    </script>
</body>

</html>
