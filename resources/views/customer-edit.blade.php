@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Customer') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('customer-update', $customer->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" maxlength="11" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $customer->address) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">{{ __('Image') }}</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <!-- Display the existing image -->
                            @if ($customer->image)
                                <div class="mb-3">
                                    <label>{{ __('Existing Image') }}</label>
                                    <img src="{{ asset($customer->image) }}" alt="Customer Image" class="img-thumbnail">
                                </div>
                            @endif
                            <!-- Add input fields for other customer details as needed -->
                            <button type="submit" class="btn btn-primary">{{ __('Update Customer') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
