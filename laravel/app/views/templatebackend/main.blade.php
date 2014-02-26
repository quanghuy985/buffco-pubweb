<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{Asset('assets/css/bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{Asset('assets/css/style.css')}}"/>
        <script type="text/javascript" src="{{Asset('assets/js/jquery-1.10.2.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('assets/js/jquery.validate.js')}}"></script>
    </head>
    <body>
        <header>
            @include('templatebackend.header')
        </header>
        <section>
            <div class="container">
                @yield("content")
            </div>
        </section>
        <footer>
            @include('templatebackend.footer')
        </footer>
    </body>
</html>