@extends('layouts.master')
@section('title')
    Log truy cập web tải game
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
                            {!! Form::open(['method'=>'GET','url'=>'others/messageUser','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-3 col-sm-3">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Id người gửi </label>
                                    <div class="input-group" >
                                        <input class="form-control" name="senderUserId" type="text" value="{{request('senderUserId')}}"/>
                                    </div>
                                </div>

                                <div class="col-xs-3 col-sm-3">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Tên người gửi </label>
                                    <div class="input-group" >
                                        <input class="form-control" name="senderUsername" type="text" value="{{request('senderUsername')}}"/>
                                    </div>
                                </div>

                                <div class="col-xs-3 col-sm-3">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Id người nhận </label>
                                    <div class="input-group" >
                                        <input class="form-control" name="recipientUserId" type="text" value="{{request('recipientUserId')}}"/>
                                    </div>
                                </div>

                                <div class="col-xs-3 col-sm-3">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Tên người nhận </label>
                                    <div class="input-group" >
                                        <input class="form-control" name="recipientUsername" type="text" value="{{request('recipientUsername')}}"/>
                                    </div>
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
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Id người gửi</th>
                            <th>Tên người gửi</th>
                            <th>Id người nhận</th>
                            <th>Tên người gửi</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Thời gian gửi</th>
                            <th>Trạng thái</th>
                            <th>Readed</th>
                            <th>Attach item</th>
                            <th>Attach item quatity</th>
                            <th>Expiredtime</th>
                            <th>Parentid</th>
                            <th>Secret box</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->senderUserId }}</td>
                                <td>{{ $rs->senderUserName }}</td>
                                <td>{{ $rs->recipientUserId }}</td>
                                <td>{{ $rs->recipientUserName }}</td>
                                <td>{{ $rs->title }}</td>
                                <td>{{ $rs->body }}</td>
                                <td>{{ $rs->sentTime }}</td>
                                <td>{{ $rs->status }}</td>
                                <td>{{ $rs->readed }}</td>
                                <td>{{ $rs->attachItemId }}</td>
                                <td>{{ $rs->attachItemQuatity }}</td>
                                <td>{{ $rs->expiredTime }}</td>
                                <td>{{ $rs->parentId }}</td>
                                <td>{{ $rs->secretBoxId }}</td>
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