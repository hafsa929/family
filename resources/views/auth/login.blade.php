<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>تسجيل الدخول | نظام التكافل العائلي</title>

    <link rel="icon" type="image/png"
          href="{{ asset('assets/img/favicon.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
          rel="stylesheet">

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}"
          rel="stylesheet">

    <link href="{{ asset('assets/css/nucleo-svg.css') }}"
          rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js"
            crossorigin="anonymous"></script>

    <!-- Argon Dashboard -->
    <link href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}"
          rel="stylesheet">


    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background: #f8f9fa;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .login-container {
            width: 100%;
            max-width: 1200px;
            min-height: 650px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.10);
            display: flex;
            flex-direction: row;
        }

        /*
        |--------------------------------------------------------------------------
        | قسم تسجيل الدخول
        |--------------------------------------------------------------------------
        */

        .login-section {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background: #ffffff;
        }

        .login-content {
            width: 100%;
            max-width: 430px;
        }

        .login-title {
            font-size: 30px;
            font-weight: 700;
            color: #344767;
            margin-bottom: 10px;
        }

        .login-description {
            color: #67748e;
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 35px;
        }

        .form-label {
            font-weight: 600;
            color: #344767;
            margin-bottom: 8px;
        }

        .login-input {
            height: 52px;
            border-radius: 10px;
            text-align: right;
            padding: 10px 15px;
            font-size: 15px;
        }

        .login-input:focus {
            box-shadow: 0 0 0 2px rgba(94, 114, 228, 0.15);
        }

        .login-button {
            height: 52px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .remember-container {
            margin-top: 15px;
        }

        .error-message {
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .login-footer {
            text-align: center;
            color: #8392ab;
            font-size: 13px;
            margin-top: 30px;
        }


        /*
        |--------------------------------------------------------------------------
        | الصورة الجانبية
        |--------------------------------------------------------------------------
        */

        .image-section {
            width: 50%;
            min-height: 650px;
            position: relative;

            background-image:
                url('{{ asset('assets/img/illustrations/signin-ill.jpg') }}');

            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 50px;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(94, 114, 228, 0.90),
                rgba(17, 205, 239, 0.70)
            );
        }

        .image-content {
            position: relative;
            z-index: 2;
            max-width: 450px;
        }

        .image-content h2 {
            color: #fff;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .image-content p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            line-height: 2;
        }


        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991px) {

            .login-container {
                max-width: 600px;
                min-height: auto;
            }

            .login-section {
                width: 100%;
                padding: 50px 35px;
            }

            .image-section {
                display: none;
            }

        }


        @media (max-width: 576px) {

            .login-page {
                padding: 15px;
            }

            .login-section {
                padding: 40px 25px;
            }

            .login-title {
                font-size: 25px;
            }

        }

    </style>

</head>


<body>


<div class="login-page">

    <div class="login-container">


        {{-- ================================================= --}}
        {{-- قسم تسجيل الدخول --}}
        {{-- ================================================= --}}

        <div class="login-section">

            <div class="login-content">


                {{-- العنوان --}}

                <h1 class="login-title">
                    تسجيل الدخول
                </h1>

                <p class="login-description">
                    أدخل رقم الهاتف وكلمة المرور للدخول إلى نظام التكافل العائلي
                </p>


                {{-- ================================================= --}}
                {{-- رسائل الخطأ --}}
                {{-- ================================================= --}}

                @if(session('error'))

                    <div class="alert alert-danger error-message">
                        {{ session('error') }}
                    </div>

                @endif


                @if($errors->any())

                    <div class="alert alert-danger error-message">

                        @foreach($errors->all() as $error)

                            <div>
                                {{ $error }}
                            </div>

                        @endforeach

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- Form --}}
                {{-- ================================================= --}}

                <form method="POST"
                      action="{{ route('login.authenticate') }}">

                    @csrf


                    {{-- رقم الهاتف --}}

                    <div class="mb-4">

                        <label class="form-label">
                            رقم الهاتف
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control login-input"
                            placeholder="أدخل رقم الهاتف"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            required
                            autofocus
                        >

                    </div>


                    {{-- كلمة المرور --}}

                    <div class="mb-3">

                        <label class="form-label">
                            كلمة المرور
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control login-input"
                            placeholder="أدخل كلمة المرور"
                            autocomplete="current-password"
                            required
                        >

                    </div>


                    {{-- تذكرني --}}

                    <div class="form-check form-switch remember-container">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="remember"
                            id="rememberMe"
                            value="1"
                        >

                        <label
                            class="form-check-label"
                            for="rememberMe">

                            تذكرني

                        </label>

                    </div>


                    {{-- زر تسجيل الدخول --}}

                    <button
                        type="submit"
                        class="btn btn-primary w-100 login-button mt-4">

                        تسجيل الدخول

                    </button>


                </form>


                {{-- Footer --}}

                <div class="login-footer">

                    نظام التكافل العائلي

                </div>


            </div>

        </div>


        {{-- ================================================= --}}
        {{-- الصورة الجانبية --}}
        {{-- ================================================= --}}

        <div class="image-section">

            <div class="image-overlay"></div>

            <div class="image-content">

                <h2>
                    نظام التكافل العائلي
                </h2>

                <p>
                    نظام يهدف إلى دعم الأفراد وتعزيز التعاون
                    بين أعضاء العائلة من خلال المساهمات
                    والخدمات المشتركة.
                </p>

            </div>

        </div>


    </div>

</div>


<!-- Core JS -->

<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>

<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

<script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.1.0') }}"></script>


</body>

</html>