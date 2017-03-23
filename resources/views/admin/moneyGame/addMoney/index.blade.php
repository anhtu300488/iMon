@extends('layouts.master')
@section('title')
    Danh sách cộng tiền cho user
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
                            {!! Form::open(['method'=>'GET','url'=>'moneyGame/addMoney','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> User Id </label>
                                    <div class="input-group" >
                                        <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Mô tả</label>
                                    <div class="input-group" >
                                        <input class="form-control" name="description" type="text" value="{{request('description')}}"/>
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
                            <th>User</th>
                            <th>Cộng Ken</th>
                            <th>Cộng Xu</th>
                            <th>Mô tả</th>
                            <th>Tên admin</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th>Thời gian cập nhật</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->userId }}</td>
                                <td>{{ $rs->addGold }}</td>
                                <td>{{ $rs->addCash }}</td>
                                <td>{{ $rs->description }}</td>
                                <td>{{ $rs->admin_id }}</td>
                                <td>{{ $rs->status }}</td>
                                <td>{{ $rs->admin_id }}</td>
                                <td>{{ $rs->created_at }}</td>
                                <td>{{ $rs->updated_at }}</td>
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