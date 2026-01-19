<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Master | File</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <!-- App favicon -->
    <link href="{{ asset('assets/images/favlogo.png') }}" rel="icon" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body {
            margin: 2em;
        }

        .table-bordered.card {
            border: 0 !important;
        }

        .card thead {
            display: none;
        }

        .card tbody tr {
            float: left;
            width: 25em;
            margin: 0.5em;
            border: 1px solid #bfbfbf;
            border-radius: 0.5em;
            background-color: transparent !important;
            box-shadow: 0.25rem 0.25rem 0.5rem rgba(0, 0, 0, 0.25);
        }

        .card tbody tr td {
            display: block;
            border: 0;
        }

        p {
            text-align: center;
            color: rgb(50, 117, 205);
            font-size: 50px;
            font-weight: bold;
            text-shadow: 1px 1px 2px #000;
            margin-bottom: 1.2em;
        }

        .bg-danger {
            background: red !important;
            color: white;
            font-weight: bold;
        }

        .bg-warning {
            background: rgb(0, 110, 255) !important;
            color: white;
            font-weight: bold;
        }

        .bg-success {
            background: green !important;
            color: white;
            font-weight: bold;
        }

        .select-container {
            position: relative;
            margin: 0 auto;
            width: 200px;
        }

        .select-container .select {
            position: relative;
            background: white;
            border: 1px solid;
            height: 30px;
        }

        .select-container .select::after {
            position: absolute;
            content: "";
            width: 10px;
            height: 10px;
            top: 50%;
            right: 15px;
            transform: translateY(-50%) rotate(45deg);
            border-bottom: 2px solid black;
            border-right: 2px solid black;
            cursor: pointer;
            transition: border-color 0.4s;
        }

        .select-container.active .select::after {
            border: none;
            border-left: 2px solid white;
            border-top: 2px solid white;
        }

        .select-container .select input {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 0 15px;
            background: none;
            outline: none;
            border: none;
            font-size: 1.4rem;
            color: black;
            cursor: pointer;
        }

        .select-container .option-container {
            position: relative;
            background: #white;
            height: 0;
            overflow-y: scroll;
            transition: 0.4s;
        }

        .select-container.active .option-container {
            height: 240px;
        }

        .select-container .option-container::-webkit-scrollbar {
            border-left: 1px solid rgba(0, 0, 0, 0.2);
            width: 10px;
        }

        .select-container .option-container::-webkit-scrollbar-thumb {
            background: #0f0e11;
        }

        .select-container .option-container .option {
            position: relative;
            padding-left: 15px;
            height: 40px;
            border-top: 1px solid rgba(0, 0, 0, 0.3);
            border-left: 1px solid rgba(0, 0, 0, 0.3);
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: 0.2s;
        }

        .select-container .option-container .option.selected {
            background: rgba(0, 0, 0, 0.5);
            pointer-events: none;
        }

        .select-container .option-container .option:hover {
            background: rgba(0, 0, 0, 0.2);
            padding-left: 20px;
        }

        .select-container .option-container .option a {
            font-size: 1.1rem;
            color: black;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <p>Master File</p>
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Status</th>
                <th>Date</th>
                <th>Company_Name</th>
                <th>Phone</th>
                <th>Company_Rep1</th>
                <th>Business_Address</th>
                <th>Business_City</th>
                <th>Business_State</th>
                <th>Business_ZIP</th>
                <th>DOT</th>
                <th>Mc/Docket</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($datas as $data)
                <tr class=" @if($data->form_status=='DND') bg-warning text-white @endif"">
                    <td>
                        @php
                            echo $i;
                            $i++;
                        @endphp
                    </td>
                    <td>
                        @php
                            if (auth()->user()->designation == 'Manager') {
                                $user = App\Models\User::find($data->rel_id);
                            } else {
                                $user = App\Models\User::find($data->click_id);
                            }

                        @endphp

                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $data->form_status }}
                        <div class="select-container">
                            <div class="select">
                                <input type="text" class="input" placeholder="select" onfocus="this.blur();">
                            </div>
                            <div class="option-container">
                                <div class="option">
                                    <a
                                        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Intrested'), ($form_status_value = '100')]) }}">Intrested
                                    </a>
                                </div>
                                <div class="option">
                                    <a
                                        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Pipeline'), ($form_status_value = '50')]) }}">Pipeline
                                    </a>
                                </div>
                                <div class="option">
                                    <a
                                        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Voice Mail'), ($form_status_value = '100')]) }}">Voice
                                        Mail</a>
                                </div>
                                <div class="option">
                                    <a
                                        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Not Intrested'), ($form_status_value = '100')]) }}">Not
                                        Intrested</a>
                                </div>
                                <div class="option">
                                    <a
                                        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Not Connected'), ($form_status_value = '100')]) }}">Not
                                        Connected</a>
                                </div>
                                <div class="option">
                                    <a
                                        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Wrong Number'), ($form_status_value = '100')]) }}">Wrong
                                        Number</a>
                                </div>
                                <div class="option">
                                    <a
                                        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Insured'), ($form_status_value = '100')]) }}">Insured
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M, Y') }}</td>
                    <td>{{ $data->company_name }}</td>
                    <td>{{ $data->phone }}</td>
                    <td>{{ $data->company_rep1 }}</td>
                    <td>{{ $data->business_address }}</td>
                    <td>{{ $data->business_city }}</td>
                    <td>{{ $data->business_state }}</td>
                    <td>{{ $data->business_zip }}</td>
                    <td>{{ $data->dot }}</td>
                    <td>{{ $data->mc_docket }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>
    {{-- JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            // DataTable initialisation
            $("#example").DataTable({
                dom: '<"dt-buttons"Bf><"clear">lirtp',
                paging: true,
                autoWidth: true,
                buttons: [
                    "colvis",
                ],
                initComplete: function(settings, json) {
                    $(".dt-buttons .btn-group").append(
                        '<a id="cv" class="btn btn-primary" href="#">CARD VIEW</a>'
                    );
                    $("#cv").on("click", function() {
                        if ($("#example").hasClass("card")) {
                            $(".colHeader").remove();
                        } else {
                            var labels = [];
                            $("#example thead th").each(function() {
                                labels.push($(this).text());
                            });
                            $("#example tbody tr").each(function() {
                                $(this)
                                    .find("td")
                                    .each(function(column) {
                                        $("<span class='colHeader'>" + labels[
                                            column] + ":</span>").prependTo(
                                            $(this)
                                        );
                                    });
                            });
                        }
                        $("#example").toggleClass("card");
                    });
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
        var selectContainers = document.querySelectorAll(".select-container");

        selectContainers.forEach((container) => {
            var select = container.querySelector(".select");
            var input = container.querySelector(".input");
            var options = container.querySelectorAll(".option a");

            select.onclick = () => {
                container.classList.toggle("active");
            };

            options.forEach((option) => {
                option.addEventListener("click", (event) => {
                    input.value = option.innerText.trim();
                    container.classList.remove("active");
                    options.forEach((opt) => {
                        opt.classList.remove("selected");
                    });
                    option.classList.add("selected");
                });
            });
        });
    });
    </script>
    {{-- /JS --}}
</body>

</html>
