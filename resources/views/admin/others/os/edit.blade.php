@extends('layouts.master')

@section('title')
    Sửa hệ điều hành
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
    {!! Form::model($clientType, ['method' => 'PATCH', 'class' => 'form-horizontal','route' => ['clientType.update', $clientType->clientId]]) !!}
    <div class="row">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Code</label>
            <div class="col-sm-9">
                {!! Form::text('code', null, ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Name</label>
            <div class="col-sm-9">
                {!! Form::text('name', null, array('placeholder' => 'Game ID','class' => 'form-control')) !!}
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