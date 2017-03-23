@extends('layouts.master')

@section('title')
    Sửa phòng game
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
    {!! Form::model($room, ['method' => 'PATCH', 'class' => 'form-horizontal','route' => ['room.update', $room->roomId]]) !!}
    <div class="row">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Game ID</label>
            <div class="col-sm-9">
                {!! Form::text('gameId', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Room Name</label>
            <div class="col-sm-9">
                {!! Form::text('roomName', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">VipRoom</label>
            <div class="col-sm-9">
                {!! Form::text('vipRoom', null, array('placeholder' => 'VipRoom','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MinCash</label>
            <div class="col-sm-9">
                {!! Form::text('minCash', null, array('placeholder' => 'MinCash','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MinGold</label>
            <div class="col-sm-9">
                {!! Form::text('minGold', null, array('placeholder' => 'MinGold','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MinLevel</label>
            <div class="col-sm-9">
                {!! Form::text('minLevel', null, array('placeholder' => 'MinLevel','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">RoomCapacity</label>
            <div class="col-sm-9">
                {!! Form::text('roomCapacity', null, array('placeholder' => 'RoomCapacity','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">PlayerSize</label>
            <div class="col-sm-9">
                {!! Form::text('playerSize', null, array('placeholder' => 'PlayerSize','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MinBet</label>
            <div class="col-sm-9">
                {!! Form::text('minBet', null, array('placeholder' => 'MinBet','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Tax</label>
            <div class="col-sm-9">
                {!! Form::text('tax', null, array('placeholder' => 'Tax','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MaxRoomplay</label>
            <div class="col-sm-9">
                {!! Form::text('maxRoomplay', null, array('placeholder' => '0','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">PermanentRoomPlay</label>
            <div class="col-sm-9">
                {!! Form::text('permanentRoomPlay', null, array('placeholder' => 'PermanentRoomPlay','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">KickLimit</label>
            <div class="col-sm-9">
                {!! Form::text('kickLimit', null, array('placeholder' => 'KickLimit','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="id-date-picker-1">StartTime</label>
            <div class="col-sm-9">
                <div class="input-group">
                    {!! Form::text('endTime', null, array('placeholder' => 'startTime','class' => 'form-control date-picker col-sm-9', 'id' => 'id-date-picker-1', 'data-date-format' => 'dd-mm-yyyy')) !!}
                    <span class="input-group-addon">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="id-date-picker-1">EndTime</label>
            <div class="col-sm-9">
                <div class="input-group">
                    {!! Form::text('endTime', null, array('placeholder' => 'endTime','class' => 'form-control date-picker col-sm-9', 'id' => 'id-date-picker-1', 'data-date-format' => 'dd-mm-yyyy')) !!}
                    <span class="input-group-addon">
                            <i class="fa fa-calendar bigger-110"></i>
                        </span>
                </div>
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