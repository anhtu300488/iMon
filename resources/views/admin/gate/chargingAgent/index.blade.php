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
                            {!! Form::open(['method'=>'GET','url'=>'gate/chargingAgent','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên</label>
                                    <input class="form-control" name="name" type="text" value="{{request('name')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Nhà cung cấp</label>
                                    {!! Form::select('provider', $providerArr, request('provider'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

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
                            <th class="hidden-480">agentId</th>
                            <th>Tên máy</th>
                            <th>Lần kết nối cuối</th>
                            <th>Lần được gọi cuối </th>
                            <th class="hidden-480">Số lần nạp sai</th>
                            <th class="hidden-480">Nhà cung cấp</th>
                            <th>Số dư tài khoản </th>
                            <th>Dùng gateway </th>
                            <th>Tình trạng hoạt động</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->agentId }}</td>
                                <th>{{ $rs->name }}</th>
                                <th>{{ $rs->lastRegistrationTime }}</th>
                                <th>{{ $rs->lastUsedTime }}</th>
                                <td class="hidden-480">{{ $rs->chargingFaillure }}</td>
                                <td class="hidden-480">{{ $rs->providerCode }}</td>
                                <td>{{ number_format($rs->accountBalance) }}</td>
                                <td>@if($rs->useChargingGateway == 1)  <span class="label label-sm label-success">V</span>
                                    {{--@elseif($rs->status == 3) <span class="label label-sm label-inverse arrowed-in">X</span>--}}
                                    @else <span class="label label-sm label-inverse arrowed-in">X</span> @endif
                                </td>
                                <td>{{ $rs->active }}</td>
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