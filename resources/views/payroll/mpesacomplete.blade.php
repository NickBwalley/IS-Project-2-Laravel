
@extends('layouts.app')
@section('content')
{{-- message --}}
    {!! Toastr::message() !!}
<div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title">Confirmed Successful Transaction</h3>
        
    </div>
    <div class="modal-body">
        <form id="salaryUpdateForm" action="{{ route('form/salary/update') }}" method="POST">
            @csrf
            {{-- <input class="form-control" type="text" name="id" id="e_id" value="" > --}}
            <div class="row"> 
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label>Employee Name</label>
                        <input class="form-control" type="text" name="name" id="e_name" value="{{ request('name') }}" readonly>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-6"> 
                    <label>Employee ID </label>
                    <input class="form-control" type="text" name="employee_id_auto" id="e_employee_id_auto" value="{{ request('employee_id_auto') }}" readonly>
                </div>
                <div class="col-sm-6"> 
                    <label>Employees M-Pesa Number</label>
                    <input class="form-control" type="text" name="employee_mpesa_number" id="e_phone_number" value="{{ request('employee_mpesa_number') }}" readonly>
                    
                </div>
                <div class="col-sm-6"> 
                        <label>Sender's M-Pesa Number </label>
                        <input class="form-control" type="text" name="senders_mpesa_number" id="sender_phone_number" value="{{ request('senders_mpesa_number') }}" readonly>
                        
                </div>
            </div>
            <br>
            <div class="row"> 
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label>Total Amount to Pay</label>
                        <input class="form-control" type="text"  name="amount_paid" id="e_estimated_payout" value="{{ request('amount_paid') }}" readonly>
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Complete Transaction</button>
                
            </div>
        </form>
    </div>
</div>    
@endsection
