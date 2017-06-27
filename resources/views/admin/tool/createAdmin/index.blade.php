@extends('layouts.master')
@section('title')
    Danh sách user
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
                            {!! Form::open(['method'=>'GET','url'=>'tool.createAdmin.index','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên đăng nhập</label>
                                    <input class="form-control" name="username" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Trạng thái</label>

                                    <select class="form-control" id="form-field-select-1" name="status">
                                        <option value="">---Tất cả---</option>
                                        <option value="0" <?php if(request('status') == 0) echo "selected='selected'"; ?> >Không hoạt động</option>
                                        <option value="1" <?php if(request('status') == 1) echo "selected='selected'"; ?> >Hoạt động</option>
                                    </select>
                                </div>

                            </div>

                            <hr />

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
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
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
        @endif
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        @permission('administrator')
                        <a class="btn btn-success" href="{{ route('createAdmin.create') }}"> Create New</a>
                        @endpermission
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ tên</th>
                            <th>Địa chỉ Email</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->username }}</td>
                                <td>{{ $rs->name }}</td>
                                <td>{{ $rs->email }}</td>
                                <td>{{ $rs->status }}</td>
                                <td>{{ $rs->created_at }}</td>
                                <td>
                                    @permission('administrator')
                                    <a class="btn btn-xs btn-info" href="{{ route('createAdmin.edit',$rs->id) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
                                    @endpermission
                                    @permission('administrator')
                                    {!! Form::open(['method' => 'DELETE','route' => ['createAdmin.destroy', $rs->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-xs btn-danger" type="submit">
                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                    </button>
                                    {!! Form::close() !!}

                                    @endpermission
                                </td>
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