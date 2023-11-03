<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\LeavesAdmin;
use App\Models\LeavesEmployee;
use App\Models\User;
use DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class LeavesController extends Controller
{
    // leaves
    public function leaves()
    {
        $leaves = DB::table('leaves_admins')
                    ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
                    ->select('leaves_admins.*', 'users.position','users.name','users.avatar')
                    ->get();

        return view('form.leaves',compact('leaves'));
    }
    // save record
    public function saveRecord(Request $request)
    {
        $request->validate([
            'leave_type'   => 'required|string|max:255',
            'from_date'    => 'required|string|max:255',
            'to_date'      => 'required|string|max:255',
            'leave_reason' => 'required|string|max:255',
            'status'       => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $from_date = new DateTime($request->from_date);
            $to_date = new DateTime($request->to_date);
            $day     = $from_date->diff($to_date);
            $days    = $day->d;

            $leaves = new LeavesAdmin;
            $leaves->user_id        = $request->user_id;
            $leaves->leave_type    = $request->leave_type;
            $leaves->from_date     = $request->from_date;
            $leaves->to_date       = $request->to_date;
            $leaves->day           = $days;
            $leaves->leave_reason  = $request->leave_reason;
            $leaves->status  = $request->status;
            $leaves->save();

            DB::commit();
            Toastr::success('Created new Leave successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to create Leave :)','Error');
            return redirect()->back();
        }
    }

    // edit record
    public function editRecordLeave(Request $request)
    {
        DB::beginTransaction();
        try {

            $from_date = new DateTime($request->from_date);
            $to_date = new DateTime($request->to_date);
            $day     = $from_date->diff($to_date);
            $days    = $day->d;

            $update = [
                'id'           => $request->id,
                'leave_type'   => $request->leave_type,
                'from_date'    => $request->from_date,
                'to_date'      => $request->to_date,
                'day'          => $days,
                'leave_reason' => $request->leave_reason,
            ];

            LeavesAdmin::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Updated Leaves successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Update Leaves fail :)','Error');
            return redirect()->back();
        }
    }

    // delete record
    public function deleteLeave(Request $request)
    {
        try {

            LeavesAdmin::destroy($request->id);
            Toastr::success('Leaves admin deleted successfully :)','Success');
            return redirect()->back();

        } catch(\Exception $e) {

            DB::rollback();
            Toastr::error('Leaves admin delete fail :)','Error');
            return redirect()->back();
        }
    }

    // leaveSettings
    public function leaveSettings()
    {
        return view('form.leavesettings');
    }

    // attendance admin
    public function attendanceIndex()
    {
        return view('form.attendance');
    }

    // attendance employee
    public function AttendanceEmployee()
    {
        return view('form.attendanceemployee');
    }

    // leaves Employee
    public function leavesEmployee()
    {
        $leavese = DB::table('leaves_employees')
                    ->join('users', 'users.user_id', '=', 'leaves_employees.user_id')
                    ->select('leaves_employees.*', 'users.position','users.name','users.avatar')
                    ->get();
        
        $users = DB::table('users')
        ->join('staff_salaries', 'users.user_id', '=', 'staff_salaries.employee_id_auto')
        ->select('users.*', 'staff_salaries.*')
        ->get();

    $userList = DB::table('users')->select('user_id', 'name', 'phone_number', 'status')->get();
    // Select the 'user_id', 'name', and 'phone_number' fields from the 'users' table

    $permission_lists = DB::table('permission_lists')->get();
        return view('form.leavesemployee',compact('leavese, userList'));
    }

    // leaves Employee
    public function employeeLeaves()
    {
        // $user = Auth::user(); // Get the currently logged-in user

        // $leaves = User::where('user_id', $user->id)->get(); // Replace 'Leave' with your model name

        $leavese = DB::table('leaves_employees')
                    ->join('users', 'users.user_id', '=', 'leaves_employees.user_id')
                    ->select('leaves_employees.*', 'users.position','users.name','users.avatar')
                    ->get();
        return view('form.employeeleaves',compact('leavese'));
    }

    public function saveERecord(Request $request)
    {
        $request->validate([
            'leave_type'   => 'required|string|max:255',
            'from_date'    => 'required|string|max:255',
            'to_date'      => 'required|string|max:255',
            'leave_reason' => 'required|string|max:255',
            'status'       => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $from_date = new DateTime($request->from_date);
            $to_date = new DateTime($request->to_date);
            $day     = $from_date->diff($to_date);
            $days    = $day->d;

            $leavese = new LeavesEmployee;
            $leavese->user_id        = $request->user_id;
            $leavese->leave_type    = $request->leave_type;
            $leavese->from_date     = $request->from_date;
            $leavese->to_date       = $request->to_date;
            $leavese->day           = $days;
            $leavese->leave_reason  = $request->leave_reason;
            $leavese->status  = $request->status;
            $leavese->save();

            DB::commit();
            Toastr::success('Create new Leaves successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add Leaves failed :)','Error');
            return redirect()->back();
        }
    }

    public function deleteELeave(Request $request)
    {
        try {

            LeavesEmployee::destroy($request->id);
            Toastr::success('Leaves employee deleted successfully :)','Success');
            return redirect()->back();

        } catch(\Exception $e) {

            DB::rollback();
            Toastr::error('Leaves employee delete fail :)','Error');
            return redirect()->back();
        }
    }

    public function editERecordLeave(Request $request)
    {
        DB::beginTransaction();
        try {

            $update = [
                'status' => $request->status,
            ];

            LeavesEmployee::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Updated Leaves successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Update Leaves fail :)','Error');
            return redirect()->back();
        }
    }

    // shiftscheduling
    public function shiftScheduLing()
    {
        return view('form.shiftscheduling');
    }

    // shiftList
    public function shiftList()
    {
        return view('form.shiftlist');
    }
}
