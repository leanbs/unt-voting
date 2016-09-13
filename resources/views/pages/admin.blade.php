@extends('layouts.main')

@section('page-content')
	<div class="col-xs-12 col-md-8">
        <div class="content-chart main-content">
        <div id="bar-chart-department"></div>
            <div id="donut-chart"></div>
            <div id="chart"></div>
            
            
        </div><!-- /.content-chart.main-content -->
    </div>

@section('script')
<script type="text/javascript">
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