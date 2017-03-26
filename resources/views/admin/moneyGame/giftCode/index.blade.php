@extends('layouts.master')
@section('title')
    Thông tin GiftCode
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
                            {!! Form::open(['method'=>'GET','url'=>'moneyGame/giftCode','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Người dùng: </label>
                                    <div class="input-group col-sm-8" >
                                        <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>

                                    @permission('administrator')
                                    <a class="btn btn-info btn-sm" href="{{ route('giftCode.create') }}"> Create New GiftCode</a>
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
                            <th>STT</th>
                            <th>Tên người chơi</th>
                            <th>Gift event</th>
                            <th>Code</th>
                            <th>Ken</th>
                            <th>Xu</th>
                            <th>Ip</th>
                            <th>Reuseable</th>
                            <th>Trạng thái</th>
                            <th>Người tạo giftcode</th>
                            <th>Mô tả</th>
                            <th>Thời gian tạo</th>
                            <th>Thời gian cập nhật</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->userName }}</td>
                                <td>{{ $rs->giftEventId }}</td>
                                <td>{{ $rs->code }}</td>
                                <td>{{ $rs->cashValue }}</td>
                                <td>{{ $rs->goldValue }}</td>
                                <td>{{ $rs->ip }}</td>
                                <td>{{ $rs->reuseable }}</td>
                                <td>{{ $rs->status }}</td>
                                <td>{{ $rs->adminId }}</td>
                                <td>{{ $rs->description }}</td>
                                <td>{{ $rs->created_at }}</td>
                                <td>{{ $rs->updated_at }}</td>
                                <td>
                                    @permission('administrator')
                                    <a class="btn btn-xs btn-info" href="{{ route('giftCode.edit',$rs->giftId) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
                                    @endpermission
                                    @permission('administrator')
                                    {!! Form::open(['method' => 'DELETE','route' => ['giftCode.destroy', $rs->giftId],'style'=>'display:inline']) !!}
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