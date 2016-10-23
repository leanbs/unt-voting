@extends('layouts.main')

@section('page-content')
    @include('layouts.nav')
    
    @include('modal.admin.booth.add.add')
    @include('modal.admin.booth.edit.edit')
    @include('modal.admin.booth.delete.delete')
    @include('modal.admin.vote.delete.delete')
    @include('modal.admin.vote.deleteAll.delete')
    @include('modal.admin.forbiddenEmail.add.add')
    @include('modal.admin.forbiddenEmail.edit.edit')
    @include('modal.admin.forbiddenEmail.delete.delete')

    <div class="row row-afandi-ver" style="margin-bottom: 20px;">
        <div class="col-md-12 col-xs-12" style="border-bottom: solid 2px #cccccc; margin-bottom: 10px; margin-top: 70px;">
            <h2>
                <i class="fa fa-star"></i>
                ENTREPRENEURWEEK UNTAR
                @if ($setting->status == 0)
                    <a id="btnStartEvent" class="btn btn-success pull-right" style="margin-top: 5px;">
                        <i class="fa fa-check"></i>
                        Start Event
                    </a>
                    <a id="btnStopEvent" class="btn btn-danger pull-right" style="margin-top: 5px; display: none;">
                        <i class="fa fa-close"></i>
                        Stop Event
                    </a>
                @else
                    <a id="btnStartEvent" class="btn btn-success pull-right" style="margin-top: 5px; display: none;">
                        <i class="fa fa-check"></i>
                        Start Event
                    </a>
                    <a id="btnStopEvent" class="btn btn-danger pull-right" style="margin-top: 5px;">
                        <i class="fa fa-close"></i>
                        Stop Event
                    </a>
                @endif      
            </h2>       
        </div>                                   
    </div>

    <div class="row row-afandi-ver" style="margin-top: 20px;">
        <div id="chart" class="col-md-12 col-xs-12">
            <div class="row row-afandi-ver no-margin">
                <div class="col col-md-12 col-xs-12" style="border: solid 2px #cccccc;">
                    <div class="row row-afandi-ver no-margin">
                        <div class="col-md-12 col-xs-12" style="border-bottom: solid 2px #cccccc; margin-bottom: 10px;">
                            <h2>
                                <i class="fa fa-bar-chart"></i>
                                BAR CHART VOTE
                            </h2>       
                        </div>                           
                    </div>
                    <div class="row row-afandi-ver no-margin">
                        <div id="voteChart"></div>
                    </div>
                </div>       
            </div>    
        </div>                            
    </div>

    <div class="row row-afandi-ver" style="margin-bottom: 20px; margin-top: 25px;">
        <div class="col col-md-7 col-xs-12">
            <div class="row row-afandi-ver no-margin">
                <div id="vote" class="col-md-12 col-xs-12" style="border: solid 2px #cccccc; padding-bottom: 10px;">
                    <div class="row row-afandi-ver no-margin">
                        <div class="col-md-12 col-xs-12" style="border-bottom: solid 2px #cccccc; margin-bottom: 10px;">
                            <h2>
                                <i class="fa fa-thumbs-up"></i> 
                                VOTE
                                {{-- <a id="btnDeleteAllVote" class="btn btn-danger pull-right" style="margin-top: 5px;">
                                    <i class="fa fa-trash"></i> Delete Vote
                                </a> --}}
                            </h2>       
                        </div>    
                    </div>
                    <div class="row row-afandi-ver no-margin">
                        <table class="table table-bordered table-hover table-striped" id="table-vote">
                            <thead style="color: rgba(186, 0, 0, 1);">
                                <tr>
                                    <th class="text-center col-xs-2 col-md-2">Nama Booth</th>
                                    <th class="text-center col-xs-2 col-md-2">Alamat ip</th>
                                    <th class="text-center col-xs-2 col-md-2">Id Facebook</th>
                                    <th class="text-center col-xs-2 col-md-3">Email</th>
                                    <th class="text-center col-xs-2 col-md-3">Tanggal / Waktu</th>
                                    {{-- <th class="text-center col-xs-2 col-md-2">Pengaturan</th> --}}
                                </tr>
                            </thead>
                        </table>  
                    </div>
                </div>                    
            </div>
        </div>
        <div class="col col-md-5 col-xs-12">
            <div class="row row-afandi-ver no-margin">
                <div class="col-md-12 col-xs-12" style="border: solid 2px #cccccc; padding-bottom: 10px;">
                    <div class="row row-afandi-ver no-margin">
                        <div class="col-md-12 col-xs-12" style="border-bottom: solid 2px #cccccc; margin-bottom: 10px;">
                            <h2>
                                <i class="fa fa-envelope"></i>
                                FORBIDDEN EMAIL
                                <a id="btnAddForbiddenEmail" class="btn btn-primary pull-right" style="margin-top: 5px;">
                                    <i class="fa fa-plus"></i> Add Email
                                </a>
                            </h2>       
                        </div>                           
                    </div>
                    <div class="row row-afandi-ver no-margin">
                        <table class="table table-bordered table-hover table-striped" id="table-forbidden">
                            <thead style="color: rgba(186, 0, 0, 1);">
                                <tr>
                                    <th class="text-center col-xs-7 col-md-7">Email</th>
                                    <th class="text-center col-xs-5 col-md-5">Pengaturan</th>
                                </tr>
                            </thead>
                        </table>                       
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <div class="row row-afandi-ver" style="margin-bottom: 30px;">
        <div class="col-md-12 col-xs-12">
            <div class="row row-afandi-ver no-margin">
                <div class="col col-md-12 col-xs-12" style="border: solid 2px #cccccc; padding-bottom: 10px;">
                    <div class="row row-afandi-ver no-margin">
                        <div class="col-md-12 col-xs-12" style="border-bottom: solid 2px #cccccc; margin-bottom: 10px;">
                            <h2>
                                <i class="fa fa-flag"></i>
                                BOOTH
                                <a id="btnAddBooth" class="btn btn-primary pull-right" style="margin-top: 5px;">
                                    <i class="fa fa-plus"></i> Add Booth
                                </a>
                            </h2>       
                        </div>                           
                    </div>
                    <div class="row row-afandi-ver no-margin">           
                        <table class="table table-bordered table-hover table-striped" id="table-booth">
                            <thead style="color: rgba(186, 0, 0, 1);">
                                <tr>
                                    <th class="text-center col-xs-2 col-md-2">Logo</th>
                                    <th class="text-center col-xs-2 col-md-2">Nama Brand</th>
                                    <th class="text-center col-xs-3 col-md-3">Anggota Kelompok</th>
                                    <th class="text-center col-xs-3 col-md-3">Deskripsi</th>
                                    <th class="text-center col-xs-2 col-md-2">Pengaturan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>         
            </div>
        </div>                                      
    </div>

@section('script')
    <script type="text/javascript">
        $(function(){
            $("#btnStartEvent").click(function(e){     
                $('#btnStartEvent').prop('disabled', true);
                $.ajax({
                    url         : 'postEvent',                                                       
                    type        : 'post',
                    data        : "status="+1,
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    error : function(response)
                    {
                        setTimeout(function(){
                            $('#btnStartEvent').prop('disabled', false);
                        }, 1000);
                        alert('terjadi kesalahan, diharapkan untuk melakukan refresh halaman agar dapat melanjutkan');
                    },
                    success : function(response)
                    {
                        setTimeout(function(){
                            $('#btnStartEvent').prop('disabled', false);
                            $('#btnStartEvent').hide();
                            $('#btnStopEvent').show();
                        }, 1000);
                    }
                });             
                e.preventDefault();                   
            }); 
        });

        $(function(){
            $("#btnStopEvent").click(function(e){     
                $('#btnStopEvent').prop('disabled', true);
                $.ajax({
                    url         : 'postEvent',                                                       
                    type        : 'post',
                    data        : "status="+0,
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    error : function(response)
                    {
                        setTimeout(function(){
                            $('#btnStopEvent').prop('disabled', false);
                        }, 1000);
                        alert('terjadi kesalahan, diharapkan untuk melakukan refresh halaman agar dapat melanjutkan');
                    },
                    success : function(response)
                    {
                        setTimeout(function(){
                            $('#btnStopEvent').prop('disabled', false);
                            $('#btnStopEvent').hide();
                            $('#btnStartEvent').show();
                        }, 1000);
                    }
                });             
                e.preventDefault();                   
            }); 
        });


        // booth
        $(function(){
            $.ajaxSetup ({
                cache: false
            });                         
            var loadUrl = "modalAddBooth";
            $("#btnAddBooth").click(function(){
                $("#modal-body-addBooth").load(loadUrl, function(result){
                    $("#modalAddBooth").modal({show:true});
                });
            });
        });  

        // forbidden email
        $(function(){
            $.ajaxSetup ({
                cache: false
            });                         
            var loadUrl = "modalAddForbidden";
            $("#btnAddForbiddenEmail").click(function(){
                $("#modal-body-addForbiddenEmail").load(loadUrl, function(result){
                    $("#modalAddForbiddenEmail").modal({show:true});
                });
            });
        });  

        // delete vote
        $(function(){
            $.ajaxSetup ({
                cache: false
            });                         
            var loadUrl = "modalDeleteAllVote";
            $("#btnDeleteAllVote").click(function(){
                $("#modal-body-deleteAllVote").load(loadUrl, function(result){
                    $("#modalDeleteAllVote").modal({show:true});
                });
            });
        });         

        var DataTableBooth = $('#table-booth').DataTable({
            columnDefs: [
                {
                    'className' : 'text-center text-nowrap',
                    'targets'   : [ 0, -1],
                },
            ],
            processing: true,
            serverSide: true,
            ajax: '{{ url('tableBooth') }}',
            columns: [
                { 'data': 'Logo', 'name': 'Logo', 'orderable': false, 'searchable': false },
                { 'data': 'NamaBrand', 'name': 'nama_produk' },
                { 'data': 'AnggotaKelompok', 'name': 'anggota_kelompok', 'orderable': false },
                { 'data': 'Des', 'name': 'deskripsi_produk', 'orderable': false },
                { 'data': 'Pengaturan', 'name': 'Pengaturan', 'orderable': false, 'searchable': false },
            ]
        });

        var DataTableVote = $('#table-vote').DataTable({
            columnDefs: [
                {
                    'className' : 'text-center text-nowrap',
                    'targets'   : [ 2 ],
                },
            ],
            processing: true,
            serverSide: true,
            ajax: '{{ url('tableVote') }}',
            columns: [
                { 'data': 'NamaBrand', 'name': 'booth.nama_produk' },
                { 'data': 'AlamatIP', 'name': 'vote.ip_addr' },
                { 'data': 'IdFacebook', 'name': 'vote.id_facebook' },
                { 'data': 'Email', 'name': 'vote.email' },
                { 'data': 'Tanggal', 'name': 'vote.updated_at' },
                // { 'data': 'Pengaturan', 'name': 'Pengaturan', 'orderable': false, 'searchable': false },
            ]
        });

        var DataTableForbidden = $('#table-forbidden').DataTable({
            columnDefs: [
                {
                    'className' : 'text-center text-nowrap',
                    'targets'   : [ 1 ],
                },
            ],
            processing: true,
            serverSide: true,
            ajax: '{{ url('tableForbidden') }}',
            columns: [
                { 'data': 'ForbiddenEmail', 'name': 'forbidden_email' },
                { 'data': 'Pengaturan', 'name': 'Pengaturan', 'orderable': false, 'searchable': false },
            ]
        });

        var voteChart = c3.generate({
            bindto: '#voteChart',
            data: {
                type: 'bar',
                url: 'chartVote',
                mimeType : 'json', 
                keys: {
                    x: 'Nama',
                    value: ['Jumlah']
                }
            },
            axis: {
                rotated: true,
                x: {
                    type:'category',
                },
                y: {
                    tick: { format: d3.format("d") }
                } 
            },
            'color'  : {
                'pattern': [
                    '#1a66ff', // blue
                ],
            },
        });

        var refresh;

        $('#vote').hover(
            function(){
                clearInterval(refresh);
            },
            function(){
                refresh = setInterval(function(){ 
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
                }, 7000);
            }
        );

        $('#chart').hover(
            function(){
                clearInterval(refresh);
            },
            function(){
                refresh = setInterval(function(){ 
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
                }, 7000);
            }
        );
    </script>

@stop
