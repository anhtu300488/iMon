@extends('layouts.master')
@section('title')
    Quản lý và cảnh báo kẹt bàn
@endsection
@section('content')
    <div class="page-header">
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
                            {!! Form::open(['method'=>'GET','url'=>'tool/crashTableAlarm','role'=>'search', 'name' => 'formSearch'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Room Index</label>
                                    <input class="form-control" name="roomIndex" type="text" value="{{request('roomIndex')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Game</label>

                                    {!! Form::select('game', $gameArr, request('game'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Cảnh báo</label>

                                    {!! Form::select('isAlarm', $alarmArr, request('isAlarm'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" id="search_button" class="btn btn-info btn-sm">
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
                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="hidden-480">STT</th>
                                <th>Game</th>
                                <th>Phòng</th>
                                <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Ngày tạo</th>
                                <th>Cảnh báo</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $key => $rs)
                                <tr>
                                    <td class="hidden-480">{{ ++$i }}</td>
                                    <td>{{ $gameArr[$rs->gameId] }}</td>
                                    <td>{{ $rs->roomIndex + 1 }}</td>
                                    <td class="hidden-480">{{ $rs->insertTime }}</td>
                                    <td>@if($rs->isAlarm == 1)  <span class="label label-sm label-success">Bật</span> @else <span class="label label-sm label-inverse arrowed-in">Tắt</span> @endif</td>
                                    <td>
                                        {!! Form::open(['method' => 'PATCH','route' => ['crashTableAlarm.update', $rs->crashId],'style'=>'display:inline']) !!}
                                        @if($rs->isAlarm == 1)
                                            <button class="btn btn-xs btn-inverse" type="submit" value="alarmOff" name="alarmOff" title="Tắt cảnh báo" onclick='return confirm("Bạn có chắc chắn muốn tắt cảnh báo?");'>
                                                <i class="ace-icon fa fa-times"></i>
                                            </button>
                                            <button class="btn btn-xs btn-danger" type="submit" value="deleteRoom" name="deleteRoom" title="Xóa phòng" onclick='return confirm("Bạn có chắc chắn muốn xóa phòng?");'>
                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                            </button>
                                        @endif
                                        {!! Form::close() !!}
                                    </td>
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
            $('input[name=insertTime]').daterangepicker({
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

@endsection