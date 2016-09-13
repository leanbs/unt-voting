@extends('layouts.main')

@section('page-content')

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="jumbotron">
            <h1>Hello, world!</h1>
            <p>This is an example to show the potential of an offcanvas layout pattern in Bootstrap. Try some responsive-range viewport sizes to see it in action.</p>
          </div>
          <div class="row">
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="{{ url('vote/spasia') }}" class="">
                  <div class="caption">
                      <h4 class="">Team 1</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://localhost/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div>
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="#" class="">
                  <div class="caption">
                      <h4 class="">Team 2</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://192.168.1.3/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="#" class="">
                  <div class="caption">
                      <h4 class="">Team 3</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://localhost/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="#" class="">
                  <div class="caption">
                      <h4 class="">Team 4</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://localhost/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="#" class="">
                  <div class="caption">
                      <h4 class="">Team 5</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://localhost/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="#" class="">
                  <div class="caption">
                      <h4 class="">Team 6</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://localhost/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="#" class="">
                  <div class="caption">
                      <h4 class="">Team 6</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://localhost/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="#" class="">
                  <div class="caption">
                      <h4 class="">Team 6</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://localhost/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <div class="thumbnail">
                <a href="#" class="">
                  <div class="caption">
                      <h4 class="">Team 6</h4>
                      <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                  </div>
                  <img src="http://localhost/ewOnline/public/img.png" alt="..." class="">
                </a>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->
          </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
            <a href="#" class="list-group-item active">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; 2016 Company, Inc.</p>
      </footer>

    </div><!--/.container-->

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $("[data-toggle='tooltip']").tooltip(); 
   
    $('.thumbnail').hover(
      function(){
          $(this).find('.caption').slideDown(250); //.fadeIn(250)
      },
      function(){
          $(this).find('.caption').slideUp(250); //.fadeOut(205)
      }
    ); 
  });
</script>
    

@stop