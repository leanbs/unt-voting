<div class="col-md-12 col-xs-12" style="padding: 0 45px 0 45px;">
	<div class="row">
		<div class="col-xs-12 col-md-12 border-blue border-top-none padding-top-15" style="padding-bottom: 15px;">
			<div class="row">
				<div class="col-md-4 col-xs-4">
					<div class="row" style="margin-bottom: 5px;">
						<div class="col-md-12">
							<b style="font-size: 14px;">You're voting : {{ $booth->nama_produk }}</b>
						</div>						
					</div>
					<div class="row">
						<div class="col-md-12">
							<img src="{{ $booth->directory_logo .'/'. $booth->logo_name }}" alt="..." width="200">	
						</div>								
					</div>
				</div>
				<div class="col-md-8 col-xs-8">
					<div id="alert-success" class="alert alert-success alert-dismissable" hidden role="alert"></div>
					<div id="alert-fail" class="alert alert-danger alert-dismissable" hidden role="alert"></div>

					<div id="email-form">
						{!! Form::open(['url' => 'postEmail', 'method' => 'post', 'name' =>'emailform']) !!}
						    <div class="form-group">
						        {!! Form::label('email', 'Email') !!}
						        {!! Form::email('email', null, [
						            'class'         => 'form-control',
						            'placeholder'   => 'ex: moo@mail.com'
						        ]) !!}
						    </div>

						    <div class="form-group">
				               	{!! Recaptcha::render() !!}
				            </div>

					        <div class="form-group">
					            {!! Form::submit('Send', ['id' => 'btnSend', 'class' => 'btn btn-primary']) !!}
					        </div>     
						{!! Form::close() !!}
					</div>
					<div id="verify-form" style="display: none;">
						<span>still not receiving the verification code? <a href="#">click here</a></span>
						{!! Form::open(['url' => 'verifyCode', 'method' => 'post', 'name' =>'verifycodeform']) !!}
						    <div class="form-group">
						        {!! Form::label('code', 'Code') !!}
						        {!! Form::email('code', null, [
						            'class'         => 'form-control',
						            'placeholder'   => 'ex: aVa1di6xxxx'
						        ]) !!}
						    </div>

					        <div class="form-group">
					            {!! Form::submit('Verify', ['id' => 'btnVerify', 'class' => 'btn btn-primary']) !!}
					        </div>     
						{!! Form::close() !!}
					</div>					
				</div>
			</div>
		</div>		
	</div>	
</div>

<script type="text/javascript">
	// grecaptcha.render('captcha', {
	//     sitekey: '6Lc6-wYUAAAAAPltPY1lC3uMwDFpK5ZtvzG8G4s9',
	//     callback: function(response) {
	//         console.log(response);
	//     }
	// });

	$("#btnSend").click(function(e){		
		var data = new FormData(document.forms.namedItem("emailform"));
        var id = {{ $booth->id_booth }};
        data.append('id', id);
        $('.form-control').prop('disabled', true);
		$.ajax({
            url         : 'postEmail',                                                       
            type        : 'post',
            data        : data,
            contentType : false,
            processData : false,
            error : function(response)
            {
                setTimeout(function(){
                    $('.form-control').prop('disabled', false);
                    // sample delay
                }, 1000);
                var error = response.responseJSON;
                var errorHtml = '<ul>';
                $.each(error, function(key, value){
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#alert-fail').html(errorHtml).fadeIn('slow');
                grecaptcha.reset();
            },
            success : function(response)
            { 
            	if (response == 'success') 
            	{
            		setTimeout(function(){
            			$('.form-control').prop('disabled', false);
                        setTimeout(function(){
                            $('#alert-success').fadeOut('slow');
                        }, 500);
                    }, 1000);

            		$('#alert-fail').hide();
            		// var successHtml = '<ul><li>voting code has been sent to your email address</li></ul>';
            		// $('#alert-success').html(successHtml).fadeIn('slow');
            		$('#email-form').fadeOut('slow');
            		$('#verify-form').fadeIn('slow');
            	}
            	else
            	{
            		setTimeout(function(){
            			$('.form-control').prop('disabled', false);                        
                    }, 1000);
            		var errorHtml = '<ul><li>' + response + '</li></ul>';
            		$('#alert-fail').html(errorHtml).fadeIn('slow');
            	}
            	
            }
        });   
		e.preventDefault();
	});

	$("#btnVerify").click(function(e){		
		var data = new FormData(document.forms.namedItem("verifycodeform"));
        $('.form-control').prop('disabled', true);
		$.ajax({
            url         : 'postVerify',                                                       
            type        : 'post',
            data        : data,
            contentType : false,
            processData : false,
            error : function(response)
            {
                setTimeout(function(){
                    $('.form-control').prop('disabled', false);
                    // sample delay
                }, 1000);
                var error = response.responseJSON;
                var errorHtml = '<ul>';
                $.each(error, function(key, value){
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#alert-fail').html(errorHtml).fadeIn('slow');
                grecaptcha.reset();
            },
            success : function(response)
            { 
            	if (response == 'success') 
            	{           
            		var loadUrl = "thankyouForm";         
	               	$("#vote").load(loadUrl, function(result){
	                	$("#navigation-badge-3").addClass('navigation-badge-active');
	                	$("#navigation-font-3").addClass('navigation-font-active');
	                });
            	}
            	else
            	{
            		setTimeout(function(){
            			$('.form-control').prop('disabled', false);                        
                    }, 1000);
            		var errorHtml = '<ul><li>' + response + '</li></ul>';
            		$('#alert-fail').html(errorHtml).fadeIn('slow');
            	}
            	
            }
        });   
		e.preventDefault();
	});
</script>