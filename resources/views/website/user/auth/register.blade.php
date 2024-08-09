@extends('layouts.website.app')

@section('head_title')
    {{ __('register') }}
@endsection
@section('content')
    <section class="wrapper bg-light">
        <div class="container pt-12 pt-md-14 pb-14 pb-md-16">
            <div class="auth">
                <div class="top">
                    <a href="{{ route('user.auth.login') }}">{{ __('login') }}</a>
                    <a href="#" class="active">{{ __('register') }}</a>
                </div>
                <!-- Include Toastr CSS -->

                <!-- Your HTML form -->
                <form id="registerForm" action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center justify-content-between">
                        <span>{{ __('Name') }}</span>
                    </div>
                    <div class="form- mb-3">
                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" />
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <span>{{ __('Email') }}</span>
                    <div class="form- mb-3">
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <span>{{ __('Mobile') }}</span>
                    <div class="form- mb-3">
                        <input type="text" name="mobile" class="form-control" placeholder="0105654644" />
                        @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span>{{ __('Password') }}</span>
                    </div>
                    <div class="form- mb-3">
                        <input type="password" name="password" class="form-control"
                            placeholder="{{ __('Password') }}" />
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span>{{ __('Confirm Password') }}</span>
                    </div>
                    <div class="form- mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="{{ __('Confirm Password') }}" />
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4 d-flex align-items-center gap-2 fs-13">
                        <input type="checkbox" class="form-check-input mt-0 fs-10" name="agree_to_terms" id="agreeTerms"
                            value="agree" aria-label="{{ __('Checkbox for agreeing to terms') }}" />
                        <label class="form-check-label"
                            for="agreeTerms">{{ __('Do you agree to the terms and conditions?') }}</label>
                    </div>
                    <button type="submit" class="btn__shop w-100">{{ __('Register') }}</button>
                </form>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- <script>
        $(document).ready(function() {
            $('#registerForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        // Check if registration was successful
                        if (response.status) {
                            // Redirect to the specified URL
                            window.location.href = response.url;
                        } else {
                            // Show error message using Toastr
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show error message using Toastr
                        toastr.error(error);
                    }
                });
            });
        });
    </script> --}}
@endpush
