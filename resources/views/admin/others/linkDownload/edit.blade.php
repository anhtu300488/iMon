@extends('layouts.master')

@section('title')
    Sửa link download
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
    {!! Form::model($linkDownload, ['method' => 'PATCH', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data','route' => ['linkDownload.update', $linkDownload->id]]) !!}
    <div class="row">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">OS</label>
            <div class="col-sm-9">
                {!! Form::select('os', $osBuild, null, ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Link tải</label>
            <div class="col-sm-9">
                {!! Form::text('link_tai', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">File Download</label>
            <div class="col-sm-9">
                {{--<img src="{{Storage::url('x6QQm5SEJhJ95yfHZBDonEEFTPVNdvmkRGnMI8XV.jpeg')}}" />--}}
                {!! Form::file('file_down', null) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Is Direct</label>
            <div class="col-sm-9">
                {!! Form::select('is_direct', $downloadType, null, ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
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
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Delay</label>
            <div class="col-sm-9">
                {!! Form::text('delay', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
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