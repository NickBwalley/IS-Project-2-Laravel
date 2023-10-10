<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\StaffSalary;
use Brian2694\Toastr\Facades\Toastr;

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

    $userList = DB::table('users')->select('user_id', 'name', 'phone_number')->get();
    // Select the 'user_id', 'name', and 'phone_number' fields from the 'users' table

    $permission_lists = DB::table('permission_lists')->get();

    return view('payroll.employeesalary', compact('users', 'userList', 'permission_lists'));
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
        Toastr::success('Create new Salary successfully :)', 'Success');
        return redirect()->back();
    } catch (\Exception $e) {
        DB::rollback();
        dd($e->getMessage()); // Debugging: Display the error message
        Toastr::error('Add Salary fail :(', 'Error');
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
        DB::beginTransaction();
        try{
            $update = [

                'id'      => $request->id,
                'name'    => $request->name,
                'salary'  => $request->salary,
                'basic'   => $request->basic,
                'da'      => $request->da,
                'hra'     => $request->hra,
                'conveyance' => $request->conveyance,
                'allowance'  => $request->allowance,
                'medical_allowance'  => $request->medical_allowance,
                'tds'  => $request->tds,
                'esi'  => $request->esi,
                'pf'   => $request->pf,
                'leave'     => $request->leave,
                'prof_tax'  => $request->prof_tax,
                'labour_welfare'  => $request->labour_welfare,
            ];


            StaffSalary::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Salary updated successfully :)','Success');
            return redirect()->back();

        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Salary update fail :)','Error');
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
}
