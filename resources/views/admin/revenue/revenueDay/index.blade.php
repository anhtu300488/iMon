@extends('layouts.master')
@section('title')
    Doanh thu theo ngày
@endsection
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box">
                    <div class="widget-header widget-header-flat widget-header-small">
                        <h5 class="widget-title">
                            <i class="ace-icon fa fa-signal"></i>
                            Doanh thu tổng hợp
                        </h5>

                        <div class="widget-toolbar no-border">
                            <div class="inline dropdown-hover">
                                <button class="btn btn-minier btn-primary">
                                    This Week
                                    <i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
                                    <li class="active">
                                        <a href="#" class="blue">
                                            <i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i>
                                            This Week
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                            Last Week
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                            This Month
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                            Last Month
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <!-- #section:plugins/charts.flotchart -->
                            <div id="piechart_pub_register"></div>

                            <!-- /section:plugins/charts.flotchart -->
                            <div class="hr hr8 hr-double"></div>

                            <div class="clearfix">
                                <!-- #section:custom/extra.grid -->
                                <div class="grid3">
															<span class="grey">
																<i class="ace-icon fa fa-facebook-square fa-2x blue"></i>
																&nbsp; Thẻ cào
															</span>
                                    <h4 class="bigger pull-right">1,255111</h4>
                                </div>

                                <div class="grid3">
															<span class="grey">
																<i class="ace-icon fa fa-twitter-square fa-2x purple"></i>
																&nbsp; SMS
															</span>
                                    <h4 class="bigger pull-right">941</h4>
                                </div>

                                <div class="grid3">
															<span class="grey">
																<i class="ace-icon fa fa-pinterest-square fa-2x red"></i>
																&nbsp; IAP
															</span>
                                    <h4 class="bigger pull-right">1,050</h4>
                                </div>

                                <!-- /section:custom/extra.grid -->
                            </div>
                        </div><!-- /.widget-main -->
                    </div><!-- /.widget-body -->
                </div><!-- /.widget-box -->
            </div>

            <hr />

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
                                    <div class="input-group" >
                                        <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                    </div>
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
                            <th>Đối tác</th>
                            <th class="hidden-480">Type view</th>
                            <th>Tổng tiền nạp(VNĐ)</th>
                            <th class="hidden-480">Tổng ken nạp </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->created_date }}</td>
                                <td></td>
                                <td class="hidden-480">{{ $typeArr[$rs->type] }}</td>
                                <td>{{ $rs->sum_money }}</td>
                                <td>{{ $rs->sum_cash }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.span -->
                {{ $data->appends($_GET)->links() }}
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

            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Yearly Website Ratio'
                },
                xAxis: {
                    categories: ['2011','2012','2013','2014','2015', '2016', '2017', '2018']
                },
                yAxis: {
                    title: {
                        text: 'Rate'
                    }
                },
                series: [{
                    name: 'Click',
                    data: [1,2,3,4,5,6,7,8]
                }, {
                    name: 'View',
                    data: [2,4,6,8,10,12,14,16]
                }, {
                    name: 'View',
                    data: [4,6,8,10,12,14,16,18]
                }]
            });
        });
    </script>
    <script type="text/javascript" src="/css/jsapi.css"></script>
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
            array_type.push(['<?php echo $arr_type[$value['type']]?>', <?php echo $value['sum_money']; ?>]);
                    <?php } ?>
            var data_api = google.visualization.arrayToDataTable(array_type);
            formatter.format(data_api, 1);
            var options_api = {
                title: '<?php echo __('Doanh thu theo loại')?>',
                is3D: true
            };
            var chart_api = new google.visualization.PieChart(document.getElementById('piechart_pub_register'));
            chart_api.draw(data_api, options_api);
        }
    </script>


@endsection