@extends('layouts.master')
@section('title')
    Tai xiu prophecy
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
        {{--<form class="form-horizontal" role="form">--}}
        {!! Form::open(array('route' => 'system.taixiu.store','method'=>'POST', 'class' => 'form-horizontal')) !!}
        <!-- #section:elements.form -->
            {{ csrf_field() }}
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="form-group{{ $errors->has('isGreat') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Chọn kết quả phiên</label>

                <div class="col-md-6">
                    {!! Form::radio('isGreat', 1 , true, ['style' => 'margin: 12px']) !!} Tài
                    {!! Form::radio('isGreat', 0 , false, ['style' => 'margin: 12px']) !!} Xỉu

                    @if ($errors->has('isGreat'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('isGreat') }}</strong>
                                </span>
                    @endif
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
            {{--</form>--}}

        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection