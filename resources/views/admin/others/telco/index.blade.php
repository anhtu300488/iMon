@extends('layouts.master')
@section('title')
    Danh sách nhà mạng
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
                            {!! Form::open(['method'=>'GET','url'=>'others/provider','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Mã </label>
                                    <div class="input-group" >
                                        <input class="form-control" name="code" type="text" value="{{request('code')}}"/>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Hướng dẫn </label>
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
                                    {{--@permission('administrator')--}}
                                    {{--<a class="btn btn-info btn-sm" href="{{ route('partner.create') }}"> Create New Provider</a>--}}
                                    {{--@endpermission--}}
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
                            <th>Mã</th>
                            <th>Hướng dẫn</th>
                            {{--<th>Tác vụ</th>--}}
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->code }}</td>
                                <td>{{ $rs->description }}</td>
                                {{--<td>--}}
                                    {{--@permission('administrator')--}}
                                    {{--<a class="btn btn-xs btn-info" href="{{ route('provider.edit',$rs->id) }}">--}}
                                        {{--<i class="ace-icon fa fa-pencil bigger-120"></i>--}}
                                    {{--</a>--}}
                                    {{--@endpermission--}}
                                    {{--@permission('administrator')--}}
                                    {{--{!! Form::open(['method' => 'DELETE','route' => ['provider.destroy', $rs->id],'style'=>'display:inline']) !!}--}}
                                    {{--<button class="btn btn-xs btn-danger" type="submit">--}}
                                        {{--<i class="ace-icon fa fa-trash-o bigger-120"></i>--}}
                                    {{--</button>--}}
                                    {{--{!! Form::close() !!}--}}

                                    {{--@endpermission--}}
                                {{--</td>--}}

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