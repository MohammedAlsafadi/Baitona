@extends('admin.layouts.app')

@section('main-content')
    <link type="text/css" rel="stylesheet" href="{{ asset('app-assets/image-uploader-master/dist/image-uploader.min.css') }}">

    <style>
        tbody>tr>td:hover {
            cursor: grab !important;
        }
    </style>

    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('common.sliders')</h4>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary add_btn" style="float: left"
                        data-bs-original-title="Edit" data-bs-toggle="modal" id="create_btn"
                        data-bs-target=".create_modal">+ @lang('common.add')</button>
                    {{--                @if (auth()->user()->hasAnyPermission(['edit_country_status'])) --}}
                    {{-- <button value="1" disabled="disabled" id="status_btn" class="status_btn btn btn-dark">
                        @lang('common.activate')
                    </button>
                    <button value="0" disabled="disabled" id="status_btn" class="status_btn btn btn-warning">
                        @lang('common.deactivate')
                    </button> --}}
                    {{--                @endif --}}
                    {{--                @if (auth()->user()->hasAnyPermission(['delete_country'])) --}}
                    <button disabled="disabled" id="delete_btn" class="delete-btn btn btn-danger"><i
                            class="fa fa-lg fa-trash-o"></i> @lang('common.delete')</button>
                    {{--                @endif
                </div>
                {{-- <form id="search_form" style="margin-right: 25px;margin-top: 30px"> --}}
                    {{-- <h6>@lang('common.search')</h6>
                    <div class="form-row">
                        <div class="form-group">
                            <input id="s_name" name="name" class="form-control" style="width: 15%; display: inline" placeholder="@lang('common.name')">
                            <select id="s_country_id" name="country_id" class="form-control" style="width: 15%; display: inline">
                                <option selected disabled>@lang('common.choose') @lang('common.country')</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <input type="button" id="search_btn"
                            class="btn btn-info" value="@lang('common.search')">
                            <input type="button" id="clear_btn"
                            class="btn btn-secondary" value="@lang('common.clear_search')">
                        </div>
                    </div>
                </form> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th class="checkbox-column sorting_disabled" rowspan="1" colspan="1"
                                        style="width: 35px;" aria-label="Record Id">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="select_all" />
                                            <label class="form-check-label" for="select_all"></label>
                                        </div>
                                    </th>
                                    <th>@lang('common.id')</th>
                                    <th>@lang('common.title')</th>
                                    <th>@lang('common.desc')</th>
                                    <th>@lang('common.image')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                            </thead>
                            <tbody id="sliders_table">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade create_modal" id="create_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">@lang('common.add') @lang('common.slider')</h1>
                        </div>
                        <form id="create_form" data-reset="true" method="POST" class="row gy-1 pt-75 ajax_form"
                            onsubmit="return false" enctype="multipart/form-data">
                            @csrf
                            @foreach (locales() as $key => $value)
                                <div class="col-12 col-md-6">
                                    <label class="form-label"
                                        for="title_{{ $key }}">{{ __('common.title') . ' - ' . __('common.' . $value) }}</label>
                                    <input type="text" id="title_{{ $key }}" name="title_{{ $key }}"
                                        class="form-control"
                                        placeholder="{{ __('common.title') . ' - ' . __('common.' . $value) }}" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            @endforeach
                            @foreach (locales() as $key => $value)
                                <div class="col-12 col-md-6">
                                    <label class="form-label"
                                        for="desc_{{ $key }}">{{ __('common.desc') . ' - ' . __('common.' . $value) }}</label>
                                    <input type="text" id="desc_{{ $key }}" name="desc_{{ $key }}"
                                        class="form-control"
                                        placeholder="{{ __('common.desc') . ' - ' . __('common.' . $value) }}" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            @endforeach
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="image">{{ __('common.image') }}</label>
                                <input type="file" id="image" name="image" class="form-control"
                                    placeholder="{{ __('common.image') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="submit" class="btn btn-primary me-1 submit_btn"
                                    form="create_form">@lang('common.save_changes')</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    @lang('common.discard')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">@lang('common.edit') @lang('common.slider')</h1>
                        </div>
                        <form id="editUserForm" data-reset="true" method="POST" class="row gy-1 pt-75 ajax_form"
                            onsubmit="return false" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @foreach (locales() as $key => $value)
                                <div class="col-12 col-md-6">
                                    <label class="form-label"
                                        for="edit_title_{{ $key }}">{{ __('common.title') . ' - ' . __('common.' . $value) }}</label>
                                    <input type="text" id="edit_title_{{ $key }}"
                                        name="title_{{ $key }}" class="form-control"
                                        placeholder="{{ __('common.title') . ' - ' . __('common.' . $value) }}" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            @endforeach
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_desc_ar">Description</label>
                                <input type="text" id="edit_desc_ar" name="desc_ar" class="form-control"
                                    placeholder="{{ __('common.desc_ar') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_desc_en">Description</label>
                                <input type="text" id="edit_desc_en" name="desc_en" class="form-control"
                                    placeholder="{{ __('common.desc_en') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_image">{{ __('common.image') }}</label>
                                <input type="file" id="edit_image" name="image" class="form-control"
                                    placeholder="{{ __('common.image') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <img id="show_image" style="width: 150px">
                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="submit" class="btn btn-primary me-1 submit_btn"
                                    form="editUserForm">@lang('common.save_changes')</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    @lang('common.discard')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
            integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            var url = '{{ url(app()->getLocale() . '/admin/sliders/') }}/';

            var dt_adv_filter = $('#datatable').DataTable({
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>'
                    },
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "@lang('common.search')",
                    "sLengthMenu": "@lang('common.show') @lang('common.menu') @lang('common.data')",
                },
                'columnDefs': [{
                        "targets": 1,
                        "visible": false
                    },
                    {
                        'targets': 0,
                        "searchable": false,
                        "orderable": false
                    },
                ],
                // dom: 'lrtip',
                "order": [
                    [1, 'asc']
                ],
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: url + 'indexTable',
                    data: function(d) {
                        d.country_id = $('#s_country_id').val();
                        d.name = $('#s_name').val();
                    }
                },
                columns: [{
                        "render": function(data, type, full, meta) {
                            return `<td class="checkbox-column sorting_1">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input table_ids" type="checkbox" name="table_ids[]" value="` +
                                full.id + `"/>
                                        <label class="form-check-label"></label>
                                    </div>
                                </td>`;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'desc',
                        name: 'desc',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        'render': function(data, type, full, meta) {
                           console. log (full)
                            return '<img src="' + full.image + '" style="width: 100px;">';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).ready(function() {
                dt_adv_filter.on('draw', function() {
                    $("#select_all").prop("checked", false)
                    $('#delete_btn').prop('disabled', 'disabled');
                    $('.status_btn').prop('disabled', 'disabled');
                });

                $(document).on('click', '.edit_btn', function(event) {
                    var button = $(this);
                    var id = button.data('id');
                    console.log(button.data());
                    $('#editUserForm').attr('action', url + id + '/update');
                    $('#edit_title_ar').val(button.data('title_ar'));
                    $('#edit_title_en').val(button.data('title_en'));
                    $('#edit_desc_ar').val(button.data('desc_ar'));
                    $('#edit_desc_en').val(button.data('desc_en'));
                    $('#show_image').attr('src', button.data('image'));
                });

                $(document).on('click', '#create_btn', function(event) {
                    $('#create_form').attr('action', '{{ route('sliders.store') }}');
                });
            });

            function add_remove(id) {

                $(this).removeClass('btn btn-dark');
                $(this).addClass('btn btn-warning');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                $.ajax({
                    url: '{{ url(app()->getLocale() . '/mmr/cities/update_status/') }}/' + id,
                    method: 'PUT',
                    success: function(desc) {
                        $('#btn_' + id).removeClass(desc.remove);
                        $('#btn_' + id).addClass(desc.add);
                        $('#btn_' + id).text(desc.text);
                        $('#msg').html(desc.message).show();
                        setTimeout(function() {
                            $("#msg").hide();
                        }, 5000);
                    }
                });
            }

            function Delete(id) {
                Swal.fire({
                    title: 'هل متأكد من الحذف ؟',
                    type: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم',
                    cancelButtonText: 'لا',
                }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('delete-form-' + id).submit();
                    }
                })
            }
        </script>
    @endsection
