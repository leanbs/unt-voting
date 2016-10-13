<div id="modal-alert-success" class="alert alert-success alert-dismissable" hidden role="alert"></div>
<div id="modal-alert-fail" class="alert alert-danger alert-dismissable" hidden role="alert"></div>

{!! Form::open(['url' => 'modalEditForbidden', 'method' => 'post', 'name' =>'editforbiddenform']) !!}
    <div class="form-group">
        {!! Form::label('Email', 'Email') !!}
        {!! Form::text('Email', $forbiddenEmail->forbidden_email, [
            'class'         => 'form-control',
            'placeholder'   => 'ex: forbiddenemail.com'
        ]) !!}
    </div>

    <div class="modal-footer">
        <div class="form-group">
            {!! Form::submit('Edit', ['id' => 'btnSave', 'class' => 'btn btn-success', 'style' => 'width: 540px;']) !!}
        </div>
    </div>       
{!! Form::close() !!}


<script type="text/javascript">
    $("#btnSave").click(function(e){        
        var data = new FormData(document.forms.namedItem("editforbiddenform"));
        var id = {{ $forbiddenEmail->id_forbiddenemail }};
        data.append('id', id);

        $('.form-control').prop('disabled', true);
        $.ajax({
            url         : 'modalEditForbiddenEmail',                                                       
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
                $('#modal-alert-fail').html(errorHtml).fadeIn('slow');


            },
            success : function(response)
            {
                setTimeout(function(){
                    $('.form-control').prop('disabled', false);       
                    $('.form-control').val('');
                    setTimeout(function(){
                        $('#modal-alert-success').fadeOut('slow');
                    }, 500);
                    setTimeout(function(){
                        $('#modalEditForbiddenEmail').modal('hide');
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
</script>