@extends('layouts.master')
@section('title')
    Tạo phòng game
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
            {!! Form::open(array('route' => 'room.store','method'=>'POST', 'class' => 'form-horizontal')) !!}
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Game ID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="gameId" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Room Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="roomName" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">VipRoom</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="vipRoom" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MinCash</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="minCash" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MinGold</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="minGold" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MinLevel</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="minLevel" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">RoomCapacity</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="roomCapacity" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">PlayerSize</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="playerSize" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MinBet</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="minBet" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Tax</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="tax" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">MaxRoomplay</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="maxRoomplay" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">PermanentRoomPlay</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="permanentRoomPlay" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">KickLimit</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="kickLimit" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="id-date-picker-1">StartTime</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input class="form-control date-picker col-sm-9" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="startTime" />
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
                        <input class="form-control date-picker col-sm-9" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="endTime" />
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