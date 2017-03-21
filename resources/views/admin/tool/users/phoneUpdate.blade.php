@extends('layouts.master')
@section('title')
    Cập nhật số điện thoại
@endsection
@section('content')

    <!-- /section:settings.box -->
    <div class="page-header">
        <h1>Wysiwyg &amp; Markdown Editor </h1>
    </div><!-- /.page-header -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
        {!! Form::open(array('route' => 'tool.phoneUpdate.store','method'=>'POST', 'class' => 'form-horizontal')) !!}

        <!-- PAGE CONTENT BEGINS -->
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên tài khoản </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" placeholder="vd: binhnv, hungdv, " name="userName" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Số điện thoại </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" name="mobile" class="col-xs-10 col-sm-5" />
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