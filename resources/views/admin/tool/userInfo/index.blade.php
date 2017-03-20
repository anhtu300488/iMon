@extends('layouts.master')
@section('title')
    Top Game
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
                            {!! Form::open(['method'=>'GET','url'=>'tool/userInfo','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <label class="col-sm-3" for="form-field-select-1">Người chơi</label>
                                    <input class="form-control col-sm-9" name="username" type="text" />
                                </div>

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
                            <th>Tên đăng nhập</th>
                            <th>Tên người chơi</th>
                            <th>Tổng Mon</th>
                            <th>Tổng xu</th>
                            <th>Tổng tiền nạp</th>
                            <th>Số trận thua</th>
                            <th>Số trận thắng</th>
                            <th>Cấp level</th>
                            <th>Cấp Vip</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                        </tr>
                        </thead>

                        <tbody>
                        {{--@foreach($data as $key => $rs)--}}
                        {{--<tr>--}}
                        {{--<td>{{ ++$i }}</td>--}}
                        {{--<td>{{ $rs->created_date }}</td>--}}
                        {{--<td></td>--}}
                        {{--<td class="hidden-480">{{ $rs->type }}</td>--}}
                        {{--<td>{{ $rs->sum_money }}</td>--}}
                        {{--<td>{{ $rs->sum_cash }}</td>--}}
                        {{--</tr>--}}
                        {{--@endforeach--}}
                        <tr>
                            <td>1</td>
                            <td>tu_atula</td>
                            <td>Bui Anh Tu</td>
                            <td>1,000,000</td>
                            <td>1,000,000</td>
                            <td>1,000,000</td>
                            <td>0</td>
                            <td>100</td>
                            <td>100</td>
                            <td>10</td>
                            <td>0967905505</td>
                            <td>buianhtu3004@gmail.com</td>
                            <td>1</td>
                            <td>2017-03-20</td>
                        </tr>
                        </tbody>
                    </table>
                </div><!-- /.span -->
                {{--{{ $data->appends($_GET)->links() }}--}}
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection