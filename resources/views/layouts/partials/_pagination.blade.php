<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">Showing {{$data->firstItem()}} to {{$data->lastItem()}} of {{$data->total()}} entries</div>
        </div>
        <div class="col-xs-6" style="padding-right: 0px">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                {{ $data->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>