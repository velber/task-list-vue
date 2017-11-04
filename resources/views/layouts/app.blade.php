<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>To Do List</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Main CSS file -->
        <link href="{{ asset('css/vendor.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css" />

        <script>
            window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <div class="mdl-spinner mdl-js-spinner" style="display: none"></div>
        <div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>

        <div class="container">
            @yield('main-content')
        </div>

        <!-- custom scripts -->
        <script src="{{ mix('/js/vendor.js') }}" type="text/javascript"></script>
        <script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>

    </body>
</html>
