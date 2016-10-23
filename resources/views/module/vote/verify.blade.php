<div class="col-md-12 col-xs-12" style="padding: 0 45px 0 45px;">
	<div class="row">
		<div class="col-xs-12 col-md-12 border-blue border-top-none padding-top-15" style="padding-bottom: 15px;">
			<div class="row">
				<div class="col-md-4 col-xs-12">
					<div class="row" style="margin-bottom: 5px;">
						<div class="col-md-12">
							<b style="font-size: 14px;">You're voting : {{ $booth->nama_produk }}</b>
						</div>						
					</div>
					<div class="row">
						<div class="col-md-12 col-xs-8">
							<img src="{{ $booth->directory_logo .'/'. $booth->logo_name }}" alt="{{$booth->logo_name}}" width="170">	
						</div>								
					</div>
				</div>
				<div class="col-md-8 col-xs-8">
                    <div id="loading" class="loading color-blue text-center">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    </div>
					<div id="alert-success" class="alert alert-success alert-dismissable" hidden role="alert"></div>
					<div id="alert-fail" class="alert alert-danger alert-dismissable" hidden role="alert"></div>

					<div id="email-form">
						{!! Form::open(['url' => 'postEmail', 'method' => 'post', 'name' =>'emailform']) !!}
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <a href="redirect/facebook" class="btn btn-primary btn-md btn-block"><i class="fa fa-facebook"></i>&nbsp;&nbsp;Vote with Facebook</a>
                                </div>
                                {{-- <div class="col-md-6 col-xs-12">
                                    <a href="redirect/twitter" class="btn btn-info btn-md btn-block"><i class="fa fa-twitter"></i>&nbsp;&nbsp;Vote with Twitter</a>
                                </div> --}}
                            </div>
                            <div class="row" style="margin: 10px 0 10px 0;">
                                <div class="col-md-12 col-xs-12 text-center">
                                    OR
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Form::label('email', 'Vote Using Your Email Address') !!}
                                        {!! Form::email('email', null, [
                                            'class'         => 'form-control',
                                            'placeholder'   => 'ex: email@mail.com'
                                        ]) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Recaptcha::render() !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::submit('Send', ['id' => 'btnSend', 'class' => 'btn btn-primary']) !!}
                                    </div>     
                                </div>
                            </div>    						    
						{!! Form::close() !!}       
					</div>
					<div id="verify-form" style="display: none;">
						<span>still not receiving the verification code? 
                            <a id="send-verify-again" style="text-decoration: none;">click here</a>
                            <div id="loading1" class="loading color-blue text-center">
                                <i class="fa fa-spinner fa-pulse fa-fw"></i>
                            </div>
                        </span>
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
        $('#email-form').hide();
        $("#loading").show();
		var data = new FormData(document.forms.namedItem("emailform"));
        var id = {{ $booth->id_booth }};
        data.append('id', id);
		$.ajax({
            url         : 'postEmail',                                                       
            type        : 'post',
            data        : data,
            contentType : false,
            processData : false,
            error : function(response)
            {
                $("#loading").hide();
                $('#email-form').show();
                var error = response.responseJSON;
                var errorHtml = '<ul>';
                $.each(error, function(key, value){
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#alert-fail').html(errorHtml).fadeIn('slow');
                $('.form-control').val('');
                grecaptcha.reset();
            },
            success : function(response)
            { 
            	if (response == 'success') 
            	{
                    grecaptcha.reset();
                    $('#alert-fail').hide();
                    $("#loading").hide();
                    $('#verify-form').show();           		
            	}
            	else
            	{
                    $("#loading").hide();
                    $('#email-form').show();
                    $('.form-control').val('');
            		var errorHtml = '<ul><li>' + response + '</li></ul>';
            		$('#alert-fail').html(errorHtml).fadeIn('slow');
                    grecaptcha.reset();
            	}
            	
            }
        });   
		e.preventDefault();
	});

    $("#send-verify-again").click(function(e){     
        $('#send-verify-again').hide();  
        $("#loading1").show();   
        $.ajax({
            url         : 'postSendVerifyAgain',                                                       
            type        : 'post',
            data        : 'data='+1,   
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            error : function(response)
            {
                $("#loading1").hide(); 
                $('#send-verify-again').show();                    
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
                setTimeout(function(){
                    setTimeout(function(){
                        $('#alert-success').fadeOut('slow');
                    }, 500);
                }, 1000);
                $("#loading1").hide();  
                $('#send-verify-again').show();                   
                $('#alert-fail').hide();
                var successHtml = '<ul><li>Verification code has been sent again to your email address.</li></ul>';
                $('#alert-success').html(successHtml).fadeIn('slow');
            }
        });   
        e.preventDefault();
    });

	$("#btnVerify").click(function(e){		
        $('#verify-form').hide(); 
        $("#loading").show();
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
                var error = response.responseJSON;
                var errorHtml = '<ul>';
                $.each(error, function(key, value){
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $("#loading").hide();
                $('#verify-form').show(); 
                $('#alert-fail').html(errorHtml).fadeIn('slow');
                grecaptcha.reset();
            },
            success : function(response)
            { 
            	if (response == 'success') 
            	{           
            		var loadUrl = "thankyouForm";         
	               	$("#vote").load(loadUrl, function(result){
                        $("#loading").hide();
	                	$("#navigation-badge-3").addClass('navigation-badge-active');
	                	$("#navigation-font-3").addClass('navigation-font-active');
	                });
            	}
            	else
            	{
                    $("#loading").hide();
                    $('#verify-form').show(); 
            		var errorHtml = '<ul><li>' + response + '</li></ul>';
            		$('#alert-fail').html(errorHtml).fadeIn('slow');
            	}
            	
            }
        });   
		e.preventDefault();
	});
</script>