@extends('layouts.master')
@section('title')
    Danh sách nạp thẻ lỗi
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
                            {!! Form::open(['method'=>'GET','url'=>'moneyGame/purchaseMoney','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> User Id </label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Nhà cung cấp</label>
                                    <input class="form-control" name="provider" type="text" value="{{request('provider')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Giá trị thẻ nạp</label>
                                    <input class="form-control" name="cardValue" type="text" value="{{request('cardValue')}}"/>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> CardPin</label>
                                    <input class="form-control" name="cardPin" type="text" value="{{request('cardPin')}}"/>
                                </div>
                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>

                                    @permission('administrator')
                                    <a class="btn btn-info btn-sm" href="{{ route('purchaseMoney.create') }}"> Create New Purchase Money</a>
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
                            <th>User</th>
                            <th>Nhà cung cấp</th>
                            <th>Card value</th>
                            <th>Card pin</th>
                            <th>Active view</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->userId }}</td>
                                <td>{{ $rs->provider }}</td>
                                <td>{{ $rs->cardValue }}</td>
                                <td>{{ $rs->cardPin }}</td>
                                <td>{{ $rs->active }}</td>
                                <td>
                                    @permission('administrator')
                                    <a class="btn btn-xs btn-info" href="{{ route('purchaseMoney.edit',$rs->missId) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
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