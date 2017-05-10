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
                var date = $('input[name=date_charge]').val().split(" - ");
                var newDate = new Date();
                var newDate1 = new Date();
                var fromDate = (newDate.getMonth() + 1) + '-' + newDate.getDate() + '-' + newDate.getFullYear();
                var toDate = (newDate1.getMonth() + 1) + '-' + newDate1.getDate() + '-' + newDate1.getFullYear();
                if(date != ''){
                    fromDate = date[0].split("/").join("-");
                    toDate = date[1].split("/").join("-");
                }
                $.get('/revenue/revenueDay/statistic/' + fromDate + '/' + toDate, function( data ) {
                    var array_date = new Array();
                    var sum_money_today = new Array();
                    var cash_money_yesterday = new Array();

                    data.forEach(function(current_value, index, initial_array) {
                        array_date.push(index);
                        sum_money_today.push(current_value[0]);
                        cash_money_yesterday.push(current_value[1]);
                    });
                    $('#container1').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'So sánh doanh thu'
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
                            data: cash_money_yesterday
                        }, {
                            name: 'Hôm nay',
                            data: sum_money_today
                        }]
                    });
                });

            });
        });
    </script>
@endsection