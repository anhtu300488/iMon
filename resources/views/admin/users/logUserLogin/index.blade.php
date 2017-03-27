@extends('layouts.master')
@section('title')
    Quản lý log user đăng nhập
@endsection
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Tìm kiếm</h4>

                        <span class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </span>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            {!! Form::open(['method'=>'GET','url'=>'users/logUserLogin','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">User ID</label>
                                    <input class="form-control" name="userID" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">IME</label>
                                    <input class="form-control" name="ime" type="text" />
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Địa chỉ IP</label>
                                    <input class="form-control" name="ip" type="text" />
                                </div>

                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>User ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Logged in time</th>
                            <th>IME</th>
                            <th>Thông tin thiết bị</th>
                            <th>Địa chỉ Ip</th>
                            <th>Client type</th>
                            <th>Package name</th>
                            <th>Version code</th>
                            <th>Version build</th>
                            {{--<th>Ip locked</th>--}}
                            {{--<th>Relogged in</th>--}}
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->userId }}</td>
                                <td>{{ $rs->userName }}</td>
                                <td>{{ $rs->loggedInTime }}</td>
                                <td class="hidden-480">{{ $rs->deviceId }}</td>
                                <td>{{ $rs->deviceInfo }}</td>
                                <td>{{ $rs->remoteIp }}</td>
                                <td>{{ $rs->clientType }}</td>
                                <td>{{ $rs->packageName }}</td>
                                <td>{{ $rs->versionCode }}</td>
                                <td>{{ $rs->versionBuild }}</td>
                                {{--<td>{{ $rs->ipLocked }}</td>--}}
                                {{--<td>{{ $rs->reloggedIn }}</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.span -->
                {{ $data->appends($_GET)->links() }}
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection