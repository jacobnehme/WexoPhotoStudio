@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Edit Customer</div>

                    <div class="card-body">
                        <form method="POST" action="{{ action('CustomerController@update', 1)}}">
                            @csrf

                            <div class="form-group row">
                                <label for="name-first" class="col-md-4 col-form-label text-md-right">First Name</label>

                                <div class="col-md-6">
                                    <input id="name-first" type="text" class="form-control{{ $errors->has('name_first') ? ' is-invalid' : '' }}" name="name_first" value="{{ $customer->name_first }}" required>

                                    @if ($errors->has('name_first'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_first') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name-last" class="col-md-4 col-form-label text-md-right">Last Name</label>

                                <div class="col-md-6">
                                    <input id="name-last" type="text" class="form-control{{ $errors->has('name_last') ? ' is-invalid' : '' }}" name="name_last" value="{{ $customer->name_last }}" required>

                                    @if ($errors->has('name_last'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_last') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name-company" class="col-md-4 col-form-label text-md-right">Company Name</label>

                                <div class="col-md-6">
                                    <input id="name-company" type="text" class="form-control{{ $errors->has('name_company') ? ' is-invalid' : '' }}" name="name_company" value="{{ $customer->name_company }}" required>

                                    @if ($errors->has('name_company'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_company') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $customer->address }}" required>

                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="zip-code" class="col-md-4 col-form-label text-md-right">Zip Code</label>

                                <div class="col-md-6">
                                    <input id="zip-code" type="text" class="form-control{{ $errors->has('zip_code') ? ' is-invalid' : '' }}" name="zip_code" value="{{ $customer->zipCode->zip_code }}" required>

                                    @if ($errors->has('zip_code'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('zip_code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">City</label>

                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ $customer->zipCode->city }}" required>

                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
