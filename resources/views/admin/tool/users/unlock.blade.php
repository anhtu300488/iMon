@extends('layouts.master')
@section('title')
    Mở khóa tài khoản
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
        {!! Form::open(array('route' => 'tool.unlockUser.store','method'=>'POST', 'class' => 'form-horizontal')) !!}

        <!-- PAGE CONTENT BEGINS -->
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên tài khoản </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" placeholder="vd: binhnv, hungdv, " name="userName" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <!-- /section:elements.form -->
            <div class="space-4"></div>

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
            <!-- PAGE CONTENT ENDS -->
            {!! Form::close() !!}

        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection