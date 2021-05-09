<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Larabrary Admin Panel</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @auth
    <script>
        window.user=@json(auth()->user());
        window.isAdmin=@json(auth()->user()->hasRole('admin'));
        window.Laravel = {!! json_encode([
             'csrfToken'=>csrf_token()
        ])!!}

    </script>

    @endauth
    <div class="wrapper" id="app">
        <div class="content-wrapper">
        
            <section class="content">
                @yield('content')
            </section>

        </div>

        <footer class="main-footer" style="margin-left: 250px">
            <strong>Copyright &copy; 2020-2021 <a href="/">Larabrary.com</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.0
            </div>
        </footer>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <script src="/js/admin.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js">
    </script>
    <script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>




</body>

</html>
