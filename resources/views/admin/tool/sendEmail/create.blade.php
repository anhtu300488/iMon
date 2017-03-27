@extends('layouts.master')
@section('title')
    Gửi email cho người dùng
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            {!! Form::open(array('route' => 'tool.sendEmail.store','method'=>'POST', 'class' => 'form-horizontal', 'id'=>'sendEmail')) !!}

        <!-- PAGE CONTENT BEGINS -->
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên tài khoản </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" placeholder="vd: binhnv, hungdv, " name="recipientUserName" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <!-- /section:elements.form -->
            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> Tiêu đề </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-2" name="title" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Nội dung</label>
                <div class="col-sm-9" >
                    {!! Form::textarea('body') !!}
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>

            <div class="hr hr-24"></div>
            <!-- PAGE CONTENT ENDS -->
            {!! Form::close() !!}

        </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- page specific plugin scripts -->
    <script src="{!! asset('assets/js/jquery-ui.custom.js') !!}"></script>
    <script src="{!! asset('assets/js/jquery.ui.touch-punch.js') !!}"></script>
    <script src="{!! asset('assets/js/markdown/markdown.js') !!}"></script>
    <script src="{!! asset('assets/js/markdown/bootstrap-markdown.js') !!}"></script>
    <script src="{!! asset('assets/js/jquery.hotkeys.js') !!}"></script>
    <script src="{!! asset('assets/js/bootstrap-wysiwyg.js') !!}"></script>
    <script src="{!! asset('assets/js/bootbox.js') !!}"></script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($){

            tinymce.init({
                selector: 'textarea',
                height: 200,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                content_css: '//www.tinymce.com/css/codepen.min.css'
            });

        });
    </script>

@endsection