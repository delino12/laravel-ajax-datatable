<!DOCTYPE html>
<html lang="en">
<head>
    <title>Table V01</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    {{-- DataTable CSS --}}
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>
<body>

    <div class="container">
        <div class="row pt-4">
            <div class="col-md-12">
                <h2 class="text-center">
                    Transactions List
                </h2>
                <table id="transactions-table" class="table">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Ref Id</th>
                            <th>Date</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody class="load-transactions"></tbody>
                </table>
            </div>
        </div>
    </div>
    

    <!--===============================================================================================-->  
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.32.2/dist/sweetalert2.all.min.js"></script>
    {{-- DataTable Js --}}
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        // load modules
        loadTransactionData();

        // load transaction data
        function loadTransactionData() {
            $.get('{{ url('load/transactions/data') }}', function(data) {
                // apply dataTable using table ID
                $("#transactions-table").DataTable().destroy();

                $(".load-transactions").html(""); // empty the table row cols if atleast one data is found
                var sn = 0; // start a serial number count
                $.each(data, function(index, val) {
                    sn++;
                    // build a new rows and cols using ES6^ template string
                    $(".load-transactions").append(`
                        <tr>
                            <td>${sn}</td>
                            <td>${val.name}</td>
                            <td>${val.email}</td>
                            <td>${val.description}</td>
                            <td>&#8358;${val.amount}</td>
                            <td>${val.trans_ref}</td>
                            <td>${val.date}</td>
                            <td>
                                <a href="javascript:void(0);" onclick="deleteRecord(${val.id})">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    `);
                });

                // apply dataTable using table ID
                $("#transactions-table").DataTable();
            });
        }

        // delete a record
        function deleteRecord(trans_id) {
            var token = '{{ csrf_token() }}';
            var params = {
                _token: token,
                transid: trans_id
            };

            $.post('{{ url('delete/transaction/record') }}', params, function(data, textStatus, xhr) {
                if(data.status == "success"){
                    // refresh transaction data
                    loadTransactionData();

                    swal(
                        "Ok",
                        data.message,
                        data.status
                    );
                }else{
                    swal(
                        "oops",
                        data.message,
                        data.status
                    );
                }
            });
        }
    </script>
</body>
</html>