
@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Paid Transactions <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">PaidTransactions</li>
                        </ul>
                    </div>
                    {{-- <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Pay Employee</a>
                    </div> --}}
                </div>
            </div>
            

            <form action="{{ route('search/paid/list') }}" method="POST">
                @csrf
                <div class="row filter-row">
                    {{-- <div class="col-sm-6 col-md-3">
                        <label class="focus-label">From Date</label>
                        <div class="form-group form-focus">
                            <input type="date" class="form-control floating datepicker" id="from_date" name="from_date" placeholder="From Date">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label class="focus-label">To Date</label>
                        <div class="form-group form-focus">
                            <input type="date" class="form-control floating datepicker" id="to_date" name="to_date" placeholder="To Date">
                        </div>
                    </div> --}}
                    <div class="col-sm-6 col-md-3">
                        <label class="focus-label">Search By Name</label>
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="name" name="name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label class="focus-label">Search By Receipt Number</label>
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="receipt_number" name="receipt_number" placeholder="Enter Receipt Number">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label class="focus-label">Search By Date</label>
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="created_at" name="created_at" placeholder="Enter Date (yyyy-mm-dd)">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label class="focus-label">Search</label>
                        <button type="submit" class="btn btn-success btn-block">Search</button>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" onclick="printPDF()" data-toggle="modal" data-target="#print_report"><i class="fa fa-print"></i> PRINT REPORT</a>
                    </div>

                </div>
            </form>
            

            {{-- <!-- Search Filter -->
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus select-focus">
                        <select class="select floating"> 
                            <option value=""> -- Select -- </option>
                            <option value="">Employee</option>
                            <option value="1">Manager</option>
                        </select>
                        <label class="focus-label">Role</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12"> 
                    <div class="form-group form-focus select-focus">
                        <select class="select floating"> 
                            <option> -- Select -- </option>
                            <option> Pending </option>
                            <option> Approved </option>
                            <option> Rejected </option>
                        </select>
                        <label class="focus-label">Leave Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <a href="#" class="btn btn-success btn-block"> Search </a>  
                </div>     
            </div> --}}
            <!-- /Search Filter -->  

            {{-- ADD SALARY EMPLOYEE --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="reportTable" class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Receipt Number</th>
                                    <th>Received by</th>
                                    <th>Sent by</th>
                                    <th>Amount Paid</th>
                                    <th>Transaction Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No records available.</td>
                                    </tr>
                                @else
                                    @php
                                        // Sort the $users array by created_at in descending order
                                        $sortedUsers = $users->sortByDesc('created_at');
                                    @endphp

                                    @foreach ($sortedUsers as $items)
                                        <tr>
                                            <td>{{ $items->name }}</td>
                                            <td>{{ $items->receipt_number }}</td>
                                            <td>{{ $items->employee_mpesa_number }}</td>
                                            <td>{{ $items->senders_mpesa_number }}</td>
                                            <td><strong><span class="btn btn-success">KSH {{ $items->amount_paid }}</span></strong></td>
                                            <td>{{ $items->created_at }}</td>
                                            <td><strong><span class="btn btn-success">{{ $items->status }}</span></strong></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
        <!-- /Page Content -->

        <!-- Add Salary Modal -->

        <div id="add_salary" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Add Employee Salary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('form/salary/save') }}" method="POST">
                    @csrf
                    <div class="row"> 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Employee Name</label>
                               <select class="form-control select2s-hidden-accessible @error('name') is-invalid @enderror" id="name" name="name">
                                    <option value="">-- Select --</option>
                                    @foreach ($userList as $key => $user)
                                        <option value="{{ $user->name }}" data-employee_id="{{ $user->user_id }}" data-phone_number="{{ $user->phone_number }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6"> 
                            <label>Employee ID Auto</label>
                            <input class="form-control" type="text" name="employee_id_auto" id="employee_id_auto" readonly>
                        </div>

                        <div class="col-sm-6 offset-sm-6 text-right"> 
                            <label class="float-left">Phone Number Auto</label>
                            <input class="form-control" type="text" name="phone_number" id="phone_number" readonly>
                        </div>


                        


                    </div>
                    
                    <div class="row"> 
                        <div class="col-sm-6"> 
                            {{-- <h4 class="text-primary">Earnings</h4> --}}
                            <div class="form-group">
                                <label>Number of Kgs Harvested</label>
                                <input class="form-control @error('number_of_kgs_harvested') is-invalid @enderror" type="number" name="number_of_kgs_harvested" id="number_of_kgs_harvested" value="{{ old('number_of_kgs_harvested') }}" placeholder="Enter number of kgs harvested">
                                @error('number_of_kgs_harvested')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Shillings per Kg</label>
                                <input class="form-control @error('shillings_per_kg') is-invalid @enderror" type="number" name="shillings_per_kg" id="shillings_per_kg" value="{{ old('shillings_per_kg', 8) }}" placeholder="Enter shillings per kg">
                                @error('shillings_per_kg')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Estimated Payout</label>
                                <input class="form-control" type="text" name="estimated_payout" id="estimated_payout" readonly>
                            </div>
                        </div>
                       
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- /Add Salary Modal -->
        
        <!-- Edit Salary Modal -->
    <div id="edit_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('form/salary/update') }}" method="POST">
                    @csrf
                    {{-- <input class="form-control" type="text" name="id" id="e_id" value="" > --}}
                    <div class="row"> 
                        <div class="col-sm-6"> 
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input class="form-control" type="text" name="name" id="e_name" value="" >
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6"> 
                            <label>Employees M-Pesa Number</label>
                            <input class="form-control" type="text" name="employee_mpesa_number" id="e_phone_number" value="" >
                        </div>
                        <div class="col-sm-6"> 
                                <label>Employee ID </label>
                                <input class="form-control" type="text" name="employee_id_auto" id="e_employee_id_auto" value="" >
                        </div>
                        <div class="col-sm-6"> 
                                <label>Sender's M-Pesa Number </label>
                                <input class="form-control" type="text" name="senders_mpesa_number" id="sender_phone_number" value="" >
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-6"> 
                            
                            <div class="form-group">
                                <label>Number of Kgs Harvested</label>
                                <input class="form-control" type="text" name="number_of_kgs_harvested" id="e_number_of_kgs_harvested" value="" >
                            </div>
                            
                            <div class="form-group">
                                <label>Shillings per Kg</label>
                                <input class="form-control" type="text"  name="shillings_per_kg" id="e_shillings_per_kg" value="" >
                            </div>
                            <div class="form-group">
                                <label>Total Amount to Pay</label>
                                <input class="form-control" type="text"  name="amount_paid" id="e_estimated_payout" value="" >
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Confirm Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- /Edit Salary Modal -->
        
        <!-- Delete Salary Modal -->
        <div class="modal custom-modal fade" id="delete_salary" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Salary</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('form/salary/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Delete Salary Modal -->
     
    </div>
    <!-- /Page Wrapper -->
    @section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function () {
                // Populate Employee ID Auto and Phone Number in the "Add Salary" modal
                $('#name').change(function () {
                    var selectedOption = $(this).find('option:selected');
                    var employeeID = selectedOption.data('employee_id');
                    var phoneNumber = selectedOption.data('phone_number');
                    
                    $('#employee_id_auto').val(employeeID);
                    $('#phone_number').val(phoneNumber);
                });

                // Calculate Estimated Payout in real-time
                $('#number_of_kgs_harvested, #shillings_per_kg').on('input', function () {
                    var kgsHarvested = parseFloat($('#number_of_kgs_harvested').val()) || 0;
                    var shillingsPerKg = parseFloat($('#shillings_per_kg').val()) || 0;
                    var estimatedPayout = kgsHarvested * shillingsPerKg;
                    $('#estimated_payout').val(estimatedPayout.toFixed(2));
                });

                // Handle the click event for the "Pay" button in the "Edit Salary" modal
                $('.editSalary').click(function () {
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var employee_id_auto = $(this).data('employee_id_auto');
                    var phone_number = $(this).data('phone_number');
                    var number_of_kgs_harvested = $(this).data('number_of_kgs_harvested');
                    var shillings_per_kg = $(this).data('shillings_per_kg');
                    var estimated_payout = $(this).data('estimated_payout');

                    $('#e_id').val(id);
                    $('#e_name').val(name);
                    $('#e_employee_id_auto').val(employee_id_auto);
                    $('#e_phone_number').val(phone_number);
                    $('#e_number_of_kgs_harvested').val(number_of_kgs_harvested);
                    $('#e_shillings_per_kg').val(shillings_per_kg);
                    $('#e_estimated_payout').val(estimated_payout);
                });

                // Handle the click event for the "Delete" button in the "Delete Salary" modal
                $('.salaryDelete').click(function () {
                    var id = $(this).data('id');
                    $('.e_id').val(id); // Set the value of the hidden input field
                });
            });

            // CHANGE THE FORMAT FOR THE DATE PICKER FROM DD/MM/YYYY -> YYYY/MM/DD
            document.querySelector('form').addEventListener('submit', function() {
                // Get the date input elements
                var fromDateInput = document.getElementById('from_date');
                var toDateInput = document.getElementById('to_date');

                // Convert date values to 'yyyy-mm-dd' format
                var fromDateValue = fromDateInput.value.split('-').reverse().join('-');
                var toDateValue = toDateInput.value.split('-').reverse().join('-');

                // Update the input values
                fromDateInput.value = fromDateValue;
                toDateInput.value = toDateValue;
            });
            
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>

        <script>
            function printPDF() {
                var title = 'Paid Transactions Report';
                var dateTime = new Date().toLocaleString();
                var content = `
                    <h2>${title}</h2>
                    <p>Printed on: ${dateTime}</p>
                    ${document.getElementById('reportTable').outerHTML}
                    <p>PrintedBy: Acers Team</p>
                `;

                // Create a temporary container for the composite content
                var tempContainer = document.createElement('div');
                tempContainer.innerHTML = content;

                // Adjust font size and margins for better fitting on A4
                tempContainer.style.fontSize = '10px';
                tempContainer.style.margin = '2mm';

                // Use html2pdf to convert the composite content to a PDF
                html2pdf(tempContainer, {
                    margin: 10,
                    filename: 'knj_paid_transactions.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                });
            }
        </script>


    @endsection
@endsection
