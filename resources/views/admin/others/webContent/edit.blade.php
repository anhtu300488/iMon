@extends('layouts.master')

@section('title')
    Sửa nội dung website
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
    {!! Form::model($webContent, ['method' => 'PATCH', 'class' => 'form-horizontal','route' => ['webContent.update', $webContent->id]]) !!}
    <div class="row">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Tiêu đề</label>
            <div class="col-sm-9">
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Keywords</label>
            <div class="col-sm-9">
                {!! Form::text('keywords', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Mô tả</label>
            <div class="col-sm-9">
                {!! Form::text('description', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Nội dung</label>
            <div class="col-sm-9">
                {!! Form::textarea('content', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Ảnh</label>
            <div class="col-sm-9">
                {!! Form::text('image', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Loại</label>
            <div class="col-sm-9">
                {!! Form::text('type', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Trạng thái</label>
            <div class="col-sm-9">
                {!! Form::hidden('status',0) !!}
                {{ Form::checkbox('status', 1, null, ['class' => 'field']) }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Is hot</label>
            <div class="col-sm-9">
                {!! Form::hidden('is_hot',0) !!}
                {{ Form::checkbox('is_hot', 1, null, ['class' => 'field']) }}
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

@endsection