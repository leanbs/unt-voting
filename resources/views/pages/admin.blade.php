@extends('layouts.main')

@section('page-content')
    @include('modal.admin.booth.add.add')
    @include('modal.admin.booth.edit.edit')
    @include('modal.admin.booth.delete.delete')

    <div class="row row-afandi-ver">
        <div class="row row-afandi-ver no-margin">
            <div class="col-md-12 col-xs-12" style="border-bottom: solid 2px #cccccc; margin-bottom: 10px;">
                <h1>ENTREPRENEURWEEK 
                    <a id="btnAddBooth" class="btn btn-primary pull-right" style="margin-top: 5px;">
                        <i class="fa fa-plus"></i> Add Booth
                    </a>
                </h1>       
            </div>                           
        </div>
        <div class="row row-afandi-ver no-margin">
            <div class="col-md-12 col-xs-12">
                <div class="navigation">
                    <ul class="nav nav-tabs z-indexmin">
                        <li role="presentation" class="nav-item">
                            <a class="link-dark-red" href="#booth-container" data-toggle="tab" id="manageProduct" aria-expanded="false" aria-expanded="true">
                                Entrepreneurweek Booth
                            </a>
                        </li>

                        <li role="presentation" class="nav-item">
                            <a class="link-orange" href="#vote-container" data-toggle="tab" id="hotListProduct" aria-expanded="false">
                                Entrepreneurweek Vote
                            </a>
                        </li>
                    </ul>
                </div><!-- /.navigation -->

                <div class="tab-content" id="tabs">
                    <div id="booth-container" class="tab-pane fade" style="margin-top: 20px;">     
                        <div class="row row-afandi-ver no-margin">               
                            <table class="table table-bordered table-hover table-striped" id="table-booth">
                                <thead style="color: rgba(186, 0, 0, 1);">
                                    <tr>
                                        <th class="text-center col-xs-2 col-md-2">Logo</th>
                                        <th class="text-center col-xs-2 col-md-2">Nama Brand</th>
                                        <th class="text-center col-xs-2 col-md-2">Anggota Kelompok</th>
                                        <th class="text-center col-xs-4 col-md-4">Deskripsi</th>
                                        <th class="text-center col-xs-2 col-md-2">Pengaturan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div id="vote-container" class="tab-pane fade" style="margin-top: 20px;">      
                        <div class="row row-afandi-ver no-margin">
                            <table class="table table-bordered table-hover table-striped" id="table-vote">
                                <thead style="color: rgba(186, 0, 0, 1);">
                                    <tr>
                                        <th class="text-center col-xs-3 col-md-3">Nama Booth</th>
                                        <th class="text-center col-xs-3 col-md-3">Email</th>
                                        <th class="text-center col-xs-3 col-md-3">Tanggal / Waktu</th>
                                        <th class="text-center col-xs-3 col-md-3">Pengaturan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>   
                    </div>
                </div>
            </div>
        </div>            
    </div>







	<div class="col-xs-12 col-md-8">
        <div class="content-chart main-content">
        <div id="bar-chart-department"></div>
            <div id="donut-chart"></div>
            <div id="chart"></div>
            
            
        </div><!-- /.content-chart.main-content -->
    </div>

@section('script')
    <script type="text/javascript">
        $('.nav-tabs a:first').tab('show');
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
                    { 'data': 'AnggotaKelompok', 'name': 'anggota_kelompok' },
                    { 'data': 'Des', 'name': 'deskripsi_produk' },
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

    	var chartw = c3.generate({
        'bindto': '#chart',
        'data': {
          'columns': [
            ['data1', 30, 200, 100, 400, 150, 250],
            ['data2', 50, 20, 10, 40, 15, 25]
          ],
          'axes': {
            'data2': 'y2' // ADD
          }
        },
        'axis': {
          'y2': {
            'show': true // ADD
          }
        }
    });

    	var chart = c3.generate({
    	bindto: '#donuts-chart',
        data: {
            columns: [
                ['data1', -30, 200, 200, 400, -150, 250],
                ['data2', 130, 100, -100, 200, -150, 50],
                ['data3', -230, 200, 200, -300, 250, 250]
            ],
            type: 'bar',
            groups: [
                ['data1', 'data2']
            ]
        },
        grid: {
            y: {
                lines: [{value:0}]
            }
        }
    });

    	var deptChart = c3.generate({
                'bindto' : '#bar-chart-department',
                'data'   : {
                    'type': 'bar',
                    'labels':true,
                    'order':'asc',
                    'url'      : '{{ url('/report') }}',
                    'mimeType' : 'json',                
                    'keys'     : {
                         x: 'Nama', // it's possible to specify 'x' when category axis
                        'value' : [
                            'Jumlah'
                        ],
                    },
                    // groups: [
                    //     ['Accepted', 'Rejected', 'On Process']
                    // ]
                },
                'color'  : {
                    'pattern': [
                        '#008C1B', // green
                        '#CB0000', // red
                        '#000000', // black
                        '#A59C00', // dark yellow
                        '#0066b2', // blue
                    ],
                },
                axis: {
                    rotated: true,
                    x: {
                       label: {
                  text: 'States',
                  position: 'outer-center',
                },
                type: 'category',
                categories: ['MA', 'ME', 'NY', 'CN', 'TX'],
                tick: {
                  centered: true
                }
                    },
                    y: {
                        tick: {
                            format: function (d) {return (parseInt(d) == d) ? d : null;}
                            //format: function (x) { return ''; }
                        }
                    }
                },
                // grid: {
                //     y: {
                //         lines: [{value:0}]
                //     }
                // }
            });

    	c3.generate({
                'bindto' : '#bars-chart-department',
                'data'   : {
                    'x'        : 'Year',
                    'url'      : '{{ url('/report') }}',
                    'mimeType' : 'json',
                    'type'     : 'bar',
                },
                'bar': {
                    'width': {
                        'ratio': 0.5
                    },
                },
                'color'  : {
                    'pattern': [
                        '#008C1B', // green
                        '#000000', // black
                        '#A59C00', // dark yellow
                        '#CB0000', // red
                    ],
                },
            });

    	c3.generate({
                'bindto' : '#donut-chart',
                'data'   : {
                    'url'      : '{{ url('/report') }}',
                    'mimeType' : 'json',
                    'type'     : 'donut',
                    'keys'     : {
                        'value' : [
                            'Spasia',
                            'Jumlah',
                            'A',
                            'B',
                            '',
                        ],
                    },
                },
                'color'  : {
                    'pattern': [
                        '#008C1B', // green
                        '#CB0000', // red
                        '#000000', // black
                        '#A59C00', // dark yellow
                        '#0066b2', // blue
                    ],
                },
                'donut'  : {
                    'title': 'Total Candidate Statistic',
                }
            });
    </script>

@stop