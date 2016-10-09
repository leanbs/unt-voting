@extends('layouts.main')

@section('page-content')
    @include('modal.admin.booth.add.add')
    @include('modal.admin.booth.edit.edit')
    @include('modal.admin.booth.delete.delete')
    @include('modal.admin.vote.delete.delete')
    @include('modal.admin.forbiddenEmail.add.add')
    @include('modal.admin.forbiddenEmail.edit.edit')
    @include('modal.admin.forbiddenEmail.delete.delete')

    <div class="row row-afandi-ver" style="margin-bottom: 20px;">
        <div class="col-md-12 col-xs-12" style="border-bottom: solid 2px #cccccc; margin-bottom: 10px;">
            <h2>
                <i class="fa fa-star"></i>
                ENTREPRENEURWEEK UNTAR
            </h2>       
        </div>                                   
    </div>

    <div class="row row-afandi-ver" style="margin-bottom: 20px;">
        <div class="col-md-12 col-xs-12">
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

    <div class="row row-afandi-ver" style="margin-bottom: 20px;">
        <div class="col col-md-7 col-xs-12">
            <div class="row row-afandi-ver no-margin">
                <div class="col-md-12 col-xs-12" style="border: solid 2px #cccccc; padding-bottom: 10px;">
                    <div class="row row-afandi-ver no-margin">
                        <div class="col-md-12 col-xs-12" style="border-bottom: solid 2px #cccccc; margin-bottom: 10px;">
                            <h2><i class="fa fa-thumbs-up"></i> VOTE</h2>       
                        </div>    
                    </div>
                    <div class="row row-afandi-ver no-margin">
                        <table class="table table-bordered table-hover table-striped" id="table-vote">
                            <thead style="color: rgba(186, 0, 0, 1);">
                                <tr>
                                    <th class="text-center col-xs-3 col-md-3">Nama Booth</th>
                                    <th class="text-center col-xs-4 col-md-4">Email</th>
                                    <th class="text-center col-xs-3 col-md-3">Tanggal / Waktu</th>
                                    <th class="text-center col-xs-2 col-md-2">Pengaturan</th>
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
                    'targets'   : [ 2, -1],
                },
            ],
            processing: true,
            serverSide: true,
            ajax: '{{ url('tableVote') }}',
            columns: [
                { 'data': 'NamaBrand', 'name': 'booth.nama_produk' },
                { 'data': 'Email', 'name': 'vote.email' },
                { 'data': 'Tanggal', 'name': 'vote.updated_at' },
                { 'data': 'Pengaturan', 'name': 'Pengaturan', 'orderable': false, 'searchable': false },
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
                }
            },
            'color'  : {
                'pattern': [
                    '#1a66ff', // blue
                ],
            },
        });
    </script>

@stop