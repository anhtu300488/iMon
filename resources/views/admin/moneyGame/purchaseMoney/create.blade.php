@extends('layouts.master')
@section('title')
    Tạo Purchase Money
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
            {!! Form::open(array('route' => 'purchaseMoney.store','method'=>'POST', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">User Id</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="userId" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Nhà cung cấp</label>
                <div class="col-sm-9">
                    {!! Form::select('provider', $provider, request('provider'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Giá trị thẻ nạp</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="cardValue" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">CardPin</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="cardPin" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">CardSerial</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="cardSerial" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">ToCash</label>
                <div class="col-sm-9">
                    {!! Form::select('toCash', $toCash, request('toCash'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
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