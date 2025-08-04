<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $favicon = \App\Models\Setting::find(1)->favicon;
        $modules = \App\Models\Module::all();
    @endphp
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ \App\Models\Setting::find(1)->app_name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- General CSS Files -->
    <link href="{{ $favicon ? url('images/upload/' . $favicon) : asset('/images/logo.png') }}" rel="icon"
        type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <link href="https://jvectormap.com/css/jquery-jvectormap-2.0.3.css" rel="stylesheet">
    <!-- CSS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Template CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ url('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('admin/css/components.css') }}">
    <link rel="stylesheet" href="{{ url('admin/css/custom.css') }}">
    @if (session('direction') == 'rtl')
        <link rel="stylesheet" href="{{ url('admin/css/rtl.css') }}">
    @endif
</head>

<body>
    <?php $primary_color = \App\Models\Setting::find(1)->primary_color; ?>

    <style>
        :root {
            --primary_color: <?php echo $primary_color; ?>;
            --light_primary_color: <?php echo $primary_color . '1a'; ?>;
            --middle_light_primary_color: <?php echo $primary_color . '85'; ?>;
            /* Custom color scheme */
            --secondary_color: #f7941d;
            --footer_color: #334389;
            --light_secondary_color: #f7941d1a;
            --light_footer_color: #3343891a;
        }

        .bg-primary {
            --tw-bg-opacity: 1;
            background-color: var(--primary_color);
        }

        .bg-secondary {
            --tw-bg-opacity: 1;
            background-color: var(--secondary_color);
        }

        .bg-footer {
            --tw-bg-opacity: 1;
            background-color: var(--footer_color);
        }

        .text-secondary {
            color: var(--secondary_color);
        }

        .text-footer {
            color: var(--footer_color);
        }

        .bg-primary-dark {
            --tw-bg-opacity: 1;
            background-color: var(--profile_primary_color);
        }

        .navbar-nav>.active>a {
            color: var(--primary_color);
        }

        .text-primary {
            --tw-text-opacity: 1;
            color: var(--primary_color);
        }

        .border-primary {
            --tw-border-opacity: 1;
            border-color: var(--primary_color);
        }
    </style>

    <input type="hidden" name="currency" id="currency" value="{{ $currency ?? '' }}">
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="lds-ripple">
        <div></div>
        <div></div>
    </div>
    <div id="app" style="display: none;">
        @if (Auth::guard('appuser')->check())
            <div class="main-wrapper">
                @include('user.layout.header')
                @include('user.layout.sidebar')
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        @else
            @yield('content')
        @endif
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ url('admin/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/datatables.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="https://jvectormap.com/js/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="https://jvectormap.com/js/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Template JS File -->
    <script src="{{ url('admin/js/scripts.js') }}"></script>
    <script src="{{ url('admin/js/custom.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Hide loading spinner and show app content
            $('.lds-ripple').fadeOut(300, function() {
                $('#app').fadeIn(300);
            });
        });
    </script>

    @yield('script')
</body>

</html>
