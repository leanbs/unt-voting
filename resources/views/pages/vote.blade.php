@extends('layouts.main')

@section('page-content')
<div id="fb-root"></div>

    <div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-md-12 col-xs-12 col-sm-9">
            {{ Html::image('images/ew-logo.PNG', 'ew-untar-8th', array('class' => 'img-responsive center-block')) }}

            <div class="row">
              <div class="col-md-12 col-xs-12" style="padding: 0 30px 0 30px;">
                <div class="col-md-4 col-xs-4 navigation-padding border-blue">
                  <span class="navigation-badge navigation-badge-active">1</span>
                  &nbsp;
                  <span class="navigation-font navigation-font-active">Select</span>
                </div>
                <div class="col-md-4 col-xs-4 navigation-padding border-blue border-left-none border-right-none">
                  <span id="navigation-badge-2" class="navigation-badge">2</span>
                  &nbsp;
                  <span id="navigation-font-2" class="navigation-font">Verify</span>
                </div>
                <div class="col-md-4 col-xs-4 navigation-padding border-blue">
                  <span id="navigation-badge-3" class="navigation-badge">3</span>
                  &nbsp;
                  <span id="navigation-font-3" class="navigation-font">Finish</span>
                </div>
              </div>
            </div>
            <div class="row">              
              <div id="vote">
                  <div class="col-md-12 col-xs-12" style="padding: 0 45px 0 45px;">
                    <div class="row">
                      <div class="col-xs-12 col-md-12 border-blue border-top-none padding-top-15">
                        <div id="loading" class="loading color-blue text-center">
                          <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                        <div id="voteForm">
                          @foreach ($booth->chunk(4) as $valueChunk)
                            <div class="row">
                              @foreach ($valueChunk as $value)
                                <div class="col-md-3 col-xs-6">
                                  <div class="thumbnail">   
                                    <a id="team-{{ $value->id_booth }}">
                                      <div class="caption">
                                          <h4 class="">{{ $value->nama_produk }}</h4>
                                          <p class="">{{ $value->deskripsi_produk }}</p>
                                      </div>
                                      <img src="{{ $value->directory_logo .'/'. $value->logo_name }}" alt="{{$value->logo_name}}" class="img-responsive">
                                    </a>
                                  </div>
                                </div>
                                <script src="{{ asset('assets/js2/jquery.min.js') }}"></script>
                                <script type="text/javascript">
                                  $("#team-{{ $value->id_booth }}").click(function(e){
                                    vote({{ $value->id_booth }});
                                    e.preventDefault();
                                  }); 
                                </script>
                              @endforeach
                            </div>
                          @endforeach
                        </div>                          
                      </div>    
                    </div>  
                  </div>
              </div>
              {{-- <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_PUBLIC_KEY') }}"></div> --}}           
            
          </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->

          </div><!--/row-->

          <hr>
          <div class="fb-share-button" data-href="http://www.entrepreneurweekuntar.com/" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.entrepreneurweekuntar.com%2F&amp;src=sdkpreparse">Share</a></div>

          <a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-url="http://www.entrepreneurweekuntar.com/" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

          <div class="g-plus" data-action="share" data-annotation="none" data-height="26" data-href="http://www.entrepreneurweekuntar.com/"></div>
      <footer>
        <p>&copy; 2016 Company, Inc.</p>

      </footer>

    </div><!--/.container-->

@section('script')

<script type="text/javascript">
  $(document).ready(function(){
    $("[data-toggle='tooltip']").tooltip();       
  });

  $('.thumbnail').hover(
      function(){
          $(this).find('.caption').slideDown(250); //.fadeIn(250)
      },
      function(){
          $(this).find('.caption').slideUp(250); //.fadeOut(205)
      }
  ); 

  var setting = {{ $setting->status }};

  if (setting == 1 ) 
  {
    function vote(id) {
      $("#loading").show();
      $("#voteForm").hide();
      $.ajax({
          url         : 'postVote',                                                       
          type        : 'post',
          data        : "id="+id,
          beforeSend: function (xhr) {
              var token = $('meta[name="csrf_token"]').attr('content');
              if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
              }
          },
          error : function(response)
          {
              alert('Unexpected error occurred, please refresh page & retry.');
          },
          success : function(response)
          { 
            var loadUrl = "verifyForm/"+response;         
              $("#vote").load(loadUrl, function(result){
                $("#loading").hide();
                $("#navigation-badge-2").addClass('navigation-badge-active');
                $("#navigation-font-2").addClass('navigation-font-active');
              });
          }
      });                    
    }
  }
  else
  {
    function vote(id) {
      alert('Voting online currently unavailable.');      
    }
  }
  

  // $(function(){                      
  //   var loadUrl = "voteForm";
  //   $("#vote").load(loadUrl);
  // });  
</script>
@stop
