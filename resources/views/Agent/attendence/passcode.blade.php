@extends('Agent.common.app')
@section('main')
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Attendance</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Passcode</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <style>
                h2 {
                    font-family: helvetica;
                    text-align: center;
                }

                .pin-code {
                    padding: 0;
                    margin: 0 auto;
                    display: flex;
                    justify-content: center;

                }

                .pin-code input {
                    border: none;
                    text-align: center;
                    width: 48px;
                    height: 48px;
                    font-size: 36px;
                    background-color: #85ff9f;
                    margin-right: 5px;
                }




                .pin-code input:focus {
                    border: 1px solid #573D8B;
                    outline: none;
                }


                input::-webkit-outer-spin-button,
                input::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                .code {
    position: fixed;
    top: 50%;
    left:50%;
    transform: translateY(-50%);
    /* Other styles */
}
            </style>

            <body>
                <!-- code START -->
                <div class="code">
                    @if (!empty($checkpasscode))
                        <h2>Enter Pin</h2>
                    @else
                        <h2>New Pin</h2>
                    @endif
                    <div class="pin-code">
                        <input type="password" maxlength="1" id="input1" autofocus>
                        <input type="password" maxlength="1" id="input2">
                        <input type="password" maxlength="1" id="input3">
                        <input type="password" maxlength="1" id="input4">
                        
                    </div>
                    <p style="color: red;text-align:center;margin-top:10px;" id="showerror"></p>
                    
                </div>
                <script src="https://www.cssscript.com/demo/split-text-string-individual-characters-charming-js/index.js"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    //var pinContainer = document.getElementsByClassName("pin-code")[0];
                    var pinContainer = document.querySelector(".pin-code");
                    console.log('There is ' + pinContainer.length + ' Pin Container on the page.');

                    pinContainer.addEventListener('keyup', function(event) {
                        var target = event.srcElement;

                        var maxLength = parseInt(target.attributes["maxlength"].value, 10);
                        var myLength = target.value.length;

                        if (myLength >= maxLength) {
                            var next = target;
                            while (next = next.nextElementSibling) {
                                if (next == null) break;
                                if (next.tagName.toLowerCase() == "input") {
                                    next.focus();
                                    break;
                                }
                            }
                        }

                        if (myLength === 0) {
                            var next = target;
                            while (next = next.previousElementSibling) {
                                if (next == null) break;
                                if (next.tagName.toLowerCase() == "input") {
                                    next.focus();
                                    break;
                                }
                            }
                        }
                    }, false);

                    pinContainer.addEventListener('keydown', function(event) {
                        var target = event.srcElement;
                        target.value = "";
                    }, false);
                </script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        var passCodeStoreRoute = "{{ route('passcodestore') }}";
                        var AttendenceRoute = "{{ route('attendence') }}";
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var input1, input2, input3, input4;

                        $('#input1').keyup(function() {
                            input1 = $(this).val();

                        });

                        $('#input2').keyup(function() {
                            input2 = $(this).val();

                        });

                        $('#input3').keyup(function() {
                            input3 = $(this).val();

                        });

                        $('#input4').keyup(function() {
                            input4 = $(this).val();
                            sendAjaxRequest();
                        });

                        function sendAjaxRequest() {
                            $.ajax({
                                url: passCodeStoreRoute,
                                method: 'POST',
                                headers: {
                                    'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                                },
                                data: {
                                    input1: input1,
                                    input2: input2,
                                    input3: input3,
                                    input4: input4,
                                    _token: csrfToken
                                },
                                success: function(response) {
                                    if (response.status == false) {
                                        $('#showerror').text(response.message).css('color', 'red');
                                    } else {
                                      window.location.href = AttendenceRoute;
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('AJAX request failed with status:', status);
                                    // Handle error here if needed
                                }
                            });
                        }
                    });
                </script>
        </div>
    </div>
    <!--end page wrapper --
@endsection
