@extends('layouts.master')

@section('title')
    Sửa hệ điều hành
@endsection

@section('content')
    <div class="page-header">
        <h1>
            Cập nhật kênh thanh toán
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
    {!! Form::model($cp, ['method' => 'PATCH', 'class' => 'form-horizontal','route' => ['cp.update', $cp->cpId]]) !!}
    <div class="row">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Tên đối tác</label>
            <div class="col-sm-9">
                {!! Form::text('cpName', null, ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">gạch thẻ</label>
            <div class="col-sm-9">
            {!! Form::select('chargingUri', $list_charge, request('chargingUri'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Đổi thẻ</label>
            <div class="col-sm-9">
                {!! Form::select('topupUri', $list_topup, request('topupUri'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
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