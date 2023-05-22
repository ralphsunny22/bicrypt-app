@extends('layouts.app')
@section('content')
    @if ($mlm->installed == 1)
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    {{ __('MLM Table Optimizer') }}
                </div>
                <a href="{{ route('admin.mlm.regenerate') }}"
                    class="btn btn-primary">{{ __('Regenerate MLM Rows For Old Users') }}</a>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                {{ __('Logs Cleaner') }}
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                    <form method="POST" action="{{ route('admin.database.binary.practice.logs.clean') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">{{ __('Clean Binary Practice Logs') }}</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                    <form method="POST" action="{{ route('admin.database.binary.trade.logs.clean') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">{{ __('Clean Binary Trade Logs') }}</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                    <form method="POST" action="{{ route('admin.database.trade.logs.clean') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">{{ __('Clean Trade Logs') }}</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                    <form method="POST" action="{{ route('admin.database.forex.investments.logs.clean') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">{{ __('Clean Forex Investments Logs') }}</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                    <form method="POST" action="{{ route('admin.database.bot.investments.logs.clean') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">{{ __('Clean Bot Investments Logs') }}</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                    <form method="POST" action="{{ route('admin.database.staking.logs.clean') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">{{ __('Clean Staking Logs') }}</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                    <form method="POST" action="{{ route('admin.database.ico.logs.clean') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">{{ __('Clean Token ICO Logs') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                {{ __('Wallets Optimizer') }}
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                    <form method="POST" action="{{ route('admin.database.wallets.clean') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">{{ __('Clean Broken Wallets') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
