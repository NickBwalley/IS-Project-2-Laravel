
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
                        <h3 class="page-title">Employee Salary <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Add Salary</a>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Employee ID</th>
                                    <th>KGS Harvested</th>
                                    <th>Shilling per KG</th>
                                    <th>Total Payout</th>
                                    <th>Time</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($users as $items)
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{ url('employee/profile/'.$items->user_id) }}" class="avatar"><img alt="" src="{{ URL::to('/assets/images/'. $items->avatar) }}"></a>
                                            <a href="{{ url('employee/profile/'.$items->user_id) }}">{{ $items->name }}</a>
                                        </h2>
                                    </td>
                                    <td>{{ $items->employee_id_auto }}</td>
                                    <td>{{ $items->number_of_kgs_harvested }}</td>
                                    <td>{{ $items->shillings_per_kg }}</td>
                                    <td>{{ $items->estimated_payout }}</td>
                                    <td>{{ $items->created_at }}</td>
                                    <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle editSalary" data-toggle="modal" data-target="#edit_salary"
                                        data-id="{{ $items->id }}"
                                        data-name="{{ $items->name }}"
                                        data-employee_id_auto="{{ $items->employee_id_auto }}"
                                        data-number_of_kgs_harvested="{{ $items->number_of_kgs_harvested }}"
                                        data-shillings_per_kg="{{ $items->shillings_per_kg }}"
                                        data-estimated_payout="{{ $items->estimated_payout }}"
                                    ><i class="fa-solid fa-dollar-sign"></i> Pay</a>
                                    <a class="dropdown-item salaryDelete" href="#" data-toggle="modal" data-target="#delete_salary"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </td>
                                </tr>
                                @endforeach
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
                <h5 class="modal-title">Add Staff Salary</h5>
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
                                        <option value="{{ $user->name }}" data-employee_id="{{ $user->user_id }}">{{ $user->name }}</option>
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
                <h5 class="modal-title">Edit Staff Salary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('form/salary/update') }}" method="POST">
                    @csrf
                    <input class="form-control" type="hidden" name="id" id="e_id" value="" readonly>
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
                            <label>Telephone Number</label>
                            <input class="form-control" type="text" name="telephone" id="" value="">
                        </div>
                        <div class="col-sm-6"> 
                                <label>Employee ID </label>
                                <input class="form-control" type="text" name="employee_id_auto" id="e_employee_id_auto" value="" readonly>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-6"> 
                            
                            <div class="form-group">
                                <label>Number of Kgs Harvested</label>
                                <input class="form-control" type="text" name="number_of_kgs_harvested" id="e_number_of_kgs_harvested" value="" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label>Shillings per Kg</label>
                                <input class="form-control" type="text"  name="shillings_per_kg" id="e_shillings_per_kg" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label>Total Amount to Pay</label>
                                <input class="form-control" type="text"  name="estimated_payout" id="e_estimated_payout" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Pay</button>
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
                                <div class="row">
                                    <div class="col-6">
                                        <input type="hidden" name="id" class="e_id" value="">
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
        // When a name is selected in the "Add Salary" modal
        $('#name').change(function () {
            var selectedOption = $(this).find('option:selected');
            var employeeID = selectedOption.data('employee_id');
            $('#uniqueid').val(employeeID); // Populate the "Employee ID Auto" field
        });

        // Add JavaScript to calculate Estimated Payout in real-time
        $('#number_of_kgs_harvested, #shillings_per_kg').on('input', function () {
            var kgsHarvested = parseFloat($('#number_of_kgs_harvested').val()) || 0;
            var shillingsPerKg = parseFloat($('#shillings_per_kg').val()) || 0;
            var estimatedPayout = kgsHarvested * shillingsPerKg;
            $('#estimated_payout').val(estimatedPayout.toFixed(2));
        });
    });
</script>


        <script>
            $(document).ready(function() {
                $('.select2s-hidden-accessible').select2({
                    closeOnSelect: false
                });
            });
        </script>
        <script>
            // select auto id and email
            $('#name').on('change',function()
            {
                $('#employee_id').val($(this).find(':selected').data('employee_id'));
            });
        </script>
        {{-- update js --}}
        <script>
            $(document).on('click','.userSalary',function()
            {
                var _this = $(this).parents('tr');
                $('#e_id').val(_this.find('.id').text());
                $('#e_name').val(_this.find('.name').text());
                $('#e_salary').val(_this.find('.salary').text());
                $('#e_basic').val(_this.find('.basic').text());
                $('#e_da').val(_this.find('.da').text());
                $('#e_hra').val(_this.find('.hra').text());
                $('#e_conveyance').val(_this.find('.conveyance').text());
                $('#e_allowance').val(_this.find('.allowance').text());
                $('#e_medical_allowance').val(_this.find('.medical_allowance').text());
                $('#e_tds').val(_this.find('.tds').text());
                $('#e_esi').val(_this.find('.esi').text());
                $('#e_pf').val(_this.find('.pf').text());
                $('#e_leave').val(_this.find('.leave').text());
                $('#e_prof_tax').val(_this.find('.prof_tax').text());
                $('#e_labour_welfare').val(_this.find('.labour_welfare').text());
            });
        </script>
         {{-- delete js --}}
    <script>
        $(document).on('click','.salaryDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>

    <script>
        // Add JavaScript to populate Employee ID Auto field when a name is selected
        $(document).ready(function () {
            $('#name').change(function () {
                var selectedOption = $(this).find('option:selected');
                var employeeID = selectedOption.data('employee_id');
                $('#employee_id_auto').val(employeeID);
            });

            // Add JavaScript to calculate Estimated Payout in real-time
            $('#number_of_kgs_harvested, #shillings_per_kg').on('input', function () {
                var kgsHarvested = parseFloat($('#number_of_kgs_harvested').val()) || 0;
                var shillingsPerKg = parseFloat($('#shillings_per_kg').val()) || 0;
                var estimatedPayout = kgsHarvested * shillingsPerKg;
                $('#estimated_payout').val(estimatedPayout.toFixed(2));
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // When a "Pay" button is clicked
            $('.editSalary').click(function() {
                // Get the data attributes
                var id = $(this).data('id');
                var name = $(this).data('name');
                var employee_id_auto = $(this).data('employee_id_auto');
                var number_of_kgs_harvested = $(this).data('number_of_kgs_harvested');
                var shillings_per_kg = $(this).data('shillings_per_kg');
                var estimated_payout = $(this).data('estimated_payout');

                // Populate the modal fields with the data
                $('#e_id').val(id);
                $('#e_name').val(name);
                $('#e_employee_id_auto').val(employee_id_auto);
                $('#e_number_of_kgs_harvested').val(number_of_kgs_harvested);
                $('#e_shillings_per_kg').val(shillings_per_kg);
                $('#e_estimated_payout').val(estimated_payout);
            });
        });
    </script>

    @endsection
@endsection
