@extends('layouts.master')
@section('title')
    Thống kê CCU
@endsection
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Tìm kiếm</h4>

                        <span class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </span>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            {!! Form::open(['method'=>'GET','url'=>'revenue/ccu','role'=>'search'])  !!}
                            {{--<form action="{{url('logPayment')}}" role="search" method="get" >--}}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Ngày</label>
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="insertedtime" value="{{request('insertedtime')}}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>


                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Thời gian</label>
                                    {!! Form::select('option', $timeArr, request('option'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

                                </div>

                                @permission('administrator')
                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Đối tác</label>
                                    {!! Form::select('partner', $partner, request('partner'), ['class' => 'form-control', 'id' => "partner"]) !!}

                                </div>
                                @endpermission
                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Game</label>
                                    {!! Form::select('list_games', $list_games, request('list_games'), ['class' => 'form-control', 'id' => "list_games"]) !!}
                                </div>

                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <a href="#modal-table" class="btn btn-info btn-sm" data-toggle="modal">
                                        <span class="ace-icon fa fa-signal"></span>
                                        Phân tích
                                    </a>
                                </div>
                            </div>
                            {{--</form>--}}
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-sm-12">
            <div id="container"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <b>Lượng CCU ở thời điểm gần nhất</b>
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <?php foreach ($arr_game as $name => $numOnline) {?>
                            <td class="sf_admin_text" style="background-color: #d1d1e6"><?php echo $name; ?>
                                <h2 style="color: red"><?php echo $numOnline?></h2>
                            </td>
                            <?php }?>
                        </tr>
                        </thead>
                    </table>
                </div><!-- /.span -->
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div id="modal-table" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header no-padding">
                    <div class="table-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="white">&times;</span>
                        </button>
                        Thống kê lượng CCU theo thời gian
                    </div>
                </div>
                <div id="table-wrapper">
                    <div class="modal-body no-padding" id = "table-scroll">
                        <div id="container1"></div>

                    </div>

                </div>


                <div class="modal-footer no-margin-top">
                    <button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Close
                    </button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <script>
        jQuery(function($) {

            //datepicker plugin
            //link
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            })
            //show datepicker when clicking on the icon
                .next().on(ace.click_event, function(){
                $(this).prev().focus();
            });

            //or change it into a date range picker
            $('.input-daterange').datepicker({autoclose:true});

        });
    </script>
    <script type="text/javascript">
        $(function () {
            <?php if($arr_log != ''):?>
            var array_date = new Array();
            var sum_money = new Array();
            var cash_money = new Array();
            <?php foreach($arr_log as $time => $value):?>
                array_date.push(['<?php echo reFormatDate($time, "H:i");  ?>']);
                sum_money.push(<?php echo isset($value[0])? $value[0] : 0  ?>);
                cash_money.push(<?php echo isset($value[1])? $value[1] : 0 ?>);
            <?php endforeach ?>
            $('#container').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'CCU'
                },
                xAxis: {
                    categories: array_date
                },
                yAxis: {
                    title: {
                        text: 'Rate'
                    }
                },
                series: [{
                    name: 'Online',
                    data: sum_money
                }, {
                    name: 'Trong bàn',
                    data: cash_money
                }]
            });
            <?php endif; ?>
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $('#modal-table').on("show.bs.modal", function (e) {
                var partner = $('#partner').val();
                var gameId = $('#list_games').val();

                if(partner == ''){
                    partner = 1;
                }
                if(gameId == ''){
                    gameId = -1;
                }
                $.get('/revenue/ccu/statistic/' + gameId + '/' + partner, function( data ) {
                    var array_date = new Array();
                    var online_today = new Array();
                    var online_yesterday = new Array();
                    Object.keys(data).forEach(function(index) {
                        array_date.push(index);
                        var data0 = (data[index][0] === undefined) ? 0 : data[index][0];
                        var data1 = (data[index][1] === undefined) ? 0 : data[index][1];
                        online_yesterday.push(data0);
                        online_today.push(data1);
                    });

                    $('#container1').highcharts({
                        chart: {
                            type: 'area'
                        },
                        title: {
                            text: 'So sánh CCU theo thời gian'
                        },
                        xAxis: {
                            categories: array_date
                        },
                        yAxis: {
                            title: {
                                text: 'Rate'
                            }
                        },
                        series: [{
                            name: 'Hôm qua',
                            data: online_yesterday
                        }, {
                            name: 'Hôm nay',
                            data: online_today
                        }]
                    });
                });

            });
        });
    </script>
@endsection