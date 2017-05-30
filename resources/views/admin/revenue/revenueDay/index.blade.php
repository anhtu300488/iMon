@extends('layouts.master')
@section('title')
    Doanh thu theo ngày
@endsection
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <div class="page-header">
        <div class="row">
            <div class="col-sm-4">
                <div id="piechart_pub_type"></div>

            </div>
            <div class="col-sm-8">
                <b>Sau telco:</b>
                <p>Thẻ cào: {{ number_format($sum_the) }}</p>
                <p>9029: {{ number_format($sum_9029) }}</p>
                <p>8x98: {{ number_format($sum_8x) }}</p>
                <p>Chi phí đổi thưởng: {{ number_format($sum_doi_thuong) }}</p>
                <p>Sau telco trừ đổi thưởng: {{ number_format($loi_nhuan) }}</p>
            </div>
            <div class="col-sm-12">
                <div id="container"></div>
            </div>
        </div>
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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/revenueDay','role'=>'search'])  !!}
                            {{--<form action="{{url('logPayment')}}" role="search" method="get" >--}}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Đối tác</label>
                                    {!! Form::select('partner', $partner, request('partner'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Hệ điều hành</label>

                                    {!! Form::select('clientType', $clientType, request('clientType'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian nạp tiền</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="date_charge" id="date_charge" value="{{request('date_charge')}}" />
                                        <span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Thời gian bắt đầu chơi game</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="date_play_game" id="id-date-range-picker-1" value="{{request('date_play_game')}}" />
                                        <span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Loại</label>

                                    {!! Form::select('type', $typeArr, request('type'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

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
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày tạo</th>
                            <th class="hidden-480">Đối tác</th>
                            <th class="hidden-480">Type view</th>
                            <th>Tổng tiền nạp(VNĐ)</th>
                            <th>Tổng mon nạp </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->created_date }}</td>
                                <td class="hidden-480">{{$partner[request('partner')]}}</td>
                                <td class="hidden-480">{{ $typeArr[$rs->type] }}</td>
                                <td>{{ number_format($rs->sum_money) }}</td>
                                <td>{{ number_format($rs->sum_cash) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.span -->

                @include('layouts.partials._pagination')
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
                        Thống kê doanh thu theo thời gian
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

            //or change it into a date range picker
            $('.input-daterange').datepicker({autoclose:true});


            //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
            $('input[name=date_charge]').daterangepicker({
                'applyClass' : 'btn-sm btn-success',
                'cancelClass' : 'btn-sm btn-default',
                locale: {
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                }
            })
                .prev().on(ace.click_event, function(){
                $(this).next().focus();
            });

            $('input[name=date_play_game]').daterangepicker({
                'applyClass' : 'btn-sm btn-success',
                'cancelClass' : 'btn-sm btn-default',
                locale: {
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                }
            })
                .prev().on(ace.click_event, function(){
                $(this).next().focus();
            });
        });
    </script>

    <script type="text/javascript">
        <?php if($purchase_arr != null):?>
        $(function () {
                var array_date = new Array();
                var sum_money = new Array();
                var cash_money = new Array();
                var iap_money = new Array();
                var total_money = new Array();
                var exchange_money = new Array();
                <?php foreach($purchase_arr as $day => $value):?>
                    array_date.push(['<?php echo $day;  ?>']);
                    sum_money.push(<?php echo isset($value[2][0])? $value[2][0] : 0  ?>);
                    cash_money.push(<?php echo isset($value[1][0])? $value[1][0] : 0 ?>);
                    iap_money.push(<?php echo isset($value[3][0])? $value[3][0] : 0 ?>);
                    <?php $arr1 = isset($value[1][1]) ? $value[1][1] : 0;
                        $arr2 = isset($value[2][1]) ? $value[2][1] : 0;  ?>
                    total_money.push(<?php echo (int)($arr1 + $arr2) / 10;  ?>);
                    exchange_money.push(<?php echo isset($value[4]) ?  $value[4] : 0 ?>);
                <?php endforeach ?>
            $('#container').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Doanh thu theo ngày'
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
                        name: 'SMS',
                        data: sum_money
                    }, {
                        name: 'Thẻ cào',
                        data: cash_money
                    }, {
                        name: 'Tổng mon nạp vào game',
                        data: total_money
                    }, {
                        name: 'Đổi thưởng',
                        data: exchange_money
                    }, {
                        name: 'IAP',
                        data: iap_money
                    }]
                });
        });
        <?php endif; ?>
    </script>
    <script type="text/javascript" src="{!! asset('css/jsapi.css') !!}"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});

        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var formatter = new google.visualization.NumberFormat({
                pattern: '###,###'
            });

            //Hình 1: Loại nhà phát triển
            var array_type = new Array(['Task', '<?php echo __('Loại hệ điều hành')?>']);
            <?php
            $arr_type = array(1 => "Thẻ cào", 2 =>"SMS", 3 => "IAP");
            foreach ($total_by_type as $value) {?>
            array_type.push(['<?php echo $arr_type[$value->type]?>', <?php echo $value->sum_money; ?>]);
                    <?php } ?>
            var data_api = google.visualization.arrayToDataTable(array_type);
            formatter.format(data_api, 1);
            var options_api = {
                title: '<?php echo __('Doanh thu theo loại')?>',
                is3D: true
            };
            var chart_api = new google.visualization.PieChart(document.getElementById('piechart_pub_type'));
            chart_api.draw(data_api, options_api);
        }
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
//                    $(".modal-body").html(data);
//                    alert(JSON.stringify(data[4][0]));
                    var array_date = new Array();
                    var sum_money_today = new Array();
                    var cash_money_yesterday = new Array();
                    Object.keys(data).forEach(function(index) {
                        array_date.push(index);
                        var data0 = (data[index][0] === undefined) ? 0 : data[index][0];
                        var data1 = (data[index][1] === undefined) ? 0 : data[index][1];
                        sum_money_today.push(data0);
                        cash_money_yesterday.push(data1);
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