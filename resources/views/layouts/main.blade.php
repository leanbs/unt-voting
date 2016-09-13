
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Off Canvas Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/c3.min.css') }}" rel="stylesheet" type="text/css" >

    <!-- Custom styles for this template -->
<!--     <link href="offcanvas.css" rel="stylesheet"> -->
  </head>

  <body>
    @include('layouts.nav')

    @yield('page-content')



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>   
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <!-- <script src="offcanvas.js"></script> -->
    <script src="{{ asset('assets/js2/jquery.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js2/jquery.validate.min.js') }}"></script> -->
    <script src="{{ asset('assets/js2/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js2/c3.min.js') }}"></script>
    <script src="{{ asset('assets/js2/d3.min.js') }}"></script>

    @yield('script')
    <!-- <script type="text/javascript">
      $("[data-toggle='tooltip']").tooltip();    
     
      $('.thumbnail').hover(
        function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
      ); 
    </script> -->

  </body>
</html>
