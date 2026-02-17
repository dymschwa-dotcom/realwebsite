@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tags as $tag)
                                    <tr>
                                        <td>{{ $tags->firstItem() + $loop->index }}</td>
                                        <td>
                                            <span>{{ __($tag->name) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                echo $tag->statusBadge;
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--primary editButton"
                                                        data-id="{{ $tag->id }}" data-name="{{ $tag->name }}">
                                                    <i class="las la-pen"></i> @lang('Edit')
                                                </button>

                                                @if ($tag->status == Status::ENABLE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.tag.status', $tag->id) }}" data-question="@lang('Are you sure to disable this tag')?">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn" data-action="{{ route('admin.tag.status', $tag->id) }}" data-question="@lang('Are you sure to enable this tag')?">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($tags->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($tags) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="tagAddModal" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true"
         tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"></h4>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <select name="name[]" class="form-control select2-auto-tokenize" multiple required></select>
                        </div>
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tagEditModal" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true"
         tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"></h4>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="post" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" value="{{ old('name') }}" required>
                        </div>
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection
@push('breadcrumb-plugins')
    <x-search-form />
    <button class="btn btn-outline--primary createButton"><i class="las la-plus"></i>@lang('Add New')</button>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict"

            $('.createButton').on('click', function() {
                var modal = $('#tagAddModal');
                modal.find('.modal-title').text('Add New Tag');
                modal.find('form').attr('action', `{{ route('admin.tag.store') }}`);
                modal.find('[name=name]').val($(this).data('name'));
                modal.modal('show')
            });

            $('.editButton').on('click', function() {
                var modal = $('#tagEditModal');
                modal.find('.modal-title').text('Update Tag');
                modal.find('form').attr('action', `{{ route('admin.tag.update', '') }}/${$(this).data('id')}`);
                modal.find('[name=name]').val($(this).data('name'));
                modal.modal('show')
            });



        })(jQuery);
    </script>
@endpush
