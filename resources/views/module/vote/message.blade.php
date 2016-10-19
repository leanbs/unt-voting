@extends('layouts.main')

@section('page-content')
    <div class="row row-afandi-ver" style="margin-bottom: 20px;">
        <div id="chart" class="col-md-12 col-xs-12">
            <div class="row row-afandi-ver no-margin">
                <div class="col col-md-12 col-xs-12 border-blue">
                    <div class="row row-afandi-ver no-margin">
                        <div class="col-md-12 col-xs-12 text-center" style="margin-bottom: 10px;">
                            <?php echo $message; ?>                              
                        </div>                           
                    </div>
                </div>       
            </div>    
        </div>                            
    </div>
@stop

@section('script')
	<script type="text/javascript">
		setTimeout(function(){ 
            window.location = '{{ url('/') }}'; 
        }, 3000);     
	</script>
@stop

	