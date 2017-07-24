@extends('layouts.master')
@section('title')
    Tạo nhiều Gift Code
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
            {!! Form::open(array('route' => 'giftCode.multiStore','method'=>'POST', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Gift Event</label>
                <div class="col-sm-9">
                    {!! Form::select('giftEventId', $giftEventId, request('giftEventId'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Số lượng code</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="quantity" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Số mon</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="cashValue" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Số lượt quay VQMM</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="vqmmTurn" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Số thẻ khuyến mại</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="cardPromotion" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">% giá trị thẻ</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="cardPromotionTurn" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Có sử dụng chữ cái trong code</label>
                <div class="col-sm-9">
                    {!! Form::hidden('includeAlphabet',0) !!}
                    {{ Form::checkbox('includeAlphabet', 1, true, ['class' => 'field']) }}
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