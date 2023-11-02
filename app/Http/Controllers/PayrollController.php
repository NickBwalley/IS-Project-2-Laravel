<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\StaffSalary;
use App\Models\StaffSalaryPaid;
use App\Models\StaffSalaryAdvance;
use Brian2694\Toastr\Facades\Toastr;
use Auth;

class PayrollController extends Controller
{
    // view page salary
    // public function salary()
    // {
    //     $users            = DB::table('users')->join('staff_salaries', 'users.user_id', '=', 'staff_salaries.user_id')->select('users.*', 'staff_salaries.*')->get(); 
    //     $userList         = DB::table('users')->get();
    //     $permission_lists = DB::table('permission_lists')->get();
    //     return view('payroll.employeesalary',compact('users','userList','permission_lists'));
    // }
    public function salary()
{
    $users = DB::table('users')
        ->join('staff_salaries', 'users.user_id', '=', 'staff_salaries.employee_id_auto')
        ->select('users.*', 'staff_salaries.*')
        ->get();

    $userList = DB::table('users')->select('user_id', 'name', 'phone_number', 'status')->get();
    // Select the 'user_id', 'name', and 'phone_number' fields from the 'users' table

    $permission_lists = DB::table('permission_lists')->get();

    // Get the employee ID from the `staff_salaries_advance` table
    $employeeId = DB::table('staff_salaries_advance')->first()->employee_id_auto;

    // Check if there are any records for the employee ID in the `staff_salaries_advance` table
    $advanceExists = DB::table('staff_salaries_advance')
        ->where('employee_id_auto', $employeeId)
        ->exists();

    // If there are any records, get the total advance amount for the employee
    if ($advanceExists) {
        $totalAdvanceAmount = DB::table('staff_salaries_advance')
            ->where('employee_id_auto', $employeeId)
            ->sum('advance_amount');

        // Set the value of the `Pending Advance Balance` input field
        $pendingAdvanceBalance = $totalAdvanceAmount;
    } else {
        // If there are no records, set the `Pending Advance Balance` input field to 0
        $pendingAdvanceBalance = 0;
    }

    return view('payroll.employeesalary', compact('users', 'userList', 'permission_lists', 'pendingAdvanceBalance'));
}


    public function salaryPaid()
{
    $users = DB::table('users')
        ->join('staff_salaries_paid', 'users.user_id', '=', 'staff_salaries_paid.employee_id_auto')
        ->select('users.*', 'staff_salaries_paid.*')
        ->get();

    $userList = DB::table('users')->select('user_id', 'name', 'phone_number')->get();
    // Select the 'user_id', 'name', and 'phone_number' fields from the 'users' table

    $permission_lists = DB::table('permission_lists')->get();

    return view('payroll.employeesalarypaid', compact('users', 'userList', 'permission_lists'));
}



        // save record
    public function saveRecord(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|numeric', // Corrected 'number' to 'numeric'
            'number_of_kgs_harvested' => 'required|numeric|min:0',
            'shillings_per_kg' => 'required|numeric|min:0',
        ]);


        DB::beginTransaction();
        try {
            $salary = StaffSalary::updateOrCreate(['id' => $request->id]);
            $salary->name = $request->name;
            $salary->employee_id_auto = $request->employee_id_auto;
            $salary->phone_number = $request->phone_number;
            $salary->number_of_kgs_harvested = $request->number_of_kgs_harvested; // Updated field name
            $salary->shillings_per_kg = $request->shillings_per_kg; // Added field for shillings per kg
            $salary->estimated_payout = $request->number_of_kgs_harvested * $request->shillings_per_kg; // Calculated estimated payout
            $salary->save();

            DB::commit();
            Toastr::success('Created new transaction successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage()); // Debugging: Display the error message
            Toastr::error('Transaction failed :(', 'Error');
            return redirect()->back();
        }

    }



        public function advPage()
{
    $users = DB::table('staff_salaries_advance')->get();

    $userList = DB::table('users')->select('user_id', 'name', 'phone_number', 'status')->get();

    $permission_lists = DB::table('permission_lists')->get();

    return view('payroll.employeesalaryadvance', compact('users', 'userList', 'permission_lists'));
}


            // save advance paid
    public function advancePay(Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'employee_id_auto' => 'required|string|max:255',
        'phone_number' => 'required|numeric|digits:10', // Limit the phone number to 10 digits
        'advance_amount' => 'required|numeric|min:0',
        'status' => 'required|string|max:100',
    ]);

    // Start a database transaction
    DB::beginTransaction();

    // Try to create a new salary advance record
    try {
        $data = [
            'name' => $request->name,
            'employee_id_auto' => $request->employee_id_auto,
            'phone_number' => $request->phone_number,
            'advance_amount' => $request->advance_amount,
            'status' => $request->status,
        ];

        $salary = StaffSalaryAdvance::create($data);

        // Commit the database transaction if successful
        DB::commit();

        // Display a success message
        Toastr::success('Advance Amount Granted Successfully :)', 'Success');

        // Redirect back
        return redirect()->back();
    } catch (\Exception $e) {
        // Rollback the database transaction if an error occurs
        DB::rollback();

        // Display an error message
        Toastr::error('Advance Amount Not Granted :(', 'Error');

        // Return back
        return redirect()->back();
    }
}



    // salary view detail
    public function salaryView($user_id)
    {
        $users = DB::table('users')
                ->join('staff_salaries', 'users.user_id', 'staff_salaries.user_id')
                ->join('profile_information', 'users.user_id', 'profile_information.user_id')
                ->select('users.*', 'staff_salaries.*','profile_information.*')
                ->where('staff_salaries.user_id',$user_id)->first();
        if(!empty($users)) {
            return view('payroll.salaryview',compact('users'));
        } else {
            Toastr::warning('Please update information user :)','Warning');
            return redirect()->route('profile_user');
        }
    }

    // update record
    public function updateRecord(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_mpesa_number' => 'required|numeric',
            'senders_mpesa_number' => 'required|numeric',
            'number_of_kgs_harvested' => 'required|numeric|min:0',
            'shillings_per_kg' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $salary = StaffSalaryPaid::updateOrCreate(['id' => $request->id]);
            $salary->name = $request->name;
            $salary->employee_id_auto = $request->employee_id_auto;
            $salary->invoice_number = $request->invoice_number;
            $salary->employee_mpesa_number = $request->employee_mpesa_number;
            $salary->senders_mpesa_number = $request->senders_mpesa_number;
            $salary->number_of_kgs_harvested = $request->number_of_kgs_harvested; 
            $salary->shillings_per_kg = $request->shillings_per_kg;
            $salary->amount_paid = $request->number_of_kgs_harvested * $request->shillings_per_kg;

            // Save the staff_salaries_paid record
            $salary->save();

            // Update the 'staff_salaries' record and set the status to 'paid' based on 'invoice_number'
            $staffSalaries = StaffSalary::where('invoice_number', $request->invoice_number)->first();
            if ($staffSalaries) {
                $staffSalaries->status = 'paid';
                $staffSalaries->save();
            }

            DB::commit();
            Toastr::success('Transaction Paid successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage()); // Debugging: Display the error message
            Toastr::error('Transaction failed :(', 'Error');
            return redirect()->back();
        }
    }



    // delete record
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {

            StaffSalary::destroy($request->id);

            DB::commit();
            Toastr::success('Salary deleted successfully :)','Success');
            return redirect()->back();
            
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Salary deleted fail :)','Error');
            return redirect()->back();
        }
    }

    // payroll Items
    public function payrollItems()
    {
        return view('payroll.payrollitems');
    }

    // search payments
    public function searchPayments(Request $request)
    {
        if (Auth::user()->role_name=='Admin')
        {
            $users     = DB::table('staff_salaries_paid')->get();
            $users     = DB::table('staff_salaries_paid')->get();
            $userList = DB::table('users')->get();
            // $user_id  = DB::table('users')->get();
            // $position   = DB::table('position_types')->get();
            // $department = DB::table('departments')->get();
            // $status_user = DB::table('user_types')->get();

            // search by receipt_number
            if($request->receipt_number)
            {
                $users = StaffSalaryPaid::where('receipt_number','LIKE','%'.$request->receipt_number.'%')->get();
            }

            if ($request->from_date) {
                $users = StaffSalaryPaid::where(function ($query) use ($request) {
                    $date = $request->from_date;
                    $date = str_replace('/', '-', $date);
                    $query->where('created_at', 'LIKE', '%' . substr($date, 0, 10) . '%')
                        ->orWhere('created_at', 'LIKE', '%' . substr($date, 6, 10) . '%');
                })->get();
            }



           
            return view('payroll.employeesalarypaid',compact('users','users', 'userList'));
        }
        else
        {
            return redirect()->route('form/salary/epaid');
        }
    
    }
}
