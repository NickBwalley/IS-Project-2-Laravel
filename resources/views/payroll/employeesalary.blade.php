
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
                        <h3 class="page-title">Remuneration Pay <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Add Remuneration Pay</a>
                        {{-- <button id="downloadPdfButton" class="btn btn-primary">Download PDF</button> --}}
                    </div>
                </div>
            </div>

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
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Invoice Number</th>
                                    <th>KGS Harvested</th>
                                    <th>Shilling per KG</th>
                                    <th>Total Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            @php
                                // Sort the $users array by created_at in descending order
                                $sortedUsers = $users->sortByDesc('created_at');
                            @endphp

                            <tbody>
                                @if ($sortedUsers->isEmpty())
                                    <tr>
                                        <td colspan="8" style="text-align: center;">No records available.</td>
                                    </tr>
                                @else
                                    @foreach ($sortedUsers as $items)
                                        @if ($items->status === 'pending')
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="{{ url('employee/profile/'.$items->user_id) }}" class="avatar"><img alt="" src="{{ URL::to('/assets/images/'. $items->avatar) }}"></a>
                                                        <a href="{{ url('employee/profile/'.$items->user_id) }}">{{ $items->name }}</a>
                                                    </h2>
                                                </td>
                                                <td>{{ $items->invoice_number }}</td>
                                                <td>{{ $items->number_of_kgs_harvested }}</td>
                                                <td>{{ $items->shillings_per_kg }}</td>
                                                <td><strong><span class="btn btn-info">KSH {{ $items->estimated_payout }}</span></strong></td>
                                                <td>{{ $items->created_at }}</td>
                                                <td><span class="btn btn-secondary">{{ $items->status }}</span></td>
                                                <!-- DELETE FUNCTIONALITY -->
                                                <td>
                                                    <a class="#" href="#" data-toggle="modal" data-target="#delete_salary" data-id="{{ $items->invoice_number }}">
                                                        <span class="btn btn-danger">Delete</span>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endif
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
        <label for="name">Employee Names</label>
        <select class="form-control select2s-hidden-accessible @error('name') is-invalid @enderror" id="name" name="name">
            <option value="">-- Select --</option>
            @foreach ($userList as $key => $user)
                @if (isset($user->status) && $user->status === 'Active')
                    <option value="{{ $user->name }}" data-employee_id="{{ $user->user_id }}" data-phone_number="{{ $user->phone_number }}">{{ $user->name }}</option>
                @endif
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
        

        <!-- /Edit Salary Modal -->
        
        <!-- Delete Salary Modal -->
        <div class="modal custom-modal fade" id="delete_salary" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Remuneration Pay</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('form/salary/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="invoice_number" id="e_invoice_number" value="">
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

    <!-- Include jQuery once -->
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
            var invoice_number = $(this).data('invoice_number');
            var phone_number = $(this).data('phone_number');
            var number_of_kgs_harvested = $(this).data('number_of_kgs_harvested');
            var shillings_per_kg = $(this).data('shillings_per_kg');
            var estimated_payout = $(this).data('estimated_payout');

            $('#e_id').val(id);
            $('#e_name').val(name);
            $('#e_employee_id_auto').val(employee_id_auto);
            $('#e_invoice_number').val(invoice_number);
            $('#e_phone_number').val(phone_number);
            $('#e_number_of_kgs_harvested').val(number_of_kgs_harvested);
            $('#e_shillings_per_kg').val(shillings_per_kg);
            $('#e_estimated_payout').val(estimated_payout);
        });

    });
</script>

<script>
    $(document).ready(function() {
        $('#delete_salary').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var invoice_number = button.data('id'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#e_invoice_number').val(invoice_number);
        });
    });
</script>



<script>
    document.getElementById('downloadPdfButton').addEventListener('click', function () {
        // Initialize jsPDF
        var doc = new jsPDF();

        // Add a title to the PDF
        doc.text('Employee Records', 10, 10);

        // Get the table as HTML
        var table = document.querySelector('.table');

        // Use html2canvas library to convert the table to an image
        html2canvas(table).then(function (canvas) {
            // Convert the canvas to a data URL
            var imgData = canvas.toDataURL('image/png');

            // Add the image to the PDF
            doc.addImage(imgData, 'PNG', 10, 20);

            // Save the PDF
            doc.save('employee_records.pdf');
        });
    });
</script>






    @endsection
@endsection
