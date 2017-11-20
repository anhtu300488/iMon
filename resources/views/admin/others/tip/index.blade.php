@extends('layouts.master')
@section('title')
    Danh sách Tip
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
                            {!! Form::open(['method'=>'GET','url'=>'others/tip','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Nội dung</label>
                                    <input class="form-control" name="content" type="text" value="{{request('content')}}"/>
                                </div>

                                @permission(['administrator','admin'])
                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Đối tác</label>
                                    {!! Form::select('partner', $partner, request('partner'), ['class' => 'form-control', 'id' => "partner"]) !!}

                                </div>
                                @endpermission
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
                                    <a class="btn btn-info btn-sm" href="{{ route('tip.create') }}"> Create New</a>
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
                            <th>Id</th>
                            <th>Nội dung</th>
                            <th>Đối tác</th>
                            <th>Trạng thái</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->tipId }}</td>
                                <td class="hidden-480">{{ $rs->content }}</td>
                                <td>{{ $rs->cp }}</td>
                                <td>@if($rs->active == 1)  <span class="label label-sm label-success">Active</span> @else <span class="label label-sm label-inverse arrowed-in">Deactive</span> @endif</td>
                                <td>
                                    @permission(['administrator','admin'])
                                    <a class="btn btn-xs btn-info" href="{{ route('tip.edit',$rs->tipId) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
                                    @endpermission
                                    @permission(['administrator','admin'])
                                    {!! Form::open(['method' => 'DELETE','route' => ['tip.destroy', $rs->tipId],'style'=>'display:inline']) !!}
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