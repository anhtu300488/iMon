@extends('layouts.master')
@section('title')
    Link tải game
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
                            {!! Form::open(['method'=>'GET','url'=>'others/linkDownload','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Os </label>
                                    {!! Form::select('os', $osArr, request('os'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label class="control-label no-padding-right" for="form-field-1"> Version build </label>
                                    <input class="form-control" name="versionBuild" type="text" value="{{request('versionBuild')}}"/>
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
                                    <a class="btn btn-info btn-sm" href="{{ route('linkDownload.create') }}"> Create New</a>
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
                            <th class="hidden-480">Os</th>
                            <th>Link Download</th>
                            <th>File Download</th>
                            <th class="hidden-480">Is Direct</th>
                            <th>Trạng thái</th>
                            <th class="hidden-480">Version build</th>
                            <th class="hidden-480">Delay</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td class="hidden-480">{{ $osArr[$rs->OS] }}</td>
                                <td>{{ $rs->link_tai }}</td>
                                <td>{{ $rs->file_down }}</td>
                                <td class="hidden-480">{{ $rs->is_direct }}</td>
                                <td>@if($rs->status == 1)  <span class="label label-sm label-success">Active</span> @else <span class="label label-sm label-inverse arrowed-in">Deactive</span> @endif</td>
                                <td class="hidden-480">{{ $rs->version_build }}</td>
                                <td class="hidden-480">{{ $rs->delay }}</td>
                                <td>
                                    @permission(['administrator','admin'])
                                    <a class="btn btn-xs btn-info" href="{{ route('linkDownload.edit',$rs->id) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
                                    @endpermission
                                    @permission(['administrator','admin'])
                                    {!! Form::open(['method' => 'DELETE','route' => ['linkDownload.destroy', $rs->id],'style'=>'display:inline']) !!}
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