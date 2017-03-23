@extends('layouts.master')
@section('title')
    Thông tin GiftEvent
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
                            {!! Form::open(['method'=>'GET','url'=>'moneyGame/eventGift','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Tên event: </label>
                                    <div class="input-group col-sm-8" >
                                        <input class="form-control" name="eventName" type="text" value="{{request('eventName')}}"/>
                                    </div>
                                </div>

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
                            <th>Gift event</th>
                            <th>Event name</th>
                            <th>Cash value</th>
                            <th>Gold value</th>
                            <th>Expired time</th>
                            <th>Reuseable</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th>Thời gian cập nhật</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->giftEventId }}</td>
                                <td>{{ $rs->eventName }}</td>
                                <td>{{ $rs->cashValue }}</td>
                                <td>{{ $rs->goldValue }}</td>
                                <td>{{ $rs->expiredTime }}</td>
                                <td>{{ $rs->reuseable }}</td>
                                <td>{{ $rs->description }}</td>
                                <td>{{ $rs->status }}</td>
                                <td>{{ $rs->created_at }}</td>
                                <td>{{ $rs->updated_at }}</td>
                                <td></td>
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