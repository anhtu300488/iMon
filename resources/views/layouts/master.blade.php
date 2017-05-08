<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome.css') !!}" />

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="{!! asset('assets/css/ace-fonts.css') !!}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{!! asset('assets/css/ace.css') !!}" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{!! asset('assets/css/ace-part2.css') !!}" class="ace-main-stylesheet" />
    <![endif]-->

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{!! asset('assets/css/ace-ie.css') !!}" />
    <![endif]-->

    <link rel="stylesheet" href="{!! asset('css/style.css') !!}" />

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="{!! asset('assets/js/ace-extra.js') !!}"></script>

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <link rel="stylesheet" href="{!! asset('assets/css/jquery-ui.custom.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/chosen.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/datepicker.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap-timepicker.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/daterangepicker.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap-datetimepicker.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/colorpicker.css') !!}" />

    <script src="{{asset('js/jquery.min.js')}}"></script>

    <!--[if lte IE 8]>
    <script src="{!! asset('assets/js/html5shiv.js') !!}"></script>
    <script src="{!! asset('assets/js/respond.js') !!}"></script>
    <![endif]-->
</head>

<body class="no-skin">
<!-- #section:basics/navbar.layout -->
@include('layouts.partials._header')

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <!-- #section:basics/sidebar -->
    @include('layouts.partials._sidebar')

    <!-- /section:basics/sidebar -->
    <div class="main-content">
        <div class="main-content-inner">
            <!-- #section:basics/content.breadcrumbs -->
            <div class="breadcrumbs" id="breadcrumbs">
                <script type="text/javascript">
                    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                </script>

                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="#">Home</a>
                    </li>
                    <li class="active">Dashboard</li>
                </ul><!-- /.breadcrumb -->

                <!-- #section:basics/content.searchbox -->
                <div class="nav-search" id="nav-search">
                    <form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
                    </form>
                </div><!-- /.nav-search -->

                <!-- /section:basics/content.searchbox -->
            </div>

            <!-- /section:basics/content.breadcrumbs -->
            <div class="page-content">
                @yield('content')

            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

    @include('layouts.partials._footer')
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='../assets/js/jquery.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
</script>
<script src="{!! asset('assets/js/bootstrap.js') !!}"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="{!! asset('assets/js/excanvas.js') !!}"></script>
<![endif]-->
<script src="{!! asset('assets/js/jquery-ui.custom.js') !!}"></script>
<script src="{!! asset('assets/js/jquery.ui.touch-punch.js') !!}"></script>
<script src="{!! asset('assets/js/jquery.easypiechart.js') !!}"></script>
<script src="{!! asset('assets/js/jquery.sparkline.js') !!}"></script>
<script src="{!! asset('assets/js/flot/jquery.flot.js') !!}"></script>
<script src="{!! asset('assets/js/flot/jquery.flot.pie.js') !!}"></script>
<script src="{!! asset('assets/js/flot/jquery.flot.resize.js') !!}"></script>
<script src="{!! asset('assets/js/chosen.jquery.js') !!}"></script>
<script src="{!! asset('assets/js/fuelux/fuelux.spinner.js') !!}"></script>
<script src="{!! asset('assets/js/date-time/bootstrap-datepicker.js') !!}"></script>
<script src="{!! asset('assets/js/date-time/bootstrap-timepicker.js') !!}"></script>
<script src="{!! asset('assets/js/date-time/moment.js') !!}"></script>
<script src="{!! asset('assets/js/date-time/daterangepicker.js') !!}"></script>
<script src="{!! asset('assets/js/bootstrap-colorpicker.js') !!}"></script>
<script src="{!! asset('assets/js/jquery.knob.js') !!}"></script>
<script src="{!! asset('assets/js/jquery.autosize.js') !!}"></script>
<script src="{!! asset('assets/js/jquery.inputlimiter.1.3.1.js') !!}"></script>
<script src="{!! asset('assets/js/jquery.maskedinput.js') !!}"></script>
<script src="{!! asset('assets/js/bootstrap-tag.js') !!}"></script>

<!-- ace scripts -->
<script src="{!! asset('assets/js/ace/elements.scroller.js') !!}"></script>
<script src="{!! asset('assets/js/ace/elements.colorpicker.js') !!}"></script>
<script src="{!! asset('assets/js/ace/elements.fileinput.js') !!}"></script>
<script src="{!! asset('assets/js/ace/elements.typeahead.js') !!}"></script>
<script src="{!! asset('assets/js/ace/elements.wysiwyg.js') !!}"></script>
<script src="{!! asset('assets/js/ace/elements.spinner.js') !!}"></script>
<script src="{!! asset('assets/js/ace/elements.treeview.js') !!}"></script>
<script src="{!! asset('assets/js/ace/elements.wizard.js') !!}"></script>
<script src="{!! asset('assets/js/ace/elements.aside.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.ajax-content.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.touch-drag.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.sidebar.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.sidebar-scroll-1.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.submenu-hover.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.widget-box.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.settings.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.settings-rtl.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.settings-skin.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.widget-on-reload.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.searchbox-autocomplete.js') !!}"></script>

<script src="{!! asset('assets/tinymce/js/tinymce/tinymce.min.js') !!}"></script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- the following scripts are used in demo only for onpage help and you don't need them -->
<link rel="stylesheet" href="{!! asset('assets/css/ace.onpage-help.css') !!}" />
<link rel="stylesheet" href="{!! asset('docs/assets/js/themes/sunburst.css') !!}" />

<script type="text/javascript"> ace.vars['base'] = '..'; </script>
<script src="{!! asset('assets/js/ace/elements.onpage-help.js') !!}"></script>
<script src="{!! asset('assets/js/ace/ace.onpage-help.js') !!}"></script>
<script src="{!! asset('docs/assets/js/rainbow.js') !!}"></script>
<script src="{!! asset('docs/assets/js/language/generic.js') !!}"></script>
<script src="{!! asset('docs/assets/js/language/html.js') !!}"></script>
<script src="{!! asset('docs/assets/js/language/css.js') !!}"></script>
<script src="{!! asset('docs/assets/js/language/javascript.js') !!}"></script>
</body>
</html>
