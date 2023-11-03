<?php 
use App\Models\LeavesEmployee;
use Illuminate\Support\Facades\Auth;
?>

@extends('layouts.master')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Leaves <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leaves</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                    </div>
                </div>
            </div>
            <!-- Leave Statistics -->
            @if (in_array(Auth::user()->role_name, ['Admin', 'Manager']))
            {{-- <div class="row">
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Today Presents</h6>
                        <h4>12 / 60</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Planned Leaves</h6>
                        <h4>8 <span>Today</span></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Unplanned Leaves</h6>
                        <h4>0 <span>Today</span></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Pending Requests</h6>
                        <h4>12</h4>
                    </div>
                </div>
            </div> --}}
            <!-- /Leave Statistics -->

            <!-- Search Filter -->
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
                            <option> -- Select -- </option>
                            <option>Casual Leave</option>
                            <option>Medical Leave</option>
                            <option>Loss of Pay</option>
                        </select>
                        <label class="focus-label">Leave Type</label>
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
            </div>
            @endif
            <!-- /Search Filter -->

			<!-- /Page Header -->
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>No of Days</th>
                                    <th>Reason</th>
                                    <th class="text-center">Status</th>
                                    @if (in_array(Auth::user()->role_name, ['Admin', 'Manager']))
                                    <th class="text-right">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            

                            <tbody>
                                @if(!empty($leavese))
                                    @foreach ($leavese as $items )
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="{{ url('employee/profile/'.$items->user_id) }}" class="avatar"><img alt="" src="{{ URL::to('/assets/images/'. $items->avatar) }}" alt="{{ $items->name }}"></a>
                                                    <a href="#">{{ $items->name }}<span>{{ $items->position }}</span></a>
                                                </h2>
                                            </td>
                                            <td hidden class="id">{{ $items->id }}</td>
                                            <td class="leave_type">{{$items->leave_type}}</td>
                                            <td hidden class="from_date">{{ $items->from_date }}</td>
                                            <td>{{date('d F, Y',strtotime($items->from_date)) }}</td>
                                            <td hidden class="to_date">{{$items->to_date}}</td>
                                            <td>{{date('d F, Y',strtotime($items->to_date)) }}</td>
                                            <td class="day">
                                                @if ($items->day == 0)
                                                    Half-day
                                                @elseif ($items->day == 1)
                                                    1 day
                                                @else
                                                    {{ $items->day }} days
                                                @endif
                                            </td>
                                            <td class="leave_reason">{{$items->leave_reason}}</td>
                                            <td class="text-center">
                                                <div class="dropdown action-label">
                                                    
                                                        @if($items->status == 'pending')
                                                        <a class="btn btn-secondary">Pending</a>
                                                        @elseif($items->status == 'approved')
                                                        <a class="btn btn-info">Approved</a>
                                                        @else
                                                        <a class="btn btn-danger">Declined</a>
                                                        @endif
                                                    
                                                </div>
                                            </td>
                                            @if (in_array(Auth::user()->role_name, ['Admin', 'Manager']))
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item leaveUpdate" data-toggle="modal" data-id="'.$items->id.'" data-target="#edit_leave"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item leaveDelete" href="#" data-toggle="modal" data-target="#delete_approve"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                            @endif
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

        <!-- Add Leave Modal -->
        <div id="add_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/leavesemployee/save') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name">Employee Names</label>
                                <select class="form-control select2s-hidden-accessible @error('name') is-invalid @enderror" id="name" name="name">
                                    <option value="">-- Select --</option>
                                    @foreach ($userList as $key => $user)
                                        @if ($user->status === 'Active' && $user->role_name === 'Employee')
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

                            
                                <input class="form-control" type="hidden" name="user_id" id="employee_id_auto" readonly>
                            

                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select class="select" id="leaveType" name="leave_type">
                                    <option selected disabled>Select Leave Type</option>
                                    <option value="Casual Leave Days">Casual Leave</option>
                                    <option value="Medical Leave">Medical Leave</option>
                                    <option value="Loss of Pay">Loss of Pay</option>
                                    <option value="Loss of Pay">Others</option>
                                </select>
                            </div>



                            {{-- <input type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->user_id }}"> --}}
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" id="from_date" name="from_date">
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" id="to_date" name="to_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Leave Reason <span class="text-danger">*</span></label>
                                <textarea rows="4" class="form-control" id="leave_reason" name="leave_reason"></textarea>
                            </div>
                            
                            <input type="hidden" class="form-control" id="status" name="status" value="pending">


                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Leave Modal -->

        <!-- Edit Leave Modal -->
        <div id="edit_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Leave Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/leavesemployee/edit') }}" method="POST">
                            @csrf
                            <input type="hidden" id="e_id" name="id" value="">
                            <div class="form-group">
                                <label> Leave Status <span class="text-danger">*</span></label>
                                <select class="select" id="" name="status">
                                    <option selected disabled>---Select Status--</option>
                                    <option value="approved">Approve</option>
                                    <option value="declined">Decline</option>
                                    <option value="pending">Stand-by</option>
                                    
                                </select>
                            </div>
                            
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Leave Modal -->

        <!-- Approve Leave Modal -->
        <div class="modal custom-modal fade" id="approve_leave" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Leave Approve</h3>
                            <p>Are you sure want to approve for this leave?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Approve</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Decline</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Approve Leave Modal -->

        <!-- Delete Leave Modal -->
        <div class="modal custom-modal fade" id="delete_approve" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Leave</h3>
                            <p>Are you sure want to delete this leave?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('form/leavesemployee/edit/delete') }}" method="POST">
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
        <!-- /Delete Leave Modal -->
    </div>
    <!-- /Page Wrapper -->
    @section('script')
    <script>
        document.getElementById("year").innerHTML = new Date().getFullYear();
    </script>
    {{-- update js --}}
    <script>
        $(document).on('click','.leaveEUpdate',function()
        {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id').text());
            
            $('#e_number_of_days').val(_this.find('.day').text());
            $('#e_from_date').val(_this.find('.from_date').text());
            $('#e_to_date').val(_this.find('.to_date').text());
            $('#e_leave_reason').val(_this.find('.leave_reason').text());
            $('#e_status').val(_this.find('.status').text());

            var leave_type = (_this.find(".leave_type").text());
            var _option = '<option selected value="' + leave_type+ '">' + _this.find('.leave_type').text() + '</option>'
            $( _option).appendTo("#e_leave_type");
        });
    </script>

    {{-- populate this with the edit field  --}}

    <script>
        $(document).ready(function () {
            // Add a click event listener to the "Edit" button
            $(".leaveUpdate").on("click", function () {
                // Capture data from the row
                var row = $(this).closest("tr");
                // var leaveType = row.find(".leave_type").text();
                // var fromDate = row.find(".from_date").text();
                // var toDate = row.find(".to_date").text();
                // var numberOfDays = row.find(".day").text();
                // var leaveReason = row.find(".leave_reason").text();
                var leaveId = row.find(".id").text();

                // Populate the edit modal with captured data
                // $("#e_leave_type").val(leaveType);
                // $("#e_from_date").val(fromDate);
                // $("#e_to_date").val(toDate);
                // $("#e_number_of_days").val(numberOfDays);
                // $("#e_leave_reason").val(leaveReason);
                $("#e_id").val(leaveId);
            });
        });
    </script>


    {{-- delete model --}}
    <script>
        $(document).on('click','.leaveEDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>

    <script>
        $(document).ready(function () {
            // Populate Employee ID Auto and Phone Number in the "Add Salary" modal
            $('#name').change(function () {
                var selectedOption = $(this).find('option:selected');
                var employeeID = selectedOption.data('employee_id');
                var phoneNumber = selectedOption.data('phone_number');

                // Set the value of the employee_id_auto field
                $('#employee_id_auto').val(employeeID);

                // Set the value of the phone_number field
                $('#phone_number').val(phoneNumber);
            });
        });
    </script>
    @endsection
@endsection
