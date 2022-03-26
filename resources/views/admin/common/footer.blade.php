<!-- Jquery Core Js -->
<script src="{{ url('admin-assets/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{ url('admin-assets/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->

<script src="{{ url('admin-assets/bundles/jvectormap.bundle.js')}}"></script> <!-- JVectorMap Plugin Js -->
<script src="{{ url('admin-assets/bundles/morrisscripts.bundle.js')}}"></script><!-- Morris Plugin Js -->
<script src="{{ url('admin-assets/bundles/sparkline.bundle.js')}}"></script> <!-- Sparkline Plugin Js -->
<script src="{{ url('admin-assets/bundles/knob.bundle.js')}}"></script> <!-- Jquery Knob Plugin Js -->

<script src="{{ url('admin-assets/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{ url('admin-assets/js/pages/index.js')}}"></script>
<script src="{{ url('admin-assets/js/pages/charts/jquery-knob.min.js')}}"></script>

<!-- Jquery DataTable Plugin Js -->
<script src="{{ url('admin-assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{ url('admin-assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{ url('admin-assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ url('admin-assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{ url('admin-assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{ url('admin-assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{ url('admin-assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{ url('admin-assets/js/jquery.validate.min.js') }}"></script>

<script src="{{ url('admin-assets/plugins/sweetalert/sweetalert.min.js')}}"></script>

<script src="{{ url('admin-assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{ url('admin-assets/js/custom_validate.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //override required method
    // $.validator.methods.required = function(value, element, param) {

    //     return (value == undefined) ? false : (value.trim() != '');
    // }

    // for alert message disppper after 3 sec
    $(document).ready(function() {

        setTimeout(function() {
            $('.alertdisapper').fadeOut();
        }, 4000);

    });

    $(".blank_link").click(function(event) {
        event.preventDefault();

    });







    var url = $('meta[name="baseUrl"]').attr('content');

    //For delete
    $(document).on("click", '.btnDelete', function(event) {

        event.preventDefault();
        var title = $(this).data('title');
        var url = $(this).data('url');
        var form = '';
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this " + title,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
        }, function(result) {
            if (result) {
                form = $('#deleteForm');
                form.attr('action', url);
                form.submit();
            }
        });
    });


    // For update status
    $(document).on("click", '.btnChangeStatus', function(event) {

        event.preventDefault();
        var url = $(this).data('url');

        swal({
            title: "Are you sure?",
            text: "",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Change it!",
        }, function(value) {
            if (value) {
                form = $('#changeStatusForm');
                form.attr('action', url);
                form.submit();
            } else {

            }
        });
    });

    // For update status
    $(document).on("click", '.btnChangeApproval', function(event) {

        event.preventDefault();
        var url = $(this).data('url');

        swal({
            title: "Are you sure?",
            text: "You want to change approval status?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Change it!",
        }, function(value) {
            if (value) {
                form = $('#changeStatusForm');
                form.attr('action', url);
                form.submit();
            }

        });
    });


    // for alert message disppper after 3 sec
    $(document).ready(function() {
        setTimeout(function() {
            $('.alertdisapper').fadeOut();
        }, 4000);
    });

    var url = $('meta[name="baseUrl"]').attr('content');

</script>
@yield('js')