@extends('layouts.master')
@section('title')
    Tạo mới Tip
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
            {!! Form::open(array('route' => 'tip.store','method'=>'POST', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Nội dung</label>
                <div class="col-sm-9">
                    {!! Form::textarea('content', null, array('placeholder' => 'Nội dung Tip','class' => 'form-control')) !!}
                </div>
            </div>

                <div class="form-group">
                    @permission(['administrator','admin'])
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Đối tác</label>
                    <div class="col-sm-9">
                        {!! Form::select('partner', $partner, request('partner'), ['class' => 'form-control', 'id' => "partner"]) !!}

                    </div>
                    @endpermission
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
    <!-- inline scripts related to this page -->
@endsection