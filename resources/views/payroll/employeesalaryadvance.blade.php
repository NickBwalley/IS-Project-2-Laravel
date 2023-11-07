
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
                        <h3 class="page-title">Pay In Advance <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Advance Payment</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Pay Advance</a>
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
                                    <th>EmployeeID</th>
                                    <th>Phone Number</th>
                                    <th>Advance Amount Taken</th>
                                    <th>Advance Taken on Date</th>
                                    <th>Status</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            
                            <tbody>
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No records available.</td>
                                    </tr>
                                @else
                                @foreach ($users as $items)
                                {{-- @if ($items->status === 'unpaid') --}}
                                <tr>
                                    <td>
                                        {{ $items->name}}
                                    </td>
                                    <td>{{ $items->employee_id_auto }}</td>
                                    <td>{{ $items->phone_number }}</td>
                                    {{-- <td>{{ $items->phone_number }}</td> --}}
                                    <td><strong><span class="btn btn-warning">KSH {{ $items->advance_amount }}</span></strong></td>
                                    <td>{{ $items->created_at }}</td>
                                    <td><span class="btn btn-secondary">{{ $items->status }}</span></td>
                                    {{-- <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a class="#" href="#" data-toggle="modal" data-target="#delete_salary" data-id="{{ $items->id }}"><span class="btn btn-danger">Delete</span></a>
                                        </div>
                                    </td> --}}
                                </tr>
                                {{-- @endif --}}
                                @endforeach
                                @endif
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>

        
            

        <!-- Add Salary Modal -->

        <div id="add_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Pay Employee In Advance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('form/salary/advPay') }}" method="POST">
                    @csrf
                    <div class="row"> 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Employee Names</label>
                                <select class="form-control select2s-hidden-accessible @error('name') is-invalid @enderror" id="name" name="name">
                                    <option value="">-- Select Employees Name --</option>
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
                            <div class="form-group">
                                <label>Advance Amount Requested</label>
                                <input class="form-control" type="numeric" name="advance_amount" id="advance_amount">
                            </div>
                            
                                                        
                            {{-- status by default is set to "unpaid" --}}
                            <input class="form-control" type="hidden" name="status" id="status" value="unpaid" readonly>
                        </div>
                       
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Pay Advance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- /Add Salary Modal -->
        
        
        <!-- Delete Salary Modal -->
        {{-- <div class="modal custom-modal fade" id="delete_salary" role="dialog">
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
        </div> --}}

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

        // Handle the click event for the "Pay" button in the "Edit Salary" modal
        // $('.editSalary').click(function () {
        //     var id = $(this).data('id');
        //     var name = $(this).data('name');
        //     var employee_id_auto = $(this).data('employee_id_auto');
        //     var phone_number = $(this).data('phone_number');
        //     var advance_on_date = $(this).data('advance_on_date');
        //     var status = $(this).data('status');
            
        //     $('#e_id').val(id);
        //     $('#e_name').val(name);
        //     $('#e_employee_id_auto').val(employee_id_auto);
        //     $('#e_phone_number').val(phone_number);
        //     $('#e_phone_number').val(phone_number);
        //     $('#e_advance_amount').val(advance_amount);
        //     $('#e_shillings_per_kg').val(shillings_per_kg);
        //     $('#e_estimated_payout').val(estimated_payout);
        // });

        // Handle the click event for the "Delete" button in the "Delete Salary" modal
        // $('.salaryDelete').click(function () {
        //     var id = $(this).data('id');
        //     $('.e_id').val(id); // Set the value of the hidden input field
        // });
    });
</script>





    @endsection
@endsection
