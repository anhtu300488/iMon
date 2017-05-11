@extends('layouts.master')
@section('title')
    Người dùng đăng ký
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
                            {!! Form::open(['method'=>'GET','url'=>'users/userReg','role'=>'search', 'name' => 'formSearch'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">UserID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên hiển thị</label>
                                    <input class="form-control" name="displayName" type="text" value="{{request('displayName')}}"/>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Từ ngày</label>
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="fromDate" value="{{request('fromDate')}}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Đến ngày</label>
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="toDate" value="{{request('toDate')}}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Thiết bị</label>
                                    <input class="form-control" name="device" type="text" value="{{request('device')}}"/>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">IP</label>
                                    <input class="form-control" name="ip" type="text" value="{{request('ip')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Hệ điều hành</label>

                                    {!! Form::select('clientType', $clientType, request('clientType'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Trạng thái</label>

                                    {!! Form::select('status', $statusArr, request('status'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" id="search_button" onclick="document.formSearch.submit();" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <a href="{{ route('userReg.excel', ['userName' => request('userName'), 'fromDate' => request('fromDate'), 'toDate' => request('toDate'), 'device' => request('device'), 'ip' => request('ip'), 'clientType' => request('clientType')]) }}">
                                        <button class="btn btn-info btn-sm">
                                            Download Excel
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
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-xs-12">
                    {!! Form::open(['method'=>'POST','url'=>'users/userReg/lockUser','role'=>'search', 'name' => 'formLockUser'])  !!}
                    {{ csrf_field() }}
                    <button class="btn btn-warning" type="submit" name="lock" value="lock" onclick="confirm('Are you sure?');">Tạm khóa</button> <button class="btn btn-danger" type="submit" name="delete" value="delete" onclick="confirm('Are you sure?');">Khóa vĩnh viễn</button> <button class="btn btn-success" type="submit" name="unlock" value="unlock" onclick="confirm('Are you sure?')">Mở khóa</button>
                        <hr />
                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="hidden-480">STT</th>
                                <th><input type="checkbox" onclick="toggle(this);" /></th>
                                <th>UserID</th>
                                <th>Tên đăng nhập</th>
                                <th>Tên hiển thị</th>
                                <th class="hidden-480">IP</th>
                                <th>
                                    Thiết bị
                                </th>
                                <th class="hidden-480">Đối tác</th>
                                <th>Nền tảng</th>
                                <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Ngày đăng ký</th>
                                <th>Trạng thái</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $key => $rs)
                                <tr>
                                    <td class="hidden-480">{{ ++$i }}</td>
                                    <td><input type="checkbox" name="userIds[]" class="checkboxes" value="{{ $rs->userId }}" /></td>
                                    <td>{{ $rs->userId }}</td>
                                    <td>{{ $rs->userName }}</td>
                                    <td>{{ $rs->displayName }}</td>
                                    <td class="hidden-480">{{ $rs->ip }}</td>
                                    <td>{{ $rs->device }}</td>
                                    <td class="hidden-480">{{ $rs->cp }}</td>
                                    <td>{{ $clientType[$rs->clientId] }}</td>
                                    <td class="hidden-480">{{ $rs->registedTime }}</td>
                                    <td>@if($rs->status == 1)  <span class="label label-sm label-success">Active</span> @elseif($rs->status == 3) <span class="label label-sm label-inverse arrowed-in">Lock</span> @else <span class="label label-sm label-inverse arrowed-in">Deactive</span> @endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! Form::close() !!}
                </div><!-- /.span -->
                @include('layouts.partials._pagination')
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

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

        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

    </script>
    <script type="text/javascript">
        <?php if($sevent_day != null):?>
        $(function () {
            var array_date = new Array();
            var register = new Array();
            var device = new Array();
            var stop_play = new Array();
            var login = new Array();
            <?php foreach($sevent_day as $day => $value):?>
                array_date.push(['<?php echo $day;  ?>']);
                register.push(<?php echo $value[0]  ?>);
                device.push(<?php echo $value[1]  ?>);
                stop_play.push(<?php echo $value[2]  ?>);
                login.push(<?php echo $value[3]  ?>);
            <?php endforeach ?>
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Thông tin người chơi đăng ký'
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
                    name: 'Đăng ký mới',
                    data: register
                }, {
                    name: 'Thiết bị mới',
                    data: device
                }, {
                    name: 'Nghỉ chơi trong ngày',
                    data: stop_play
                }, {
                    name: 'Đăng nhập trong ngày',
                    data: login
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
            <?php foreach ($total_by_os as $value) {?>
            array_type.push(['<?php echo $value->name?>', <?php echo $value->sum_os; ?>]);
                <?php } ?>
            var data_api = google.visualization.arrayToDataTable(array_type);
            formatter.format(data_api, 1);
            var options_api = {
                title: '<?php echo __('Loại hệ điều hành')?>',
                is3D: true
            };
            var chart_api = new google.visualization.PieChart(document.getElementById('piechart_pub_type'));
            chart_api.draw(data_api, options_api);

        }
    </script>

@endsection