<div id="modal-alert-success" class="alert alert-success alert-dismissable" hidden role="alert"></div>
<div id="modal-alert-fail" class="alert alert-danger alert-dismissable" hidden role="alert"></div>

{!! Form::open(['url' => 'modalDeleteAllVote', 'method' => 'post', 'name' =>'deleteallvoteform']) !!}
    <div class="form-group">
        {!! Form::label('ExtensionEmail', 'Extension Email') !!}
        {!! Form::select('ExtensionEmail', $Extension, null, [
            'class'         => 'form-control',
            'style'         => 'z-index:0; width:100%;',
            'placeholder'   => '--',
            'id'            => 'produk'
        ]) !!}
    </div>

    <div class="modal-footer">
        <div class="form-group">
            {!! Form::submit('Delete', ['id' => 'btnDelete', 'class' => 'btn btn-danger', 'style' => 'width: 540px;']) !!}
        </div>
    </div>       
{!! Form::close() !!}


<script type="text/javascript">
    $("#btnDelete").click(function(e){        
        var data = new FormData(document.forms.namedItem("deleteallvoteform"));
        $('.form-control').prop('disabled', true);
        $.ajax({
            url         : 'modalDeleteAllVote',                                                       
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
                }, 1000);

                var successHtml = '<ul><li>'+response+'</li></ul>';
                $('#modal-alert-fail').hide();
                $('#modal-alert-success').html(successHtml).fadeIn('slow'); 
                DataTableVote.ajax.reload();
                voteChart.load({
                    type: 'bar',
                    url: 'chartVote',
                    mimeType : 'json', 
                    keys: {
                        x: 'Nama',
                        value: ['Jumlah']
                    }
                });    
            }
        });             
        e.preventDefault();        
    });     
</script>           
  