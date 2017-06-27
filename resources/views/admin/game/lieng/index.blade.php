@extends('layouts.master')
@section('title')
    Thống kê xóc đĩa
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
                            {!! Form::open(['method'=>'GET','url'=>'game/lieng','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">User ID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Room ID</label>
                                    <input class="form-control" name="roomId" type="text" value="{{request('roomId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Match ID</label>
                                    <input class="form-control" name="matchIndex" type="text" value="{{request('matchIndex')}}"/>
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
                            <th>Room ID</th>
                            <th>Match Index</th>
                            <th>Mô tả</th>
                            <th>Created time</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->roomId }}</td>
                                <td>{{ $rs->matchIndex }}</td>
                                <td>
                                    <?php $arr_des = explode("+",getDescriptionLieng($rs->description));
                                    ?>
                                    @foreach ($arr_des as $des)
                                    {{ $des }}</br>
                                    @endforeach
                                </td>
                                <td>{{ $rs->createdTime }}</td>
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
@endsection