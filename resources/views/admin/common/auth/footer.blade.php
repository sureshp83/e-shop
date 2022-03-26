
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ url('admin-assets/plugins/jquery/jquery-v3.2.1.min.js') }}"></script>    
<script src="{{ url('admin-assets/bundles/libscripts.bundle.js') }}"></script>    
<script src="{{ url('admin-assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ url('admin-assets/bundles/mainscripts.bundle.js') }}"></script><!--Custom JavaScript -->
<script src="{{ url('admin-assets/js/jquery.validate.min.js') }}"></script> 
@yield('js')

<script type="text/javascript">
    $(function() {
        $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    // for alert message disppper after 3 sec
    $(document).ready(function(){
        setTimeout(function(){$('.alertdisapper').fadeOut();}, 4000);
    });
</script>