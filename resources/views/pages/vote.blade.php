@extends('layouts.main')

@section('page-content')

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
         
            <img class="img-responsive center-block" src="https://static.wixstatic.com/media/fbd849_badfa26e07fb44e3baac50c9a4226a1a.png/v1/fill/w_368,h_267,al_c,usm_0.66_1.00_0.01/fbd849_badfa26e07fb44e3baac50c9a4226a1a.png">

            <div class="row">
              <div class="col-md-12 col-xs-12" style="padding: 0 30px 0 30px;">
                <div class="col-md-4 col-xs-4 navigation-padding border-blue">
                  <span class="navigation-badge navigation-badge-active">1</span>
                  &nbsp;
                  <span class="navigation-font navigation-font-active">Select the booth</span>
                </div>
                <div class="col-md-4 col-xs-4 navigation-padding border-blue border-left-none border-right-none">
                  <span id="navigation-badge-2" class="navigation-badge">2</span>
                  &nbsp;
                  <span id="navigation-font-2" class="navigation-font">Are you human?</span>
                </div>
                <div class="col-md-4 col-xs-4 navigation-padding border-blue">
                  <span id="navigation-badge-3" class="navigation-badge">3</span>
                  &nbsp;
                  <span id="navigation-font-3" class="navigation-font">Thankyou! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div id="vote"></div>
              {{-- <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_PUBLIC_KEY') }}"></div> --}}
            
            
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
    
  });

  $(function(){                      
    var loadUrl = "voteForm";
    $("#vote").load(loadUrl);
  });  
</script>
    
@stop