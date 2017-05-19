@extends('layouts.master')
@section('title')
    Thống kê số lượng thẻ đổi
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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/cashOut','role'=>'search'])  !!}

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian đổi thẻ</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="timeRequest" id="id-date-range-picker-1" value="{{request('timeRequest') ? request('timeRequest') : get7Day()}}" />
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
                            <th class="hidden-480">STT</th>
                            <th>Tổng số thẻ đổi</th>
                            <th>Tổng số tiền đổi</th>
                            <th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian đổi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ number_format($rs->sumCash) }}</td>
                                <td>{{ number_format($rs->sumMoney) }}</td>
                                <td>{{ $rs->purchase_date }}</td>
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
            $('input[name=timeRequest]').daterangepicker({
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
                var sumCash = new Array();
                <?php foreach($purchase_arr as $day => $value):?>
                    array_date.push(['<?php echo $day;  ?>']);
                    sum_money.push(<?php echo isset($value[0]) ? $value[0] : 0  ?>);
                    sumCash.push(<?php echo isset($value[1]) ? $value[1] : 0  ?>);
                <?php endforeach ?>
            $('#container').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Thống kê đổi thưởng'
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
                        name: 'Tổng tiền đổi thưởng',
                        data: sum_money
                    }, {
                        name: 'Số lượng thẻ đổi thưởng',
                        data: sumCash
                    }]
                });
        });
        <?php endif; ?>
    </script>
    @endsection