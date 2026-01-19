<!-- Table JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>-->
<!--<script scr="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>-->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>



<script>
    // Table JS
    // $(document).ready(function() {
    //  var table=   $("#example").DataTable({
    //         aaSorting: [],
    //         responsive: true,
    //         buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
    //         columnDefs: [{
    //                 responsivePriority: 1,
    //                 targets: 0
    //             },
    //             // {
    //             //     responsivePriority: 2,
    //             //     targets: -1
    //             // }
    //         ]
    //     });
    //     table.buttons().container()
    //     .appendTo( '#example_wrapper .col-md-6:eq(0)' );

    //     $(".dataTables_filter input").attr("placeholder", "Search here...").css({
    //         width: "300px",
    //         display: "inline-block"
    //     });

    //     $('[data-toggle="tooltip"]').tooltip();
    // });
    $(document).ready(function() {
         var isAdminAgent = "{{auth()->user()->role}}";
    var table = $('#example').DataTable( {
        lengthChange: true,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
     if (isAdminAgent=='0') {
        table.buttons().container()
            .css('margin-top', '20px')
            .appendTo('#example_wrapper .col-md-6:eq(0)');
    }
} );
    // Table JS

    // Nav Start
    // ---------Responsive-navbar-active-animation-----------
    function test() {
        var tabsNewAnim = $("#navbarSupportedContent");
        var selectorNewAnim = $("#navbarSupportedContent").find("li").length;
        var activeItemNewAnim = tabsNewAnim.find(".active");
        var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
        var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
        var itemPosNewAnimTop = activeItemNewAnim.position();
        var itemPosNewAnimLeft = activeItemNewAnim.position();
        $(".hori-selector").css({
            top: itemPosNewAnimTop.top + "px",
            left: itemPosNewAnimLeft.left + "px",
            height: activeWidthNewAnimHeight + "px",
            width: activeWidthNewAnimWidth + "px"
        });
        $("#navbarSupportedContent").on("click", "li", function(e) {
            $("#navbarSupportedContent ul li").removeClass("active");
            $(this).addClass("active");
            var activeWidthNewAnimHeight = $(this).innerHeight();
            var activeWidthNewAnimWidth = $(this).innerWidth();
            var itemPosNewAnimTop = $(this).position();
            var itemPosNewAnimLeft = $(this).position();
            $(".hori-selector").css({
                top: itemPosNewAnimTop.top + "px",
                left: itemPosNewAnimLeft.left + "px",
                height: activeWidthNewAnimHeight + "px",
                width: activeWidthNewAnimWidth + "px"
            });
        });
    }
    $(document).ready(function() {
        setTimeout(function() {
            test();
        });
    });
    $(window).on("resize", function() {
        setTimeout(function() {
            test();
        }, 500);
    });
    $(".navbar-toggler").click(function() {
        $(".navbar-collapse").slideToggle(300);
        setTimeout(function() {
            test();
        });
    });

    // --------------add active class-on another-page move----------
    jQuery(document).ready(function($) {
        // Get current path and find target link
        var path = window.location.pathname.split("/").pop();

        // Account for home page with empty path
        if (path == "") {
            path = "index.html";
        }

        var target = $('#navbarSupportedContent ul li a[href="' + path + '"]');
        // Add active class to target link
        target.parent().addClass("active");
    });

    // Add active class on another page linked
    // ==========================================
    // $(window).on('load',function () {
    //     var current = location.pathname;
    //     console.log(current);
    //     $('#navbarSupportedContent ul li a').each(function(){
    //         var $this = $(this);
    //         // if the current path is like this link, make it active
    //         if($this.attr('href').indexOf(current) !== -1){
    //             $this.parent().addClass('active');
    //             $this.parents('.menu-submenu').addClass('show-dropdown');
    //             $this.parents('.menu-submenu').parent().addClass('active');
    //         }else{
    //             $this.parent().removeClass('active');
    //         }
    //     })
    // });

    // Nav End
</script>

<script>
    $(document).ready(function() {
        $('.data-select').on('click', function() {
            var dataId = $(this).data('id');

            // Make an AJAX request to fetch data based on the data ID
            $.ajax({
                url: '/get/masterfile/data/' + dataId, // Replace with your actual API endpoint
                type: 'GET',
                success: function(data) {
                    // Update modal content with fetched data
                    updateModal(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function updateModal(data) {
            // Check if data is defined
            if (!data) {
                console.error('Data is undefined');
                return;
            }

            // Update modal content with the fetched data 
            $('#data_id').val(data.id);
            $('#company_name').val(data.company_name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#company_rep1').val(data.company_rep1);
            $('#business_address').val(data.business_address);
            $('#business_city').val(data.business_city);
            $('#business_state').val(data.business_state);
            $('#business_zip').val(data.business_zip);
            $('#dot').val(data.dot);
            $('#mc_docket').val(data.mc_docket);

            // Set the selected option for form_status and unit_owned
            $('#form_status').val(data.form_status).prop('selected', true);
            $('#reminder').val(data.reminder);

            $('#unit_owned').val(data.unit_owned).prop('selected', true);
            // Open
            var value = data.unit_owned;
            if (value == '2') {
                $('.unit2').show();
                $('.unit3').hide();
                $('.unit4').hide();
                $('.unit5').hide();
            } else if (value == '3') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').hide();
                $('.unit5').hide();
            } else if (value == '4') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').show();
                $('.unit5').hide();
            } else if (value == '5') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').show();
                $('.unit5').show();
            } else if (value == '1') {
                $('.unit2').hide();
                $('.unit3').hide();
                $('.unit4').hide();
                $('.unit5').hide();
            }
            // Close

            $('#vin').val(data.vin);
            $('#driver_name').val(data.driver_name);
            $('#driver_dob').val(data.driver_dob);
            $('#driver_license').val(data.driver_license);
            $('#driver_license_state').val(data.driver_license_state);
            $('#vehicle_year').val(data.vehicle_year);
            $('#vehicle_make').val(data.vehicle_make);
            $('#stated_value').val(data.stated_value);
            // 2
            $('#vin2').val(data.vin2);
            $('#driver_name2').val(data.driver_name2);
            $('#driver_dob2').val(data.driver_dob2);
            $('#driver_license2').val(data.driver_license2);
            $('#driver_license_state2').val(data.driver_license_state2);
            $('#vehicle_year2').val(data.vehicle_year2);
            $('#vehicle_make2').val(data.vehicle_make2);
            $('#stated_value2').val(data.stated_value2);
            // 3
            $('#vin3').val(data.vin3);
            $('#driver_name3').val(data.driver_name3);
            $('#driver_dob3').val(data.driver_dob3);
            $('#driver_license3').val(data.driver_license3);
            $('#driver_license_state3').val(data.driver_license_state3);
            $('#vehicle_year3').val(data.vehicle_year3);
            $('#vehicle_make3').val(data.vehicle_make3);
            $('#stated_value3').val(data.stated_value3);
            // 4
            $('#vin4').val(data.vin4);
            $('#driver_name4').val(data.driver_name4);
            $('#driver_dob4').val(data.driver_dob4);
            $('#driver_license4').val(data.driver_license4);
            $('#driver_license_state4').val(data.driver_license_state4);
            $('#vehicle_year4').val(data.vehicle_year4);
            $('#vehicle_make4').val(data.vehicle_make4);
            $('#stated_value4').val(data.stated_value4);
            // 5
            $('#vin5').val(data.vin5);
            $('#driver_name5').val(data.driver_name5);
            $('#driver_dob5').val(data.driver_dob5);
            $('#driver_license5').val(data.driver_license5);
            $('#driver_license_state5').val(data.driver_license_state5);
            $('#vehicle_year5').val(data.vehicle_year5);
            $('#vehicle_make5').val(data.vehicle_make5);
            $('#stated_value5').val(data.stated_value5);

            $('#comment').val(data.comment);

            $('#progress-bar').removeClass('bg-success bg-warning bg-info bg-danger').addClass(
                getProgressBarClass(data.form_status));
            $('#progress-bar').css('width', data.form_status_value + '%');
            $('#model-form-status').text(data.form_status);
            // ... update other fields ...

            // Show the modal
            $('#leaddata').modal('show');
        }

        function getProgressBarClass(formStatus) {
            switch (formStatus) {
                case 'Intrested':
                    return 'bg-success';
                case 'Pipeline':
                    return 'bg-warning';
                case 'NEW':
                    return 'bg-info';
                default:
                    return 'bg-danger';
            }
        }

        $('#form_status').on('change', function() {
            var status = $(this).val();
            if (status == 'Intrested') { // Corrected 'Intrested' to 'Interested'
                $('#company_name').prop('required', true);
                $('#phone').prop('required', true);
                $('#company_rep1').prop('required', true);
                $('#business_address').prop('required', true);
                $('#business_city').prop('required', true);
                $('#business_state').prop('required', true);
                $('#business_zip').prop('required', true);
                $('#dot').prop('required', true);
                $('#mc_docket').prop('required', true);
                $('#unit_owned').prop('required', true);
                $('#vin').prop('required', true);
                $('#driver_name').prop('required', true);
                $('#driver_dob').prop('required', true);
                $('#driver_license').prop('required', true);
                $('#driver_license_state').prop('required', true);
            } else if (status == 'Pipeline') {
                $('#company_name').prop('required', false);
                $('#phone').prop('required', false);
                $('#company_rep1').prop('required', false);
                $('#business_address').prop('required', false);
                $('#business_city').prop('required', false);
                $('#business_state').prop('required', false);
                $('#business_zip').prop('required', false);
                $('#dot').prop('required', false);
                $('#mc_docket').prop('required', false);
                $('#unit_owned').prop('required', false);
                $('#vin').prop('required', false);
                $('#driver_name').prop('required', false);
                $('#driver_dob').prop('required', false);
                $('#driver_license').prop('required', false);
                $('#driver_license_state').prop('required', false);
            }
        });

        // Single Lead Form
        $('#form_status_single').on('change', function() {
            var status = $(this).val();
            if (status == 'Intrested') { // Corrected 'Intrested' to 'Interested'
                $('#company_name_single').prop('required', true);
                $('#phone_single').prop('required', true);
                $('#company_rep_single1').prop('required', true);
                $('#business_address_single').prop('required', true);
                $('#business_city_single').prop('required', true);
                $('#business_state_single').prop('required', true);
                $('#business_zip_single').prop('required', true);
                $('#dot_single').prop('required', true);
                $('#mc_docket_single').prop('required', true);
                $('#unit_owned_single').prop('required', true);
                $('#vin_single').prop('required', true);
                $('#driver_name_single').prop('required', true);
                $('#driver_dob_single').prop('required', true);
                $('#driver_license_single').prop('required', true);
                $('#driver_license_state_single').prop('required', true);
            } else if (status == 'Pipeline') {
                $('#company_name_single').prop('required', false);
                $('#phone_single').prop('required', false);
                $('#company_rep_single1').prop('required', false);
                $('#business_address_single').prop('required', false);
                $('#business_city_single').prop('required', false);
                $('#business_state_single').prop('required', false);
                $('#business_zip_single').prop('required', false);
                $('#dot_single').prop('required', false);
                $('#mc_docket_single').prop('required', false);
                $('#unit_owned_single').prop('required', false);
                $('#vin_single').prop('required', false);
                $('#driver_name_single').prop('required', false);
                $('#driver_dob_single').prop('required', false);
                $('#driver_license_single').prop('required', false);
                $('#driver_license_state_single').prop('required', false);
            }
        });
    });
</script>
{{-- /Leads Data Get --}}

<script>
    $(document).ready(function() {
        $('.unit2').hide();
        $('.unit3').hide();
        $('.unit4').hide();
        $('.unit5').hide();
        $('#unit_owned').on('change', function() {
            var value = $(this).val();
            if (value == '2') {
                $('.unit2').show();
                $('.unit3').hide();
                $('.unit4').hide();
                $('.unit5').hide();
            } else if (value == '3') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').hide();
                $('.unit5').hide();
            } else if (value == '4') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').show();
                $('.unit5').hide();
            } else if (value == '5') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').show();
                $('.unit5').show();
            } else if (value == '1') {
                $('.unit2').hide();
                $('.unit3').hide();
                $('.unit4').hide();
                $('.unit5').hide();
            }
        });
    });
    // Single Lead Form
    $(document).ready(function() {
        $('.unitsingle2').hide();
        $('.unitsingle3').hide();
        $('.unitsingle4').hide();
        $('.unitsingle5').hide();
        $('#unit_owned_single').on('change', function() {
            var value = $(this).val();
            if (value == '2') {
                $('.unitsingle2').show();
                $('.unitsingle3').hide();
                $('.unitsingle4').hide();
                $('.unitsingle5').hide();
            } else if (value == '3') {
                $('.unitsingle2').show();
                $('.unitsingle3').show();
                $('.unitsingle4').hide();
                $('.unitsingle5').hide();
            } else if (value == '4') {
                $('.unitsingle2').show();
                $('.unitsingle3').show();
                $('.unitsingle4').show();
                $('.unitsingle5').hide();
            } else if (value == '5') {
                $('.unitsingle2').show();
                $('.unitsingle3').show();
                $('.unitsingle4').show();
                $('.unitsingle5').show();
            } else if (value == '1') {
                $('.unitsingle2').hide();
                $('.unitsingle3').hide();
                $('.unitsingle4').hide();
                $('.unitsingle5').hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#form_status').on('click', function() {
            var val = $(this).val();
            if (val == 'Pipeline') {
                $('.reminder').show();
            } else {
                $('.reminder').hide();
            }
        });
    });
</script>