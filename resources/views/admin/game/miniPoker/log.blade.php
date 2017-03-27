@extends('layouts.master')
@section('title')
    Lịch sử quay MiniPoker
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
                            {!! Form::open(['method'=>'GET','url'=>'game/logMiniPoker','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">User ID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Vòng ngoài</label>

                                    {!! Form::select('item', $item, request('item'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Description</label>
                                    <input class="form-control" name="description" type="text" value="{{request('description')}}"/>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Từ ngày</label>
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="fromDate" value="{{request('fromDate')}}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Đến ngày</label>
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="toDate" value="{{request('toDate')}}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
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
                            <th>Vòng ngoài</th>
                            <th>Vòng trong</th>
                            <th>Desciption</th>
                            <th>Time</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->userId }}</td>
                                <td>{{ $rs->round1_item }}</td>
                                <td>{{ $rs->round2_item }}</td>
                                <td>{{ $rs->desciption }}</td>
                                <td>{{ $rs->time }}</td>
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