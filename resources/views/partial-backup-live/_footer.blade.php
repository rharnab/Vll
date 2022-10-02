<script src="{{ asset('public/backend/assets/js/vendors.bundle.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/app.bundle.js') }}"></script>
<!-- jQuery Validator Js -->

<script src="{{ asset('public/backend/assets/js/formplugins/validator/validate.min.js') }}"></script>

<script src="{{ asset('public/backend/assets/cute-alert/cute-alert.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/formplugins/select2/select2.bundle.js') }}"></script>

<script src="{{ asset('public/backend/assets/js/notifications/toastr/toastr.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.js"></script>

<script type="text/javascript">
    /* Activate smart panels */
    $('#js-page-content').smartPanel();
</script>

<script src="{{ asset('public/backend/assets/js/custom.js') }}"></script>




@stack('js')







<script type="text/javascript">
  $(document).ready(function() {
      $('.select2').select2();
  })
</script>



