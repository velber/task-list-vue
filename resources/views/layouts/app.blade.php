<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>To Do List</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- Main CSS file -->
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css" />

        <!-- Material design light -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.green-red.min.css" />

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

    <!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
    <!-- Laravel App -->
    <script src="//code.jquery.com/jquery-3.1.0.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Material Lite -->
    <script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
    <!-- custom scripts -->
    <script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>

    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    </body>
</html>
