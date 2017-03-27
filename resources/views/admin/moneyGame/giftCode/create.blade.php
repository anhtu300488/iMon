@extends('layouts.master')
@section('title')
    Tạo Gift Code
@endsection
@section('content')

    <!-- /section:settings.box -->
    <div class="page-header">
        <h1>
            Form Elements
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Common form elements and layouts
            </small>
        </h1>
    </div><!-- /.page-header -->

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
            {!! Form::open(array('route' => 'giftCode.store','method'=>'POST', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Gift Event</label>
                <div class="col-sm-9">
                    {!! Form::select('giftEventId', $giftEventId, request('giftEventId'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">UserName</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="userName" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">User Id</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="userId" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="id-date-picker-1">ExpiredTime</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input class="form-control date-picker col-sm-9" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="expiredTime" />
                        <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Mô tả</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="form-field-8" name="description"></textarea>
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

        });
    </script>
@endsection