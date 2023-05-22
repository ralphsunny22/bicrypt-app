@extends('layouts.app')
@php
    $country_code = json_decode(json_encode(getIpInfo()), true)['code'];
@endphp
@section('vendor-style')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-9 col-lg-7 col-md-7">
            <div class="card">
                <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-2">{{ $user->fullname }} {{ __('Information') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('First Name') }}<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname"
                                        value="{{ $user->firstname }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col">
                                    <label class="form-control-label  h6 mt-1">{{ __('Last Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname"
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('Email') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col">
                                    <label class="form-control-label  h6 mt-1">{{ __('Mobile Number') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile" value="{{ $user->mobile }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('Address') }} </label>
                                    <input class="form-control" type="text" name="address" value="{{ $user->address }}">
                                    <small class="form-text text-muted"><i class="bi bi-info-circle-circle"></i>
                                        {{ __('House number, street address') }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="col">
                                    <label class="form-control-label h6 mt-1">{{ __('City') }} </label>
                                    <input class="form-control" type="text" name="city" value="{{ $user->city }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('State') }} </label>
                                    <input class="form-control" type="text" name="state" value="{{ $user->state }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('Zip/Postal') }} </label>
                                    <input class="form-control" type="text" name="zip" value="{{ $user->zip }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('Country') }} </label>
                                    <select id="country" name="country" placeholder="Country" aria-describedby="country"
                                        value="{{ old('country') }}" class="form-control"> @include('partials.country')
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('Wallets') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th>{{ __('Symbol') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Provider') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wallets as $wallet)
                                <tr>
                                    <td data-label="{{ __('Symbol') }}">{{ $wallet->symbol }}</td>
                                    <td data-label="{{ __('Address') }}">{{ $wallet->address }}</td>
                                    <td data-label="{{ __('Provider') }}">{{ strtoupper($wallet->provider) }}
                                    </td>
                                    <td data-label="{{ __('Balance') }}">{{ $wallet->balance }}</td>
                                    <td data-label="{{ __('Type') }}">{{ strtoupper($wallet->type) }}</td>
                                    <td data-label="{{ __('Action') }}">
                                        <div class="d-flex justify-content-start">
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Add/Subtract Balance') }}"
                                                data-address="{{ $wallet->address }}"
                                                data-symbol="{{ $wallet->symbol }}"
                                                class="btn btn-icon btn-success btn-sm"
                                                onclick="$('#addSubModal').find('input[name=address]').val($(this).data('address'));
                                                            $('#addSubModal').find('input[name=symbol]').val($(this).data('symbol'));$('#addSubModal').modal('show');">
                                                <i class="bi bi-cash"></i>
                                            </a>
                                            @if ($wallet->provider != 'funding' && $wallet->provider != 'mainnet' && $wallet->provider != 'testnet')
                                                <form class="ms-1" method="POST"
                                                    action="{{ route('admin.wallet.regenerate') }}">
                                                    @csrf
                                                    <input type="hidden" id="user_id" name="user_id"
                                                        value="{{ $user->id }}">
                                                    <input type="hidden" id="symbol" name="symbol"
                                                        value="{{ $wallet->symbol }}">
                                                    <input type="hidden" id="address" name="address"
                                                        value="{{ $wallet->address }}">
                                                    <input type="hidden" id="type" name="type"
                                                        value="{{ $wallet->type }}">
                                                    <button type="submit" class="btn btn-icon btn-warning btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Regenerate Wallet') }}"><i
                                                            class="bi bi-arrow-repeat"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td class="text-muted text-center" colspan="100%">
                                        <img height="128px" width="128px"
                                            src="https://assets.staticimg.com/pro/2.0.4/images/empty.svg"
                                            alt="" />
                                        <p class="">{{ __('No Data Found') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('Frozen Wallets') }}</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        @if ($frozen_wallet == null)
                            <button class="btn btn-success me-1"
                                onclick="$('#createFrozenWallet').find('input[name=user_id]').val($(this).data('user_id'));
                            $('#createFrozenWallet').modal('show');"
                                data-user_id="{{ $user->id }}">{{ __('Create Wallet') }}</button>
                        @endif
                        <div class="card-search"></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th>{{ __('Symbol') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($frozen_wallet != null)
                                <tr>
                                    <td data-label="{{ __('Symbol') }}">{{ $frozen_wallet->symbol }}</td>
                                    <td data-label="{{ __('Balance') }}">{{ $frozen_wallet->balance }}</td>
                                    <td data-label="{{ __('Status') }}">
                                        @if ($frozen_wallet->status == 0)
                                            <span class="badge bg-danger">{{ __('Disabled') }}</span>
                                        @elseif($frozen_wallet->status == 1)
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('Action') }}">
                                        <div class="d-flex justify-content-start">
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Add/Subtract Balance') }}"
                                                data-symbol="{{ $frozen_wallet->symbol }}"
                                                class="btn btn-icon btn-success btn-sm me-1"
                                                onclick="$('#addSubModalFrozen').find('input[name=symbol]').val($(this).data('symbol'));
                                                            $('#addSubModalFrozen').modal('show');">
                                                <i class="bi bi-cash"></i>
                                            </a>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Wallet"
                                                data-symbol="{{ $frozen_wallet->symbol }}"
                                                class="btn btn-icon btn-danger btn-sm"
                                                href="{{ route('admin.users.wallet.frozen.remove', $frozen_wallet->id) }}">
                                                <i class="bi bi-x-lg"></i>
                                            </a>

                                            @if ($frozen_wallet->status == 0)
                                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                    class="btn btn-sm btn-icon btn-success rounded ms-1 "
                                                    data-id="{{ $frozen_wallet->id }}" title="{{ __('Enable') }}"
                                                    onclick="$('#activateModal').find('input[name=id]').val($(this).data('id'));
                                                            $('#activateModal').modal('show');">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @else
                                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                    class="btn btn-sm btn-icon btn-danger ms-1 deactivateBtn"
                                                    data-id="{{ $frozen_wallet->id }}" title="{{ __('Disable') }}"
                                                    onclick="$('#deactivateModal').find('input[name=id]').val($(this).data('id'));
                                                            $('#deactivateModal').modal('show');">
                                                    <i class="bi bi-eye-slash"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @else
                                <tr class="text-center">
                                    <td class="text-muted text-center" colspan="100%">
                                        <img height="128px" width="128px"
                                            src="https://assets.staticimg.com/pro/2.0.4/images/empty.svg"
                                            alt="" />
                                        <p class="">{{ __('No Data Found') }}</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ACTIVATE METHOD MODAL --}}
        <div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Frozen Wallet Enable Confirmation') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.users.wallet.frozen.activate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="modal-body">
                            <p>{{ __('Are you sure to activate frozen wallet?') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Activate') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- DEACTIVATE METHOD MODAL --}}
        <div id="deactivateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Frozen Wallet Disable Confirmation') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.users.wallet.frozen.deactivate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="modal-body">
                            <p>{{ __('Are you sure to disable frozen wallet?') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-5 col-md-5">
            <div class="card rounded-2 overflow-hidden shadow">
                <div class="card-body p-0">
                    <div class="p-3 bg-white">
                        <div class="mb-2">
                            <img src="{{ getImage(imagePath()['profileImage']['path'] . '/' . $user->profile_photo_path, imagePath()['profileImage']['size']) }}"
                                alt="{{ __('Profile Image') }}" class="w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{ $user->fullname }}</h4>
                            <span class="text-small">{{ __('Joined At') }}
                                <strong>{{ showDateTime($user->created_at, 'd M, Y h:i A') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded-2 overflow-hidden shadow">
                <div class="card-body">
                    <h5 class="text-muted">{{ __('User information') }}</h5>
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Username') }}
                            <span class="h6 mt-1">{{ $user->username }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Status') }}
                            @switch($user->status)
                                @case(1)
                                    <span class="badge rounded-pill bg-success">{{ __('Active') }}</span>
                                @break

                                @case(0)
                                    <span class="badge rounded-pill bg-danger">{{ __('Banned') }}</span>
                                @break
                            @endswitch
                        </li>

                        @if ($refer_by)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="float-start">{{ __('Referred By') }}</span>
                                <span class="float-end text-muted">{{ __($refer_by->username) }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="card rounded-2 overflow-hidden mt-2 shadow">
                <div class="card-body">
                    <h5 class="text-muted">{{ __('User action') }}</h5>
                    <a href="{{ route('admin.users.email.single', $user->id) }}" class="btn btn-danger mt-2">
                        {{ __('Send Email') }}
                    </a>
                    <a href="{{ route('admin.users.referral.log', $user->id) }}" class="btn btn-info mt-2">
                        {{ __('Referral Log') }}
                    </a>

                    <a href="{{ route('admin.users.commission.log', $user->id) }}" class="btn btn-warning mt-2">
                        {{ __('Commission Log') }}
                    </a>
                </div>
            </div>
        </div>

        <div id="addSubModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add / Subtract Balance') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.users.addSubBalance', $user->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="address">
                        <input type="hidden" name="symbol">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col col-md-12">
                                    <input class="form-check-input" data-width="100%" data-size="lg" type="checkbox"
                                        data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                        data-on="{{ __('Add Balance') }}" data-off="{{ __('Subtract Balance') }}"
                                        name="act" checked>
                                </div>

                                <div class="col col-md-12 mt-1">
                                    <label>{{ __('Amount') }}<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="amount" class="form-control"
                                            placeholder="{{ __('Please provide positive amount') }}">
                                        <div class="input-group-text">{{ __($general->cur_sym) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="addSubModalFrozen" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add / Subtract Balance') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.users.addSubBalanceFrozen', $user->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="symbol">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col col-md-12">
                                    <input class="form-check-input" data-width="100%" data-size="lg" type="checkbox"
                                        data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                        data-on="{{ __('Add Balance') }}" data-off="{{ __('Subtract Balance') }}"
                                        name="act" checked>
                                </div>


                                <div class="col col-md-12 mt-1">
                                    <label>{{ __('Amount') }}<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="amount" class="form-control"
                                            placeholder="{{ __('Please provide positive amount') }}">
                                        <div class="input-group-text">{{ __($general->cur_sym) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="createFrozenWallet" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Create Frozen Wallet') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.users.wallet.frozen.create', $user->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id">
                        <div class="modal-body">
                            <label>{{ __('Symbol') }}<span class="text-danger">*</span></label>
                            <input type="text" name="symbol" class="form-control">

                            <label class="mt-1">{{ __('Hover Text') }}<span class="text-danger">*</span></label>
                            <textarea type="text" name="text" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @push('breadcrumb-plugins')
        <a href="{{ route('admin.users.all') }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-left"></i>
            {{ __('Back') }}</a>
    @endpush
    @section('vendor-script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
    @endsection

    @push('script')
        <script>
            "use strict";
            $('.toggle').bootstrapToggle({
                on: 'Y',
                off: 'N',
                width: '100%',
                size: 'small'
            });
            $("select[name=country]").val("{{ @$user->country }}");
            @if ($country_code)
                $(`option[data-code={{ $country_code[0] }}]`).attr('selected', '');
            @endif
            $('select[name=country_code]').change(function() {
                $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
            }).change();
        </script>
    @endpush
