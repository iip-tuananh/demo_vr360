@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý dịch vụ
@endsection

@section('page_title')
Quản lý dịch vụ
@endsection

@section('content')
<div  ng-cloak>
	<div class="row" ng-controller="Services">
		<div class="col-12">
			<div class="card">
				<!-- /.card-header -->
				<div class="card-body">
					<table id="table-list">
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
    let datatable = new DATATABLE('table-list', {
        ajax: {
            url: '{{route('services.searchData')}}',
            data: function (d, context) {
                DATATABLE.mergeSearch(d, context);
            }
        },
        columns: [
            {data: 'DT_RowIndex', orderable: false, title: "STT"},
            {
                data: 'image', title: "Hình ảnh", orderable: false, className: "text-center",
            },
            {data: 'name',title: 'Tiêu đề'},
            // {data: 'service_type', title: 'Danh mục'},
            // {data: 'time', title: 'Thời gian'},
            // {data: 'price', title: 'Giá ưu đãi', className:'text-right'},
            // {data: 'base_price', title: 'Giá dịch vụ', className:'text-right'},
            {
                data: 'status',
                title: "Trạng thái",
                render: function (data) {
                    return getStatus(data, @json(App\Model\Admin\Service::STATUSES));
                },
                className: 'text-center'
            },
            {data: 'action', orderable: false, title: "Hành động"}
        ],
        search_columns: [
            {data: 'name', search_type: "text", placeholder: "Tiêu đề"},
            {
                data: 'status', search_type: "select", placeholder: "Trạng thái",
                column_data: @json(App\Model\Admin\Post::STATUSES)
            },
        ],
        search_by_time: false,
        create_link: "{{ route('services.create') }}"
    }).datatable;

    app.controller('Services', function ($scope, $rootScope, $http) {

    })
</script>
@include('partial.confirm')
@endsection
