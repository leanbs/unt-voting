@if ($setting->status == 0)
	<div class="col-md-12 col-xs-12" style="padding: 0 45px 0 45px;">
		<div class="row">
			<div class="col-xs-12 col-md-12 border-blue border-top-none padding-top-15 text-center" style="padding-bottom: 15px;">
				<span class="color-blue" style="font-size: 30px;">Voting online currently unavailable.</span>
			</div>		
		</div>	
	</div>
@else
	<div class="col-md-12 col-xs-12" style="padding: 0 45px 0 45px;">
		<div class="row">
			<div class="col-xs-12 col-md-12 border-blue border-top-none padding-top-15">
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
					                  	<img src="{{ $value->directory_logo .'/'. $value->logo_name }}" alt="..." class="" width=200px height=200px>
									</a>
								</div>
							</div>
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

	<script type="text/javascript">
		$('.thumbnail').hover(
	      	function(){
	          	$(this).find('.caption').slideDown(250); //.fadeIn(250)
	      	},
	      	function(){
	          	$(this).find('.caption').slideUp(250); //.fadeOut(205)
	      	}
	    ); 

	    function vote(id) {
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
	            success : function(response)
	            { 
	            	var loadUrl = "verifyForm/"+response;         
	               	$("#vote").load(loadUrl, function(result){
	                	$("#navigation-badge-2").addClass('navigation-badge-active');
	                	$("#navigation-font-2").addClass('navigation-font-active');
	                });
	            }
	        });                    
	    }
	</script>
@endif
	