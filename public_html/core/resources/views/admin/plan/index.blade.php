@extends("admin.layouts.app")
@section("panel")
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <form action="{{ route("admin.plan.update") }}" method="POST">
                        @csrf
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th>@lang("Plan Name")</th>
                                        <th>@lang("Price") ({{ gs("cur_text") }})</th>
                                        <th>@lang("Campaign Limit")</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plans as $plan)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="plans[{{ $loop->index }}][id]" value="{{ $plan->id }}">
                                                <strong>{{ __($plan->name) }}</strong>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ gs("cur_sym") }}</span>
                                                    <input type="number" step="any" class="form-control" name="plans[{{ $loop->index }}][price]" value="{{ getAmount($plan->price) }}" {{ $plan->id == 3 ? "readonly" : "" }}>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="plans[{{ $loop->index }}][campaign_limit]" value="{{ $plan->campaign_limit }}">
                                                <small class="text--small text-muted">@lang("Use -1 for unlimited")</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang("Update Plans")</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
