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
                                        <input class="form-control" type="text" name="date_charge" id="id-date-range-picker-1" value="{{request('date_charge')}}" />
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
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
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
                            <th>Tổng ken nạp </th>
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
        $(function () {
            <?php if($purchase_arr != ''):?>
                var array_date = new Array();
                var sum_money = new Array();
                var cash_money = new Array();
                var total_money = new Array();
                var exchange_money = new Array();
                <?php foreach($purchase_arr as $day => $value):?>
                    array_date.push(['<?php echo $day;  ?>']);
                    sum_money.push(<?php echo isset($value[2][0])? $value[2][0] : 0  ?>);
                    cash_money.push(<?php echo isset($value[1][0])? $value[1][0] : 0 ?>);
                    <?php $arr1 = isset($value[1][1]) ? $value[1][1] : 0;
                        $arr2 = isset($value[2][1]) ? $value[2][1] : 0;  ?>
                    total_money.push(<?php echo $arr1 + $arr2;  ?>);
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
                        name: 'Tổng ken nạp vào game',
                        data: total_money
                    }, {
                        name: 'Đổi thưởng',
                        data: exchange_money
                    }]
                });
            <?php endif; ?>
        });
    </script>
    <script type="text/javascript" src="{!! asset('css/jsapi.css') !!}"></script>
<!--    --><?php //var_dump($total_by_type);die;?>
    <script type="text/javascript">
//        google.load("visualization", "1", {packages:["" +
//        ""]});
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


@endsection