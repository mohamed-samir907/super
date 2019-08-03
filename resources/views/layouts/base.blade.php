<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ url('img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Paper Dashboard 2 by Creative Tim
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ url('css/paper-dashboard.css?v=2.0.0') }}" rel="stylesheet" />
    <style>
		.custom-message {
			position: fixed;
			top: 0;
			right: 0;
			left: 0;
			padding: 30px;
			z-index: 1000000;
			color: #FFF;
			font-weight: bold;
		}
		.custom-message-btn {
			float: right;
			background: none;
			border: 1px solid #FFF;
			border-radius: 50%;
			width: 30px;
			height: 30px;
			color: #FFF;
			margin-left: 20px;
		}
		.custom-message-error {
			background-color: #F44336;
		}
		.custom-message-success {
			background-color: #4CAF50;
		}
	</style>
    @stack('style')
</head>

<body class="">
    <div id="custom-message" class="custom-message" style="display: none">
        <button class="custom-message-btn" id="custom-message-btn">x</button>
        <ul class="list-unstyled"></ul>
    </div>
    <div class="wrapper ">

        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                    <div class="logo-image-small">
                        <img src="{{ url('img/logo-small.png') }}">
                    </div>
                </a>
                <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                    Creative Tim
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    {{-- Sidebar Items --}}
                    @include('samirz.layouts.sidebar')
                </ul>
            </div>
        </div>

        <div class="main-panel">
            {{-- Navbar --}}
            @include('samirz.layouts.navbar')

            @yield('content')

            {{-- Footer --}}
            @include('samirz.layouts.footer')
        </div>
    </div>

    {{-- Bottom Bar > Contains Scripts --}}
    @include('samirz.layouts.bottom_bar')

    @stack('script')
</body>

</html>
