@extends('layouts.master')
@section('title')
    Quản lý log user đăng nhập
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
                            {!! Form::open(['method'=>'GET','url'=>'users/logUserLogin','role'=>'search', 'name' => 'formSearch'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">User ID</label>
                                    <input class="form-control" name="userID" type="text" value="{{request('userID')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">IME</label>
                                    <input class="form-control" name="ime" type="text" value="{{request('ime')}}"/>
                                </div>

                            </div>
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
                                    <label  for="form-field-select-1">Hệ điều hành</label>

                                    {!! Form::select('clientType', $clientType, request('clientType'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Địa chỉ IP</label>
                                    <input class="form-control" name="ip" type="text" value="{{request('ip')}}"/>
                                </div>

                            </div>
                            {!! Form::close() !!}
                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" onclick="document.formSearch.submit();" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <a href="{{ route('logUserLogin.excel', ['userID' => request('userID'), 'userName' => request('userName'), 'ime' => request('ime'), 'date_charge' => request('date_charge'), 'clientType' => request('clientType'), 'ip' => request('ip')]) }}">
                                        <button class="btn btn-info btn-sm">
                                            Download Excel xlsx
                                        </button>
                                    </a>
                                </div>
                            </div>

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
        <?php if($login_arr != null):?>
        $(function () {

            var array_date = new Array();
            var total = new Array();
            <?php foreach($login_arr as $day => $value):?>
                array_date.push(['<?php echo $day;  ?>']);
                total.push(<?php echo $value;  ?>);
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
                    name: 'Số user đăng nhập',
                    data: total
                }]
            });

        });
        <?php endif; ?>
    </script>
@endsection