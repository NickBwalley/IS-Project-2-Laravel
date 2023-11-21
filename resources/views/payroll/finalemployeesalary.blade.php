
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
                <div class="row align-item-center">
                    <div class="col">
                        <h3 class="page-title">Final Payout <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payout</li>
                        </ul>
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
                                    <th>Employee ID</th>
                                    
                                    <th>Total Remuneration Payout</th>
                                    <th>Advance Debt Balance</th>
                                    {{-- <th>Transaction Date</th> --}}
                                    <th>Status</th>
                                    @if (Auth::user()->role_name == 'Admin')
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($users as $item)
                                    @if ($item->status === 'pending')
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    {{-- <a href="{{ url('employee/profile/'.$item->user_id) }}" class="avatar"><img alt="" src="{{ URL::to('/assets/images/'. $item->avatar) }}"></a> --}}
                                                    <a href="">{{ $item->name }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $item->employee_id_auto }}</td>

                                            <?php
                                            $totalAdvanceAmount = DB::table('staff_salaries_advance')
                                                ->where('employee_id_auto', $item->employee_id_auto)
                                                ->where('status', 'unpaid')
                                                ->sum('advance_amount');

                                            $estimatedPayout = DB::table('staff_salaries')
                                                ->where('employee_id_auto', $item->employee_id_auto)
                                                ->where('status', 'pending')
                                                ->sum('estimated_payout');
                                            ?>

                                            <td><strong><span class="btn btn-info">KSH {{ $estimatedPayout }}</span></strong></td>
                                            <td><strong><span class="btn btn-warning">KSH {{ $totalAdvanceAmount }}</span></strong></td>
                                            {{-- <td>{{ $item->created_at }}</td> --}}
                                            <td><span class="btn btn-secondary">{{ $item->status }}</span></td>
                                            @if (Auth::user()->role_name == 'Admin')
                                            <td >
                                                <div class="dropdown dropdown-action">
                                                    @if ($totalAdvanceAmount > $estimatedPayout)
                                                            <span class="btn btn-danger">Arrears of: KSH {{ $totalAdvanceAmount - $estimatedPayout }}</span>
                                                    @else
                                                            <div class="dropdown dropdown-action">
                                                                @if ($totalAdvanceAmount <= $estimatedPayout)
                                                                    <a href="#" class="action-icon dropdown-toggle editSalary" data-toggle="modal" data-target="#edit_salary"
                                                                        
                                                                        data-name="{{ $item->name }}"
                                                                        data-phone_number="{{ $item->phone_number }}"
                                                                        data-employee_id_auto="{{ $item->employee_id_auto }}"
                                                                        data-estimated_payout="{{ $estimatedPayout - $totalAdvanceAmount }}"
                                                                        
                                                                    ><span style="width: 150px;" class="btn btn-outline-success">Proceed to Pay</span></a>
                                                                    {{-- <a class="#" href="#" data-toggle="modal" data-target="#delete_salary" ><span class="btn btn-outline-danger">Delete</span></a> --}}
                                                                @endif
                                                            </div>
                                                    @endif

                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>



                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->
        
        <!-- Edit Salary Modal -->
    <div id="edit_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Final Payout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('lipa-na-mpesa') }}" method="GET">
                    @csrf
                    {{-- <input class="form-control" type="text" name="id" id="e_id" value="" > --}}
                    <div class="row"> 
                        <div class="col-sm-6"> 
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input class="form-control" type="text" name="name" id="e_name" value="" readonly>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6"> 
                            <label>Employee ID </label>
                            <input class="form-control" type="text" name="employee_id_auto" id="e_employee_id_auto" value="" readonly>
                        </div>
                        <div class="col-sm-6"> 
                            <label>Employees M-Pesa Number</label>
                            <input class="form-control" type="text" name="employee_mpesa_number" id="e_phone_number" value="" >
                            <p style="font-size: 12px; font-style: italic; color: red;">Please Note: Format (254722000000)</p>
                        </div>
                        <div class="col-sm-6"> 
                                <label>Sender's M-Pesa Number </label>
                                <input class="form-control" type="text" name="senders_mpesa_number" id="sender_phone_number" value="" >
                                <p style="font-size: 12px; font-style: italic; color: red;">Please Note: Format (254722000000)</p>
                        </div>
                    </div>
                    <br>
                    <div class="row"> 
                        <div class="col-sm-6"> 
                            <div class="form-group">
                                <label>Total Amount to Pay</label>
                                <input class="form-control" type="text"  name="amount_paid" id="e_estimated_payout" value="" readonly>
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


        // Handle the click event for the "Pay" button in the "Edit Salary" modal
        $('.editSalary').click(function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var employee_id_auto = $(this).data('employee_id_auto');
            var phone_number = $(this).data('phone_number');
            var estimated_payout = $(this).data('estimated_payout');

            $('#e_id').val(id);
            $('#e_name').val(name);
            $('#e_employee_id_auto').val(employee_id_auto);
            $('#e_phone_number').val(phone_number);
            $('#e_estimated_payout').val(estimated_payout);
        });
    });
</script>





    @endsection
@endsection
