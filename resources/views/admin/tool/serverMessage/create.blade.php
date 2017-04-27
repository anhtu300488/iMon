@extends('layouts.master')
@section('title')
    Thông báo toàn server
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
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
            <!-- PAGE CONTENT BEGINS -->
            {!! Form::open(array('route' => 'tool.serverMessage.store','method'=>'POST', 'class' => 'form-horizontal')) !!}

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Nội dung</label>
                    <div class="col-sm-9">
                        {!! Form::textarea('body') !!}
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

@endsection