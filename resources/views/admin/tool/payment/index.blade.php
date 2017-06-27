@extends('layouts.master')
@section('title')
    Danh sách cp
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
                            {!! Form::open(['method'=>'GET','url'=>'tool/createAdmin','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên đối tác</label>
                                    <input class="form-control" name="cpName" type="text" />
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
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên đối tác</th>
                            <th>Kênh nạp</th>
                            <th>Kênh đổi</th>
                            <th width="280px">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->cpName }}</td>
                                <td>{{ $rs->chargingUri }}</td>
                                <td>{{ $rs->topupUri }}</td>
                                <td>
                                    @permission('administrator')
                                    <a class="btn btn-xs btn-info" href="{{ route('tool.payment.edit',$rs->cpId) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
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