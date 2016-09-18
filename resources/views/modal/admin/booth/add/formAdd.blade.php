<div id="modal-alert-success" class="alert alert-success alert-dismissable" hidden role="alert"></div>
<div id="modal-alert-fail" class="alert alert-danger alert-dismissable" hidden role="alert"></div>

{!! Form::open(['url' => 'modalAddBooth', 'method' => 'post', 'id' => 'formAddBooth', 'files' => true, 'name' =>'addboothform']) !!}
    <div class="form-group">
        {!! Form::label('NamaBrand', 'Nama Brand') !!}
        {!! Form::text('NamaBrand', null, [
            'class'         => 'form-control',
            'placeholder'   => 'ex: kribcorn'
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('AnggotaKelompok', 'Anggota Kelompok') !!}
        {!! Form::text('AnggotaKelompok', null, [
            'class'         => 'form-control',
            'placeholder'   => 'ex: moo1, moo2, moo3, dst~'
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('DeskripsiProduk', 'Deskripsi produk') !!}
        {!! Form::textarea('DeskripsiProduk', null, [
            'class'       => 'form-control',
            'rows'        => '3',
            'cols'        => '40',
            'placeholder' => 'ex: Cara baru makan Popcorn.',
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('photo', 'Logo Produk') !!}
        <br>
        <img id="image-preview" class="img-thumbnail" alt="Foto produk" width="191"><br>
        {!! Form::file('photo', ['id' => 'photo', 'accept' => 'image/*', 'class' => 'input_photo hidden']) !!}  
        <a id="trigger-upload-photo" data-toggle="tooltip" data-placement="top" title="browse.." class="btn btn-primary" style="width: 191px;">
            <i class="fa fa-image"></i>
        </a>
    </div> 

    <div class="modal-footer">
        <div class="form-group">
            {!! Form::submit('Add', ['id' => 'btnSave', 'class' => 'btn btn-success', 'style' => 'width: 540px;']) !!}
        </div>
    </div>       
{!! Form::close() !!}


<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#photo').change(function () {
        readURL(this);
    });

    $("#trigger-upload-photo").click(function () {
        $("#photo").trigger('click');
    });

    $("#btnSave").click(function(e){        
        var data = new FormData(document.forms.namedItem("addboothform"));
        $('.form-control').prop('disabled', true);
        $.ajax({
            url         : 'modalAddBooth',                                                       
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
                    $('#image-preview').attr('src', null);
                    setTimeout(function(){
                        $('#modal-alert-success').fadeOut('slow');
                    }, 500);
                }, 1000);

                var successHtml = '<ul><li>'+response+'</li></ul>';
                $('#modal-alert-fail').hide();
                $('#modal-alert-success').html(successHtml).fadeIn('slow'); 
                DataTableBooth.ajax.reload();
            }
        });             
        e.preventDefault();                   
    }); 
</script>