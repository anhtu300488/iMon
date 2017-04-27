@extends('layouts.master')

@section('title')
    Change Password
@endsection

@section('content')
    <div class="page-header">
        <h1>
            Change Password
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
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($err = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $err }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
        {!! Form::open(array('route' => 'password.postCredentials','method'=>'POST', 'class' => 'form-horizontal')) !!}
        <!-- #section:elements.form -->
            {{ csrf_field() }}

            <div class="form-group">
                <label for="username" class="col-md-4 control-label">UserName</label>

                <div class="col-md-6">
                    <input id="username" type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" readonly>
                </div>
            </div>

            <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                <label for="current_password" class="col-md-4 control-label">Current Password</label>

                <div class="col-md-6">
                    <input id="current_password" type="password" class="form-control" name="current_password" value="{{ old('current_password') }}" required>

                    @if ($errors->has('current_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('current_password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                <label for="new_password" class="col-md-4 control-label">New Password</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                <label for="confirm_password" class="col-md-4 control-label">Confirm Password</label>

                <div class="col-md-6">
                    <input id="confirm_password" type="password" class="form-control" name="confirm_password" required>

                    @if ($errors->has('confirm_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('confirm_password') }}</strong>
                        </span>
                    @endif
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
            {{--</form>--}}

        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection