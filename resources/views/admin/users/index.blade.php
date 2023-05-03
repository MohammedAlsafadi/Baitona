@extends('admin.layouts.app')

@section('main-content')
    <link type="text/css" rel="stylesheet" href="{{ asset('app-assets/image-uploader-master/dist/image-uploader.min.css') }}">

    <style>
        tbody>tr>td:hover {
            cursor: grab !important;
        }
    </style>

    <div class="row">
        @php
            use App\Models\User;
            $usersCount = User::count('id');
            $activeUsers = User::where('status', 1)->count();
        @endphp
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="fw-bolder mb-75">{{ $usersCount }}</h3>
                        <span>@lang('common.total') @lang('common.users')</span>
                    </div>
                    <div class="avatar bg-light-primary p-50">
                        <span class="avatar-content">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-user font-medium-4">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="fw-bolder mb-75">{{$activeUsers}}</h3>
                        <span>@lang('common.users') @lang('common.actives')</span>
                    </div>
                    <div class="avatar bg-light-success p-50">
                        <span class="avatar-content">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-user-check font-medium-4">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('common.users')</h4>
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
                                    <th>@lang('common.image')</th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('common.email')</th>
                                    <th>@lang('common.mobile')</th>
                                    <th>@lang('common.city')</th>
                                    <th>@lang('common.specialty')</th>
                                    <th>@lang('common.status')</th>
                                    <th>@lang('common.roles')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                            </thead>
                            <tbody id="users_table">
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
                            <h1 class="mb-1">@lang('common.add') @lang('common.user')</h1>
                        </div>
                        <form id="create_form" data-reset="true" method="POST" class="row gy-1 pt-75 ajax_form"
                            onsubmit="return false" enctype="multipart/form-data">
                            @csrf
                            <div class="col-6">
                                <label class="form-label" for="role_ids">{{__('common.roles')}}</label>
                                <div class="mb-1">
                                    <div class="position-relative"><select class="select2 form-select select2-hidden-accessible" multiple="" id="role_ids" name="role_ids[]" tabindex="-1" aria-hidden="true">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                    </select></div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="first_name">{{ __('common.first_name') }}</label>
                                <input type="text" id="first_name" name="first_name" class="form-control"
                                    placeholder="{{ __('common.first_name') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="last_name">{{ __('common.last_name') }}</label>
                                <input type="text" id="last_name" name="last_name" class="form-control"
                                    placeholder="{{ __('common.last_name') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="gender">{{ __('common.gender') }}</label>
                                <select class="form-select" id="gender" name="gender" class="form-control">
                                    <option value="0">male</option>
                                    <option value="1">female</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="status">{{ __('common.status') }}</label>
                                <select class="form-select" id="status" name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="date">{{ __('common.date') }}</label>
                                <input type="date" id="date" name="date" class="form-control"
                                    placeholder="{{ __('common.date') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="mobile">{{ __('common.mobile') }}</label>
                                <input type="text" id="mobile" name="mobile" class="form-control"
                                    placeholder="{{ __('common.mobile') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="email">{{ __('common.email') }}</label>
                                <input type="email" autocomplete="off" id="email" name="email"
                                    class="form-control" placeholder="{{ __('common.email') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="password">{{ __('common.password') }}</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="{{ __('common.password') }}" autocomplete="off" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="specialty">{{ __('common.specialty') }}</label>
                                <input type="text" id="specialty" name="specialty" class="form-control"
                                    placeholder="{{ __('common.specialty') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="city">{{ __('common.city') }}</label>
                                <input type="text" id="city" name="city" class="form-control"
                                    placeholder="{{ __('common.city') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
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
                            <h1 class="mb-1">@lang('common.edit') @lang('common.user')</h1>
                        </div>
                        <form id="editUserForm" data-reset="true" method="POST" class="row gy-1 pt-75 ajax_form"
                            onsubmit="return false" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-6">
                                <label class="form-label" for="edit_role_ids">{{__('common.roles')}}</label>
                                <div class="mb-1">
                                    <div class="position-relative"><select class="select2 form-select select2-hidden-accessible" multiple="" id="edit_role_ids" name="role_ids[]" tabindex="-1" aria-hidden="true">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                    </select></div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_first_name">{{ __('common.first_name') }}</label>
                                <input type="text" id="edit_first_name" name="first_name" class="form-control"
                                    placeholder="{{ __('common.first_name') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_last_name">{{ __('common.last_name') }}</label>
                                <input type="text" id="edit_last_name" name="last_name" class="form-control"
                                    placeholder="{{ __('common.last_name') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="edit_gender">{{ __('common.gender') }}</label>
                                <select class="form-select" id="edit_gender" name="gender" class="form-control">
                                    <option value="0">male</option>
                                    <option value="1">female</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="edit_status">{{ __('common.status') }}</label>
                                <select class="form-select" id="edit_status" name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_date">{{ __('common.date') }}</label>
                                <input type="date" id="edit_date" name="date" class="form-control"
                                    placeholder="{{ __('common.date') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_mobile">{{ __('common.mobile') }}</label>
                                <input type="text" id="edit_mobile" name="mobile" class="form-control"
                                    placeholder="{{ __('common.mobile') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_email">{{ __('common.email') }}</label>
                                <input type="email" autocomplete="off" id="edit_email" name="email"
                                    class="form-control" placeholder="{{ __('common.email') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_password">{{ __('common.password') }}</label>
                                <input type="password" id="edit_password" name="password" class="form-control"
                                    placeholder="{{ __('common.password') }}" autocomplete="off" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_specialty">{{ __('common.specialty') }}</label>
                                <input type="text" id="edit_specialty" name="specialty" class="form-control"
                                    placeholder="{{ __('common.specialty') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="edit_city">{{ __('common.city') }}</label>
                                <input type="text" id="edit_city" name="city" class="form-control"
                                    placeholder="{{ __('common.city') }}" />
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
            var url = '{{ url(app()->getLocale() . '/admin/users/') }}/';
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
                        data: 'id',
                        'render': function(data, type, full, meta) {
                            return '<img src="' + full.image + '" style="width: 100px;">';
                        }
                    },
                    {
                        data: 'full_name',
                        name: 'first_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'mobile',
                        name: 'mobile',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'city',
                        name: 'city',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'specialty',
                        name: 'specialty',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'role_names',
                        name: 'role_names',
                        orderable: false,
                        searchable: false
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
                    $('#edit_first_name').val(button.data('first_name'));
                    $('#edit_last_name').val(button.data('last_name'));
                    $('#edit_gender').val(button.data('gender'));
                    $('#edit_status').val(button.data('status'));
                    $('#edit_date').val(button.data('date'));
                    $('#edit_mobile').val(button.data('mobile'));
                    $('#edit_email').val(button.data('email'));
                    $('#edit_password').val(button.data('password'));
                    $('#edit_city').val(button.data('city'));
                    $('#edit_specialty').val(button.data('specialty'));
                    $('#show_image').attr('src', button.data('image'));

                    var role_ids = button.data('roles') + ''
                    if (role_ids.indexOf(",") >= 0) {
                        roles = (button.data('roles').split(','))
                        roles = roles.filter(item => item);
                        console.log(roles)
                    }
                    $("#edit_role_ids").val(roles).trigger('change');
                });
                $(document).on('click', '#create_btn', function(event) {
                    $('#create_form').attr('action', '{{ route('users.store') }}');
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
                    success: function(data) {
                        $('#btn_' + id).removeClass(data.remove);
                        $('#btn_' + id).addClass(data.add);
                        $('#btn_' + id).text(data.text);
                        $('#msg').html(data.message).show();
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
