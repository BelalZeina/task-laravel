<script src="{{ asset('websiteAsset/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('websiteAsset/js//swiper-bundle.min.js') }}"></script>
<script src="{{ asset('websiteAsset/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('websiteAsset/js/scrollreveal.js') }}"></script>
<script src="{{ asset('websiteAsset/js/jquery-3.6.0.min.js') }}"></script>
{{-- <script src="{{ asset('websiteAsset/js/toastr.min.js?v=1.0') }}"></script> --}}
<script src="{{ asset('websiteAsset/js/tools.js?v=1.0') }}"></script>
<script src="{{ asset('websiteAsset/js/main.js') }}"></script>

<script src="https://giftrz.net/assets/js/swiper-bundle.min.js"></script>
@if (Session::has('success_message'))
    <script>
        toastr.success('{{ Session::get('success_message') }}');
    </script>
@endif

@if (Session::has('error_message'))
    <script>
        toastr.error('{{ Session::get('error_message') }}');
    </script>
@endif
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>

    $(document).ready(function() {
        $('.addToCartForm').submit(function(event) {
            event.preventDefault(); // Prevent form submission
            var formData = $(this).serialize(); // Serialize form data
            $.ajax({
                url: "{{ route('cart.addToCart') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    // Handle success response
                    if (response.status) {
                        console.log(response);

                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        // Redirect to login route if status is 401
                        window.location.href = "{{ route('user.login') }}";
                    } else {
                        // Handle other error responses
                        toastr.error(error);
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        function updateCartCount() {
            $.ajax({
                url: '{{ route('cart.count') }}',
                type: 'GET',
                success: function(data) {
                    if (data.count !== undefined) {
                        $('.cart-badge').text(data.count);
                    }
                }
            });
        }
        updateCartCount();
        setInterval(updateCartCount, 2000); // Update every 5 seconds
    });
</script>

@yield('scripts')
