@extends('layouts.master')
@section('title')
    Tạo thông báo toàn server
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
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
            <!-- PAGE CONTENT BEGINS -->
            {!! Form::open(array('route' => 'emergencyNotification.store','method'=>'POST', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Nội dung</label>
                <div class="col-sm-9">
                    {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-3 control-label no-padding-right" for="id-date-picker-1">Thời gian bắt đầu</label>
                <div class="input-group col-sm-9" style="padding-left: 12px; padding-right: 12px;">
                    {!! Form::text('fromDate', null, array('class' => 'form-control date-picker','id' => 'id-date-picker-1', 'data-date-format' => 'dd-mm-yyyy')) !!}
                    <span class="input-group-addon">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>

                    {!! Form::text('fromTime', null, array('class' => 'form-control','id' => 'timepicker1')) !!}
                    <span class="input-group-addon">
                        <i class="fa fa-clock-o bigger-110"></i>
                    </span>
                </div>

            </div>


            <div class="form-group" >
                <label class="col-sm-3 control-label no-padding-right" for="id-date-picker-1">Thời gian kết thúc</label>
                <div class="input-group col-sm-9" style="padding-left: 12px; padding-right: 12px;">

                    {!! Form::text('toDate', null, array('class' => 'form-control date-picker','id' => 'id-date-picker-1', 'data-date-format' => 'dd-mm-yyyy')) !!}
                    <span class="input-group-addon">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>

                    {!! Form::text('toTime', null, array('class' => 'form-control','id' => 'timepicker2')) !!}
                    <span class="input-group-addon">
                        <i class="fa fa-clock-o bigger-110"></i>
                    </span>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Trạng thái</label>
                <div class="col-sm-9">
                    {!! Form::hidden('active',0) !!}
                    {{ Form::checkbox('active', 1, true, ['class' => 'field']) }}
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>

            <div class="hr hr-24"></div>

            {!! Form::close() !!}

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

            $('#timepicker1').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            }).next().on(ace.click_event, function(){
                $(this).prev().focus();
            });

            $('#timepicker2').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            }).next().on(ace.click_event, function(){
                $(this).prev().focus();
            });

        });
    </script>
@endsection