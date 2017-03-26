@extends('layouts.master')

@section('title')
    Sửa bù tiền cho user
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
    {!! Form::model($purchaseMoneyMissing, ['method' => 'PATCH', 'class' => 'form-horizontal','route' => ['purchaseMoney.update', $purchaseMoneyMissing->missId]]) !!}
    <div class="row">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">User ID</label>
            <div class="col-sm-9">
                {!! Form::text('userId', null, array('placeholder' => 'User ID','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Nhà cung cấp</label>
            <div class="col-sm-9">
                {!! Form::select('provider', $provider, null, ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Card Value</label>
            <div class="col-sm-9">
                {!! Form::text('cardValue', null, array('placeholder' => 'cardValue','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">CardPin</label>
            <div class="col-sm-9">
                {!! Form::text('cardPin', null, array('placeholder' => 'cardPin','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">CardSerial</label>
            <div class="col-sm-9">
                {!! Form::text('cardSerial', null, array('placeholder' => 'CardSerial','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">ToCash</label>
            <div class="col-sm-9">
                {!! Form::select('toCash', $toCash, null, ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
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