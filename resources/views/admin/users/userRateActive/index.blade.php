@extends('layouts.master')
@section('title')
    Thống kê tỷ lệ users active
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
                            {!! Form::open(['method'=>'GET','url'=>'users/userRateActive','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">User ID</label>
                                    <input class="form-control" name="userID" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">IME</label>
                                    <input class="form-control" name="ime" type="text" />
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="date_charge" id="id-date-range-picker-1"  value="{{request('date_charge')}}" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Hệ điều hành</label>

                                    {!! Form::select('clientType', $clientType, request('clientType'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Địa chỉ IP</label>
                                    <input class="form-control" name="ip" type="text" />
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
                            <th class="hidden-480">User ID</th>
                            <th>Tên đăng nhập</th>
                            <th class="hidden-480">Logged in time</th>
                            <th class="hidden-480">IME</th>
                            <th class="hidden-480">Thông tin thiết bị</th>
                            <th class="hidden-480">Địa chỉ Ip</th>
                            <th class="hidden-480">Client type</th>
                            <th>Package name</th>
                            <th>Version code</th>
                            <th>Version build</th>
                            {{--<th>Ip locked</th>--}}
                            {{--<th>Relogged in</th>--}}
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td class="hidden-480">{{ $rs->userId }}</td>
                                <td>{{ $rs->userName }}</td>
                                <td class="hidden-480">{{ $rs->loggedInTime }}</td>
                                <td class="hidden-480">{{ $rs->deviceId }}</td>
                                <td class="hidden-480">{{ $rs->deviceInfo }}</td>
                                <td class="hidden-480">{{ $rs->remoteIp }}</td>
                                <td class="hidden-480">{{ $clientType[$rs->clientType] }}</td>
                                <td>{{ $rs->packageName }}</td>
                                <td>{{ $rs->versionCode }}</td>
                                <td>{{ $rs->versionBuild }}</td>
                                {{--<td>{{ $rs->ipLocked }}</td>--}}
                                {{--<td>{{ $rs->reloggedIn }}</td>--}}
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

        });
    </script>

    <script type="text/javascript">
        $(function () {
                <?php if($login_arr != ''):?>
            var array_date = new Array();
            var total3 = new Array();
            var total5 = new Array();
            var total7 = new Array();
            var total30 = new Array();
            <?php foreach($login_arr as $day => $value):?>
                array_date.push(['<?php echo $day;  ?>']);
                total3.push(<?php echo isset($value[0]) ? $value[0] : 0;  ?>);
                total5.push(<?php echo isset($value[1]) ? $value[1] : 0;  ?>);
                total7.push(<?php echo isset($value[2]) ? $value[2] : 0;  ?>);
                total30.push(<?php echo isset($value[3]) ? $value[3] : 0;  ?>);
            <?php endforeach ?>
        $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Thống kê user đăng nhập'
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
                    name: 'R3',
                    data: total3
                }, {
                    name: 'R5',
                    data: total5
                }, {
                    name: 'R7',
                    data: total7
                }, {
                    name: 'R30',
                    data: total30
                }]
            });
            <?php endif; ?>
        });
    </script>
@endsection