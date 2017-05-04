@extends('layouts.master')

@section('title')
    Sửa nội dung notification
@endsection

@section('content')
    <div class="page-header">
        <h1>
            Edit Message Server
        </h1>
    </div><!-- /.page-header -->
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
    {!! Form::model($notification, ['method' => 'PATCH', 'class' => 'form-horizontal','route' => ['notification.update', $notification->notificationId]]) !!}
    <div class="row">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Tiêu đề</label>
            <div class="col-sm-9">
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Nội dung push</label>
            <div class="col-sm-9">
                {!! Form::textarea('message', null, array('placeholder' => 'Nội dung push','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="timepicker1">Push Time</label>

            <!-- #section:plugins/date-time.timepicker -->
            <div class="input-group bootstrap-timepicker col-sm-9" style="padding-left: 11px">
                {!! Form::text('pushTime', null, array('placeholder' => 'pushTime','class' => 'form-control','id' => 'timepicker1')) !!}
                <span class="input-group-addon">
                        <i class="fa fa-clock-o bigger-110"></i>
                    </span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Lặp lại hàng ngày</label>
            <div class="col-sm-9">
                {{--{!! Form::text('repeat_daily', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}--}}
                {!! Form::hidden('repeat_daily',0) !!}
                {{ Form::checkbox('repeat_daily', 1, null, ['class' => 'field']) }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Trạng thái</label>
            <div class="col-sm-9">
                {!! Form::hidden('status',0) !!}
                {{ Form::checkbox('status', 1, null, ['class' => 'field']) }}
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
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        jQuery(function($) {
            tinymce.init({
                selector: 'textarea',
                height: 200,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                content_css: '//www.tinymce.com/css/codepen.min.css'
            });

        })
    </script>
    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {

            //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
            $('input[name=date-range-picker]').daterangepicker({
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


            $('#timepicker1').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            }).next().on(ace.click_event, function(){
                $(this).prev().focus();
            });

            $('#date-timepicker1').datetimepicker().next().on(ace.click_event, function(){
                $(this).prev().focus();
            });


        });
    </script>
@endsection