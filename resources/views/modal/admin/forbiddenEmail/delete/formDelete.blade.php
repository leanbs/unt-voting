<div id="modal-alert-success" class="alert alert-success alert-dismissable" hidden role="alert"></div>
<div id="modal-alert-fail" class="alert alert-danger alert-dismissable" hidden role="alert"></div>

<p style="text-align: center; color: red;">Are you sure want to delete this data?</p>	
<div class="modal-footer">
	{!! Form::open(['url' => 'modalDeleteForbiddenEmail', 'method' => 'post', 'name' =>'deleteforbiddenform']) !!}
	    {!! Form::submit('Yes', ['class' => 'btn pull-left btn-danger', 'id' => 'iya' ]) !!}
	    {!! Form::button('No', ['class' => 'btn btn-success', 'data-dismiss' => 'modal' ]) !!}
	{!! Form::close() !!}
</div>

<script type="text/javascript">
	// delete
    $(function(){
        var id = {{ $id }};
        $("#iya").click(function(e){     
            $('#iya').prop('disabled', true);
            $.ajax({
                url         : 'modalDeleteForbiddenEmail',                                                       
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
                    setTimeout(function(){
                        $('#iya').prop('disabled', false);
                    }, 1000);
                    var error = response.responseJSON;
                    var errorHtml = '<ul>';
                    errorHtml += '<li>terjadi kesalahan, diharapkan untuk melakukan refresh halaman agar dapat melanjutkan</li>';
                    errorHtml += '</ul>';

                    $('#modal-alert-fail').html(errorHtml).fadeIn('slow');


                },
                success : function(response)
                {
                    setTimeout(function(){
                        $('#iya').prop('disabled', false);
                        setTimeout(function(){
                            $('#modal-alert-success').fadeOut('slow');
                        }, 500);
                        setTimeout(function(){
                            $('#modalDeleteForbiddenEmail').modal('hide');
                        }, 1000);
                    }, 1000);

                    var successHtml = '<ul><li>'+response+'</li></ul>';
                    $('#modal-alert-fail').hide();
                    $('#modal-alert-success').html(successHtml).fadeIn('slow');     
                    DataTableForbidden.ajax.reload();             
                }
            });             
            e.preventDefault();                   
        }); 
    });
</script>