@extends('layouts.master')
@section('title')
    Số lượng tiền vào game
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
                            {!! Form::open(['method'=>'GET','url'=>'moneyGame/income','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="date_charge" id="id-date-range-picker-1" value="{{request('date_charge')}}" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Hình thức</label>
                                    {!! Form::select('transaction', $transactionArr, request('transaction'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Loại tiền</label>

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
                            <th class="hidden-480">STT</th>
                            <th>Tổng tiền</th>
                            <th>Hình thức</th>
                            <th>Time</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                        <tr>
                            <td class="hidden-480">{{ ++$i }}</td>
                            <td>{{ number_format($rs->sum_money) }}</td>
                            <td>{{ $transactionArr[$rs->type] }}</td>
                            <td>{{ $rs->created_date }}</td>
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
                <?php if($moneyArr != ''):?>
            var array_date = new Array();
            var total2 = new Array();
            var total3 = new Array();
            var total7 = new Array();
            <?php foreach($moneyArr as $day => $value):?>
                array_date.push(['<?php echo $day;  ?>']);
                total2.push(<?php echo isset($value[2])? $value[2] : 0  ?>);
                total3.push(<?php echo isset($value[3])? $value[3] : 0 ?>);
                total7.push(<?php echo isset($value[7]) ?  $value[7] : 0 ?>);
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
                    name: 'Nạp tiền',
                    data: total2
                }, {
                    name: 'Quà tặng hệ thống',
                    data: total3
                }, {
                    name: 'Giftcode',
                    data: total7
                }]
            });
            <?php endif; ?>
        });
    </script>

    @endsection