<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Aries Optical</title>

        <link href="{{ asset('assets/media/logos/aries.png') }}" rel="icon">
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Vendor Stylesheets(used for this page only)-->
        <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Vendor Stylesheets-->
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

        <!-- Scripts -->
        <style type="text/css">
            .text-login{
                font-size: xx-large;
                background: -webkit-linear-gradient(#2F5D62, #60BEC8);
                font-weight: bold;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                display: flex;
                flex-wrap: wrap;
                flex-direction: column;
                align-content: space-around;
            }

            .class-logo{
                display: flex;
                justify-content: center;
                align-items: center;
            }

            /* .border-gradient {
                border: 3px solid transparent !important;
                border-image: linear-gradient(45deg, red , yellow) !important   ;
                border-image-slice: 1 !important;
                border-radius: .65rem !important;
            } */
        </style>
    </head>

    <body style="background-color:#F6F5EA">
        <main class="py-4 my-auto">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">

                            <div class="card-body">
                                <h1 class="text-login">LOGIN</h1>
                                    
                                    <div class="class-logo mt-4 mb-4">
                                            <img alt="Logo" src="{{asset('assets/media/logos/aries.png')}}" class="h-200px logo theme-light-show">
                                        
                                    </div>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="email"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email"
                                                autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="row mb-3">
                                        <div class="col-md-6 offset-md-4">
                                            <a class="btn btn-link"
                                                href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        </div>
                                    </div> --}}

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" style="background-color:#E6F4F3!important;" class="border-gradient rounded  form-control ">
                                                {{ __('Login') }}
                                            </button>

                        
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        </div>
    </body>

</html>
