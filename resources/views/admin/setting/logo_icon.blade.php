@extends('layouts.app')
@section('content')
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-none-30">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('White Logo') }}</h5>
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid"
                                style="height:80px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'] . '/logo.png', '?' . time()) }})">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" id="logo" accept=".png, .jpg, .jpeg"
                                    name="logo">
                                <label class="input-group-text" for="logo">{{ __('Select Logo') }}</label>
                            </div>
                        </div>
                        <small class="ms-1 text-danger"><code>350px x 75px</code></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('Dark Logo') }}</h5>
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid bg-dark"
                                style="height:80px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'] . '/logo-dark.png', '?' . time()) }})">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" id="logo-dark" accept=".png, .jpg, .jpeg"
                                    name="logo_dark">
                                <label class="input-group-text" for="logo-dark">{{ __('Select Logo') }}</label>
                            </div>
                        </div>
                        <small class="ms-1 text-danger"><code>350px x 75px</code></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-none-30">

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('White Icon') }}</h5>
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid"
                                style="height:80px;width:80px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'] . '/icon.png', '?' . time()) }})">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" id="icon" accept=".png" name="icon">
                                <label for="icon" class="input-group-text">Select Icon</label>
                            </div>
                        </div>
                        <small class="ms-1 text-danger"><code>64px x 64px</code></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('Dark Icon') }}</h5>
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid bg-dark"
                                style="height:80px;width:80px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'] . '/icon-dark.png', '?' . time()) }})">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" id="icon-dark" accept=".png" name="icon_dark">
                                <label for="icon-dark" class="input-group-text">Select Icon') }}</label>
                            </div>
                        </div>
                        <small class="ms-1 text-danger"><code>64px x 64px</code></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-none-30">

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('Favicon') }}</h5>
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid"
                                style="height:16px;width:16px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png', '?' . time()) }})">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" id="favicon" accept=".png" name="favicon">
                                <label for="favicon" class="input-group-text">{{ __('Select Favicon') }}</label>
                            </div>
                        </div>
                        <small class="ms-1 text-danger">{{ __('generate favicon on') }} <a
                                href="https://www.favicon-generator.org/">favicon-generator.org</a>
                            {{ __('then convert it to PNG from') }} <a
                                href="https://cloudconvert.com/ico-to-png">cloudconvert.com</a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Update') }}</button>
                        <label class="text-warning">*{{ __('Please clean your browser cache after update') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('style')
    <style type="text/css">
        .logoPrev {
            background-size: 100%;
        }

        .iconPrev {
            background-size: 100%;
        }
    </style>
@endpush
