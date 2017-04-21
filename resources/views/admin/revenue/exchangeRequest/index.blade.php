@extends('layouts.master')
@section('title')
    Chi tiết giao dịch đổi thưởng
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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/exchangeRequest','role'=>'search'])  !!}
                            {{--<form action="{{url('logPayment')}}" role="search" method="get" >--}}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">SĐT xác thực</label>
                                    <input class="form-control" name="phone" type="text" value="{{request('phone')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Trạng thái</label>
                                    {!! Form::select('status', $statusArr, request('status'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

                                </div>

                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian đổi thẻ</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="timeRequest" id="id-date-range-picker-1" value="{{request('timeRequest')}}" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Request topup</label>
                                    <input class="form-control" name="requestTopup" type="text" value="{{request('requestTopup')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">ResponseData</label>
                                    <input class="form-control" name="responseData" type="text" value="{{request('responseData')}}"/>
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
                            <th class="hidden-480">User ID</th>
                            <th class="hidden-480">Tên hiển thị</th>
                            <th>Tên đăng nhập</th>
                            <th>SDT xác thực</th>
                            <th class="hidden-480">Asset</th>
                            <th>Total cash</th>
                            <th>Giá trị thẻ</th>
                            <th>Trạng thái</th>
                            {{--<th class="hidden-480">Response data</th>--}}
                            <th class="hidden-480">Request topup</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian tạo</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                        <tr>
                            <td class="hidden-480">{{ ++$i }}</td>
                            <td class="hidden-480">{{ $rs->requestUserId }}</td>
                            <td class="hidden-480">{{ $rs->requestUserName }}</td>
                            <td>{{ $rs->requestUserName }}</td>
                            <td></td>
                            <td class="hidden-480">{{ $rs->assetId }}</td>
                            <td>{{ number_format($rs->totalCash) }}</td>
                            <td>{{ number_format($rs->totalParValue) }}</td>
                            <td>@if($rs->status == 1)  <span class="label label-sm label-success">Success</span> @else <span class="label label-sm label-inverse arrowed-in">Unsucess</span> @endif</td>
                            {{--<td class="hidden-480">{{ $rs->responseData }}</td>--}}
                            <td class="hidden-480">{{ $rs->request_topup_id }}</td>
                            <td class="hidden-480">{{ $rs->created_at }}</td>
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
        $(function () {
            <?php if($purchase_arr != ''):?>
                var array_date = new Array();
                var sum_money = new Array();
                <?php foreach($purchase_arr as $day => $value):?>
                    array_date.push(['<?php echo $day;  ?>']);
                    sum_money.push(<?php echo isset($value)? $value : 0  ?>);
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
                        name: 'Tiền rút',
                        data: sum_money
                    }]
                });
            <?php endif; ?>
        });
    </script>
    @endsection