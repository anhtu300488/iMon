@extends('layouts.master')
@section('title')
    Sửa user
@endsection
@section('content')

    <div class="page-header">
        <h1>
            Sửa user
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

        <!-- PAGE CONTENT BEGINS -->
    {!! Form::model($admin, ['method' => 'PATCH', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data','route' => ['createAdmin.update', $admin->id]]) !!}

    <div class="row">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                {!! Form::text('name', null, array('placeholder' => 'name','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

            <div class="col-md-6">
                {!! Form::text('email', null, array('placeholder' => 'email','class' => 'form-control')) !!}
                {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>--}}
                {{--@if ($errors->has('email'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('email') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
            </div>
        </div>

        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="username" class="col-md-4 control-label">Username</label>

            <div class="col-md-6">
                {!! Form::text('username', null, array('placeholder' => 'username','class' => 'form-control','readonly')) !!}
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
                {!! Form::password('password', null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-md-4 control-label">Permission</label>
            <div class="col-md-6">
                {!! Form::select('roles[]', $roles ,[], array('class' => 'form-control','multiple')) !!}
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-md-4 control-label">CP</label>
            <div class="col-md-6">
                {!! Form::select('cp', $cp ,null, array('class' => 'form-control')) !!}
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
    </div>

    {!! Form::close() !!}

@endsection