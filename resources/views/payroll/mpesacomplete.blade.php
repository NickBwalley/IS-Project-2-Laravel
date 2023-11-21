<!-- resources/views/your-view.blade.php -->

@extends('layouts.app') <!-- Adjust based on your layout structure -->

@section('content')
            <div class="modal-body">
                <form action="{{ route('form/salary/update') }}" method="POST">
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
                        <button type="submit" class="btn btn-primary submit-btn">Complete Transaction</button>
                    </div>
                </form>
            </div>
            
    <script>
        function submitForm() {
            // Set values from PHP session
            document.getElementById('e_name').value = "<?php start_session(); echo $_SESSION['name']; ?>";
            document.getElementById('e_employee_id_auto').value = "<?php echo $_SESSION['employee_id_auto']; ?>";
            document.getElementById('e_phone_number').value = "<?php echo $_SESSION['employee_mpesa_number']; ?>";
            document.getElementById('sender_phone_number').value = "<?php echo $_SESSION['senders_mpesa_number']; ?>";
            document.getElementById('e_estimated_payout').value = "<?php echo $_SESSION['amount_paid']; ?>";

            // Optionally, you can remove the read-only attribute if needed
            // document.getElementById('e_name').readOnly = false;

            // Submit the form automatically
            document.getElementById('mpesaForm').submit();
        }
    </script>
@endsection
