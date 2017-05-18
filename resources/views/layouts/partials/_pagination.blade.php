<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">Hiển thị {{$data->firstItem()}} đến {{$data->lastItem()}} trong tổng {{$data->total()}} bản ghi</div>
        </div>
        <div class="col-xs-6" style="padding-right: 0px">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                {{ $data->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>