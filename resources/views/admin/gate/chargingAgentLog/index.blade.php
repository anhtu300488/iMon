@extends('layouts.master')
@section('title')
    Quản lý Charging Agent
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
                            {!! Form::open(['method'=>'GET','url'=>'gate/chargingAgentLog','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên</label>
                                    <input class="form-control" name="name" type="text" value="{{request('name')}}"/>
                                </div>

                                {{--<div class="col-xs-4 col-sm-4">--}}
                                    {{--<!-- #section:plugins/date-time.datepicker -->--}}
                                    {{--<label for="id-date-picker-1">Nhà cung cấp</label>--}}
                                    {{--{!! Form::select('provider', $providerArr, request('provider'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}--}}
                                {{--</div>--}}

                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Search
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
                            <th>Tên máy</th>
                            <th>Thời gian</th>
                            <th>Mã pin</th>
                            <th>Mã lỗi/th>
                            <th class="hidden-480">Mô tả </th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ $rs->agent_name }}</td>
                                <th>{{ $rs->createdTime }}</th>
                                <th>{{ $rs->cardPin }}</th>
                                <th>{{ $rs->errorCode }}</th>
                                <td class="hidden-480">{{ $rs->description }}</td>
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