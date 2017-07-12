@extends('layouts.master')
@section('title')
    Quản lý game
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
                            {!! Form::open(['method'=>'GET','url'=>'game/manageGame','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên game</label>
                                    <input class="form-control" name="name" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Hướng dẫn</label>
                                    <input class="form-control" name="description" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Hỗ trợ</label>
                                    <input class="form-control" name="help" type="text" />
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Trạng thái</label>
                                    <select class="form-control" id="form-field-select-1" name="status">
                                        <option value="">---Tất cả---</option>
                                        <option value="0" <?php if(request('status') == 1) echo "selected='selected'"; ?> >Undefined</option>
                                        <option value="1" <?php if(request('status') == 2) echo "selected='selected'"; ?> >CMS</option>
                                    </select>
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
                            <th class="hidden-480">STT</th>
                            <th>Tên game</th>
                            <th class="hidden-480">Hướng dẫn</th>
                            <th>Hỗ trợ</th>
                            <th>Trạng thái</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->name }}</td>
                                <td>{{ strip_tags($rs->description) }}</td>
                                <td class="hidden-480">{{ $rs->help }}</td>
                                <td>@if($rs->status == 1)  <span class="label label-sm label-success">Success</span> @else <span class="label label-sm label-inverse arrowed-in">Unsucess</span> @endif</td>
                                <td>
                                    @permission(['administrator','admin'])
                                    <a class="btn btn-xs btn-info" href="{{ route('manageGame.edit',$rs->gameId) }}">
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