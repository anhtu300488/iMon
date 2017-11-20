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
                                    <label class="control-label no-padding-right" for="form-field-1"> UserID: </label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> UserName: </label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Code: </label>
                                    <input class="form-control" name="code" type="text" value="{{request('code')}}"/>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Sự kiện</label>
                                    {!! Form::select('event', $giftEvent, request('event'), ['class' => 'form-control', 'id' => "event"]) !!}

                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Mệnh giá code: </label>
                                    <input class="form-control" name="cashValue" type="text" value="{{request('cashValue')}}"/>
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

                                    @permission(['administrator','admin'])
                                    <a class="btn btn-info btn-sm" href="{{ route('giftCode.create') }}"> Create New</a> | <a class="btn btn-info btn-sm" href="{{ route('giftCode.multi') }}"> Tạo nhiều gift code</a>
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
                            <th class="hidden-480">STT</th>
                            <th>UserID</th>
                            <th>UserName</th>
                            <th class="hidden-480">Gift event</th>
                            <th>Code</th>
                            <th>Mon</th>
                            <th>Số lượt VQMM</th>
                            <th>Số thẻ</th>
                            <th>% mỗi thẻ</th>
                            <th class="hidden-480">Ip</th>
                            <th>Trạng thái</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian nhận</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian hết hạn</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->userId }}</td>
                                <td>{{ $rs->userName }}</td>
                                <td class="hidden-480">{{ $giftEvent[$rs->giftEventId] }}</td>
                                <td>{{ $rs->code }}</td>
                                <td>{{ number_format($rs->cashValue) }}</td>
                                <td>{{ $rs->vqmmTurn }}</td>
                                <td>{{ $rs->cardPromotionTurn }}</td>
                                <td>{{ $rs->cardPromotion }}</td>
                                <td class="hidden-480">{{ $rs->ip }}</td>
                                <td>@if($rs->status == 0)  <span class="label label-sm label-inverse arrowed-in">Đã sử dụng</span> @else <span class="label label-sm label-success">Mới</span> @endif</td>
                                <td class="hidden-480">{{ $rs->redeemedTime }}</td>
                                <td class="hidden-480">{{ $rs->expiredTime }}</td>
                                <td>
                                    @permission(['administrator','admin'])
                                    <a class="btn btn-xs btn-info" href="{{ route('giftCode.edit',$rs->giftId) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
                                    @endpermission
                                    @permission(['administrator','admin'])
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
                @include('layouts.partials._pagination')
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection