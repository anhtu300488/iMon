@extends('layouts.master')
@section('title')
    Danh sách notification
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
                            {!! Form::open(['method'=>'GET','url'=>'others/notification','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Tiêu đề </label>
                                    <input class="form-control" name="title" type="text" value="{{request('title')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Nội dung </label>
                                    <input class="form-control" name="message" type="text" value="{{request('message')}}"/>
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
                                <div class="col-xs-6 col-sm-6">
                                    @permission('administrator')
                                    <a class="btn btn-info btn-sm" href="{{ route('notification.create') }}"> Create New Notification</a>
                                    @endpermission
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
                            <th>Tiêu đề</th>
                            <th>Nội dung push</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Push time</th>
                            <th>Lặp lại hàng ngày</th>
                            <th>Trạng thái</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->title }}</td>
                                <td>{{ $rs->message }}</td>
                                <td class="hidden-480">{{ $rs->pushTime }}</td>
                                <td>@if($rs->repeat_daily == 1)  <span class="label label-sm label-success">Yes</span> @else <span class="label label-sm label-inverse arrowed-in">No</span> @endif</td>
                                <td>@if($rs->status == 1)  <span class="label label-sm label-success">Active</span> @else <span class="label label-sm label-inverse arrowed-in">Deactive</span> @endif</td>
                                <td>
                                    @permission('administrator')
                                    <a class="btn btn-xs btn-info" href="{{ route('notification.edit',$rs->notificationId) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
                                    @endpermission
                                    @permission('administrator')
                                    {!! Form::open(['method' => 'DELETE','route' => ['notification.destroy', $rs->notificationId],'style'=>'display:inline']) !!}
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
                {{ $data->appends($_GET)->links() }}
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection