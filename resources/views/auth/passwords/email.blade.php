@extends('layouts.app')

@section('content')
    <div id="forgot-box" class="forgot-box widget-box no-border visible">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header red lighter bigger">
                    <i class="ace-icon fa fa-key"></i>
                    Retrieve Password
                </h4>

                <div class="space-6"></div>
                <p>
                    Enter your email and to receive instructions
                </p>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <fieldset>
                        <label class="block clearfix {{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="block input-icon input-icon-right">
                                <input id="email" name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required/>
                                <i class="ace-icon fa fa-envelope"></i>
                            </span>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </label>

                        <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                <i class="ace-icon fa fa-lightbulb-o"></i>
                                <span class="bigger-110">Send Me!</span>
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div><!-- /.widget-main -->

            <div class="toolbar center">
                <a href="{{ route('login') }}" class="back-to-login-link">
                    Back to login
                    <i class="ace-icon fa fa-arrow-right"></i>
                </a>
            </div>
        </div><!-- /.widget-body -->
    </div>
@endsection
