@extends('layouts.master')
@section('title')
    Quản trị mail
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
                            {!! Form::open(['method'=>'GET','url'=>'others/mail','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> User ID </label>
                                    <input class="form-control" name="senderUserId" type="text" value="{{request('senderUserId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Username </label>
                                    <input class="form-control" name="senderUserName" type="text" value="{{request('senderUserName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Tiêu đề </label>
                                    <input class="form-control" name="title" type="text" value="{{request('title')}}"/>
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Nội dung </label>
                                    <input class="form-control" name="body" type="text" value="{{request('body')}}"/>
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
                            <th class="hidden-480">STT</th>
                            <th class="hidden-480">ID Người gửi</th>
                            <th class="hidden-480">Tên người gửi</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td class="hidden-480">{{ $rs->senderUserId }}</td>
                                <td class="hidden-480">{{ $rs->senderUserName }}</td>
                                <td>{{ $rs->title }}</td>
                                <td>{{ $rs->body }}</td>
                                <td class="hidden-480">{{ $rs->sentTime }}</td>
                                <td>
                                    {!! Form::open(['method' => 'GET','route' => ['mail.show', $rs->messageId],'style'=>'display:inline']) !!}
                                    <button class="btn btn-xs btn-info" type="submit" title="Chi tiết">
                                        <i class="ace-icon fa fa-reply white"></i>
                                    </button>
                                    {!! Form::close() !!}
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