@extends('layouts.master')
@section('title')
    Quản lý OTP
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
                            {!! Form::open(['method'=>'GET','url'=>'users/otp','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">SDT xác thực</label>
                                    <input class="form-control" name="phone" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userID" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Verify Code</label>
                                    <input class="form-control" name="verifyCode" type="text" />
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Trạng thái</label>
                                    {!! Form::select('status', $statusArr, request('status'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Loại</label>
                                    {!! Form::select('type', $typeArr, request('type'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
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
                            <th class="hidden-480">STT</th>
                            <th>Số điện thoại</th>
                            <th>Tên đăng nhập</th>
                            <th>Trạng thái</th>
                            <th class="hidden-480">Type view</th>
                            <th>Verify code</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian tạo</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian cập nhật</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->verifiedPhone }}</td>
                                <td>{{ $rs->userName }}</td>
                                <td>@if($rs->status == 1)  <span class="label label-sm label-inverse arrowed-in">Đã sử dụng</span> @else <span class="label label-sm label-success">Chưa sử dụng</span> @endif</td>
                                <td class="hidden-480">{{ $typeArr[$rs->type] }}</td>
                                <td>{{ $rs->verify_code }}</td>
                                <td class="hidden-480">{{ $rs->created_at }}</td>
                                <td class="hidden-480">{{ $rs->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.span -->
                @include('layouts.partials._pagination')
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection