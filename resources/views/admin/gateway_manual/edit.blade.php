@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.payment.manual.update', $method->code) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-3">
                                <img class="img-thumbnail mb-1"
                                    src="{{ getImage(imagePath()['gateway']['path'] . '/' . $method->image, imagePath()['gateway']['path']) }}" />
                                <input type="file" name="image" class="form-control" id="image"
                                    accept=".png, .jpg, .jpeg" />
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                        <label class="h6">{{ __('Provider Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="{{ __('Method Name') }}"
                                            name="name" value="{{ $method->name }}" />
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <label class="h6">{{ __('Currency') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="currency" placeholder="{{ __('Currency') }}"
                                            class="form-control rounded"
                                            value="{{ @$method->single_currency->currency ?? 'USD' }}" />
                                    </div>
                                    <div class="col-xl-5 col-md-12">
                                        <label class="h6">{{ __('Rate') }} <span class="text-danger">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-text">1 {{ __($general->cur_text) }} =</div>
                                            <input type="text" class="form-control" placeholder="0" name="rate"
                                                value="{{ ttz(@$method->single_currency->rate ?? '1') }}" />
                                            <div class="input-group-text"><span class="currency_symbol"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card ">
                            <h5 class="card-header text-white bg-primary">{{ __('Payment Limits') }}</h5>
                            <div class="card-body">
                                <label class="mt-1 h6">{{ __('Minimum Amount') }} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                    <input type="text" class="form-control" name="min_limit" placeholder="0"
                                        value="{{ ttz(@$method->single_currency->min_amount ?? '1') }}" />
                                </div>
                                <label class="mt-1 h6">{{ __('Maximum Amount') }} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                    <input type="text" class="form-control" placeholder="0" name="max_limit"
                                        value="{{ ttz(@$method->single_currency->max_amount ?? '10000') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card ">
                            <h5 class="card-header text-white bg-primary">{{ __('Fees') }}</h5>
                            <div class="card-body">
                                <label class="mt-1 h6">{{ __('Fixed Fee') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                    <input type="text" class="form-control" placeholder="0" name="fixed_charge"
                                        value="{{ getAmount(@$method->single_currency->fixed_charge ?? '0') }}" />
                                </div>
                                <label class="mt-1 h6">{{ __('Percentage Fee') }} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text">%</div>
                                    <input type="text" class="form-control" placeholder="0" name="percent_charge"
                                        value="{{ @$method->single_currency->percent_charge ?? '0' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card mt-1">

                            <h5 class="card-header text-white bg-dark">{{ __('Deposit Instruction') }}</h5>
                            <div class="">
                                <div class="col">
                                    <textarea rows="8" class="form-control rounded mt-1" name="instruction">{{ __($method->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card mt-1">
                            <h5 class="card-header text-white bg-dark  text-white">{{ __('User data') }}
                                <button type="button" class="btn btn-sm btn-outline-light float-end addUserData"><i
                                        class="bi bi-plus"></i>{{ __('Add new') }}
                                </button>
                            </h5>

                            <div class="card-body">
                                <div class="row addedField">
                                    @if ($method->input_form != null)
                                        @foreach ($method->input_form as $k => $v)
                                            <div class="col-md-12 user-data">
                                                <div class="col">
                                                    <div class="input-group my-1">
                                                        <div class="col-md-4">
                                                            <input name="field_name[]" class="form-control"
                                                                type="text" value="{{ $v->field_level }}" required
                                                                placeholder="{{ __('Field Name') }}">
                                                        </div>
                                                        <div class="col-md-3 mx-1">
                                                            <select name="type[]" class="form-control">
                                                                <option value="text"
                                                                    @if ($v->type == 'text') selected @endif>
                                                                    {{ __('Input Text') }} </option>
                                                                <option value="textarea"
                                                                    @if ($v->type == 'textarea') selected @endif>
                                                                    {{ __('Textarea') }} </option>
                                                                <option value="file"
                                                                    @if ($v->type == 'file') selected @endif>
                                                                    {{ __('File upload') }} </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mx-1">
                                                            <select name="validation[]" class="form-control">
                                                                <option value="required"
                                                                    @if ($v->validation == 'required') selected @endif>
                                                                    {{ __('Required') }} </option>
                                                                <option value="nullable"
                                                                    @if ($v->validation == 'nullable') selected @endif>
                                                                    {{ __('Optional') }} </option>
                                                            </select>
                                                        </div>
                                                        <div class="col mx-1 text-end">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-danger removeBtn" type="button">
                                                                    <i class="bi bi-x"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{ __('Save Method') }}</button>
                </div>
            </div>
        </div>
        </div>

    </form>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.payment.manual.index') }}" class="btn btn-primary"><i class="bi bi-chevron-left"></i>
        {{ __('Go Back') }} </a>
@endpush
@section('page-script')
    <script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>
@endsection
@push('script')
    <script>
        $(function() {
            "use strict";


            $('input[name=currency]').on('input', function() {
                $('.currency_symbol').text($(this).val());
            });
            $('.currency_symbol').text($('input[name=currency]').val());


            $('.addUserData').on('click', function() {
                var html = `
                <div class="col-md-12 user-data">
                    <div class="col">
                        <div class="input-group my-1">
                            <div class="col-md-4">
                                <input name="field_name[]" class="form-control" type="text" value="" required placeholder="{{ __('Field Name') }}">
                            </div>
                            <div class="col-md-3 mx-1">
                                <select name="type[]" class="form-control">
                                    <option value="text" > {{ __('Input Text') }} </option>
                                    <option value="textarea" > {{ __('Textarea') }} </option>
                                    <option value="file"> {{ __('File upload') }} </option>
                                </select>
                            </div>
                            <div class="col-md-3 mx-1">
                                <select name="validation[]"
                                        class="form-control">
                                    <option value="required"> {{ __('Required') }} </option>
                                    <option value="nullable">  {{ __('Optional') }} </option>
                                </select>
                            </div>
                            <div class="col mx-1 text-end">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger removeBtn" type="button">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;
                $('.addedField').append(html)
            });

            $(document).on('click', '.removeBtn', function() {
                $(this).closest('.user-data').remove();
            });

            @if (old('currency'))
                $('input[name=currency]').trigger('input');
            @endif
        });
    </script>
@endpush
