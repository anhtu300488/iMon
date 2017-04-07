@extends('layouts.app')

@section('content')
@if (Route::has('login'))
    @if (Auth::check())
        <script type="text/javascript">
            window.location = "/home";//here double curly bracket
        </script>
    @else

    <div class="position-relative">
        <div id="login-box" class="login-box visible widget-box no-border">
            <div class="widget-body">
                <div class="widget-main">
                    <h4 class="header blue lighter bigger">
                        <i class="ace-icon fa fa-coffee green"></i>
                        Login
                    </h4>

                    <div class="space-6"></div>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label class="block clearfix">
                                    <span class="block input-icon input-icon-right">
                                        <input id="username" type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required autofocus/>
                                        <i class="ace-icon fa fa-user"></i>
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </span>
                                </label>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="block clearfix" for="password">
                                    <span class="block input-icon input-icon-right">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required/>
                                        <i class="ace-icon fa fa-lock"></i>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </span>
                                </label>
                            </div>

                            <div class="space"></div>

                            <div class="clearfix">
                                <label class="inline">
                                    <input type="checkbox" class="ace" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <span class="lbl"> Remember Me</span>
                                </label>

                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                    <i class="ace-icon fa fa-key"></i>
                                    <span class="bigger-110">Login</span>
                                </button>
                            </div>

                            <div class="space-4"></div>
                        </fieldset>
                    </form>

                </div><!-- /.widget-main -->

                <div class="toolbar clearfix">
                    <div>
                        <a href="{{ route('password.request') }}" data-target="#forgot-box" class="forgot-password-link">
                            <i class="ace-icon fa fa-arrow-left"></i>
                            I forgot my password
                        </a>
                    </div>

                    {{--<div>--}}
                        {{--<a href="#" data-target="#signup-box" class="user-signup-link">--}}
                            {{--I want to register--}}
                            {{--<i class="ace-icon fa fa-arrow-right"></i>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                </div>
            </div><!-- /.widget-body -->
        </div><!-- /.login-box -->

    </div><!-- /.position-relative -->

        @endif
    @endif
@endsection
