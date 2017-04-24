@extends('layouts.master')
@section('title')
    Tiền trung bình của user active
@endsection
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <div class="page-header">
        <div class="row">

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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/revenueUserActive','role'=>'search'])  !!}

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
                            <th>Tổng user đăng nhập</th>
                            <th>Tổng doanh thu </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->created_date }}</td>
                                <td>{{ number_format($rs->total) }}</td>
                                <td>{{ number_format($rs->sum_money) }}</td>
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
        <?php if($purchase_arr != null):?>
        $(function () {

                var array_date = new Array();
                var rau = new Array();
                <?php foreach($purchase_arr as $day => $value):?>
                    array_date.push(['<?php echo $day;  ?>']);
                    rau.push(<?php echo isset($value)? $value : 0  ?>);
                <?php endforeach ?>
            $('#container').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Tiền trung bình của user active'
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
                        name: 'Tiền trung bình của user active',
                        data: rau
                    }]
                });

        });
        <?php endif; ?>
    </script>


@endsection