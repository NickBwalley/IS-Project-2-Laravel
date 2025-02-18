<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\performanceIndicator;
use App\Models\performance_appraisal;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Session;
use Auth;

class PerformanceController extends Controller
{
    // view page
    public function index()
    {
        $chart1_options = [
            'chart_title' => 'Numbers of kgs per Day (Line Chart)',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\StaffSalary',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'number_of_kgs_harvested',
            'chart_type' => 'line',
            'chart_color' => '0,100,0',
        ];
        $chart2_options = [
            'chart_title' => 'Advance Amount  per day (Bar Chart)',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\StaffSalaryAdvance',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'advance_amount',
            'filter_days' => 7,
            'filter_period' => 'week',
            'chart_color' => '0,100,0',
            'chart_type' => 'bar',
        ];


        $chart3_options = [
            'chart_title' => 'Amount Paid per day (Bar Chart)',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\StaffSalaryPaid',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount_paid',
            'filter_days' => 30,
            'filter_period' => 'week',
            'chart_type' => 'bar',
            'chart_color' => '0,100,0',
        ];

        $chart4_options = [
            'chart_title' => 'Leaves Status',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\LeavesEmployee',
            'group_by_field' => 'status',
            'filter_period' => 'week',
            'chart_type' => 'pie',
            'chart_color' => '0,100,0',
        ];

        $chart5_options = [
            'chart_title' => 'Amount Paid per day (Bar Chart)',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\StaffSalaryPaid',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount_paid',
            'chart_type' => 'line',
            'chart_color' => '0,100,0',
        ];

        $settings2 = [
            'chart_title' => 'Advance Amount  per day (line Chart)',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\StaffSalaryAdvance',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'advance_amount',
            'chart_type' => 'line',
        ];




        $chart1 = new LaravelChart($chart1_options);
        $chart2 = new LaravelChart($chart2_options);
        $chart3 = new LaravelChart($chart3_options);
        $chart4 = new LaravelChart($chart4_options);
        //$chart4 = new LaravelChart($chart5_options, $chart3_options);



        return view('performance.performanceindicator', compact('chart1', 'chart2', 'chart3' , 'chart4'));
    }

    //performance
    public function performance()
    {

        return view('performance.performance');
    }

    //performance appraisal view page
    public function performanceAppraisal()
    {
        $users = DB::table('users')->get();
        $indicator = DB::table('performance_indicator_lists')->get();
        $appraisals = DB::table('users')
        ->join('performance_appraisals', 'users.user_id', '=', 'performance_appraisals.user_id')
        ->select('users.*', 'performance_appraisals.*')
        ->get();
        return view('performance.performanceappraisal',compact('users','indicator','appraisals'));
    }

    // save record
    public function saveRecordIndicator(Request $request)
    {
        $request->validate([
            'designation'        => 'required|string|max:255',
            'customer_eperience' => 'required|string|max:255',
            'marketing'          => 'required|string|max:255',
            'management'         => 'required|string|max:255',
            'administration'     => 'required|string|max:255',
            'presentation_skill' => 'required|string|max:255',
            'quality_of_Work'    => 'required|string|max:255',
            'efficiency'         => 'required|string|max:255',
            'integrity'          => 'required|string|max:255',
            'professionalism'    => 'required|string|max:255',
            'team_work'          => 'required|string|max:255',
            'critical_thinking'  => 'required|string|max:255',
            'conflict_management'=> 'required|string|max:255',
            'attendance'         => 'required|string|max:255',
            'ability_to_meet_deadline'=> 'required|string|max:255',
            'status'   => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $indicator = new performanceIndicator;
            $indicator->user_id             = $request->user_id;
            $indicator->designation        = $request->designation;
            $indicator->customer_eperience = $request->customer_eperience;
            $indicator->marketing          = $request->marketing;
            $indicator->management         = $request->management;
            $indicator->administration     = $request->administration;
            $indicator->presentation_skill = $request->presentation_skill;
            $indicator->quality_of_Work    = $request->quality_of_Work;
            $indicator->efficiency         = $request->efficiency;
            $indicator->integrity          = $request->integrity;
            $indicator->professionalism    = $request->professionalism;
            $indicator->team_work          = $request->team_work;
            $indicator->critical_thinking  = $request->critical_thinking;
            $indicator->conflict_management= $request->attendance;
            $indicator->attendance         = $request->attendance;
            $indicator->ability_to_meet_deadline = $request->ability_to_meet_deadline;
            $indicator->status             = $request->status;
            $indicator->save();

            DB::commit();
            Toastr::success('Create new performance indicator successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add performance indicator fail :)','Error');
            return redirect()->back();
        }
    }

    // update record
    public function updateIndicator(Request $request)
    {
        DB::beginTransaction();
        try {

            $update = [
                'id'                        => $request->id,
                'designation'               => $request->designation,
                'customer_eperience'        => $request->customer_eperience,
                'marketing'                 => $request->marketing,
                'management'                => $request->management,
                'administration'            => $request->administration,
                'presentation_skill'        => $request->presentation_skill,
                'quality_of_Work'           => $request->quality_of_Work,
                'efficiency'                => $request->efficiency,
                'integrity'                 => $request->integrity,
                'professionalism'           => $request->professionalism,
                'team_work'                 => $request->team_work,
                'critical_thinking'         => $request->critical_thinking,
                'conflict_management'       => $request->conflict_management,
                'attendance'                => $request->attendance,
                'ability_to_meet_deadline'  => $request->ability_to_meet_deadline,
                'status'                    => $request->status,
            ];
            performanceIndicator::where('id',$request->id)->update($update);
            DB::commit();

            DB::commit();
            Toastr::success('Performance indicator deleted successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Performance indicator fail :)','Error');
            return redirect()->back();
        }
    }

    // delete record
    public function deleteIndicator(Request $request)
    {
        try {

            performanceIndicator::destroy($request->id);
            Toastr::success('Performance indicator deleted successfully :)','Success');
            return redirect()->back();

        } catch(\Exception $e) {

            DB::rollback();
            Toastr::error('Performance indicator delete fail :)','Error');
            return redirect()->back();
        }
    }

    // saveRecord Appraisal
    public function saveRecordAppraisal(Request $request)
    {
        DB::beginTransaction();
        try {

            $appraisal = new performance_appraisal;
            $appraisal->user_id              = $request->user_id;
            $appraisal->date                = $request->date;
            $appraisal->name                = $request->name;
            $appraisal->customer_experience = $request->customer_experience;
            $appraisal->marketing           = $request->marketing;
            $appraisal->management          = $request->management;
            $appraisal->administration      = $request->administration;
            $appraisal->presentation_skill  = $request->presentation_skill;
            $appraisal->quality_of_Work     = $request->quality_of_work;
            $appraisal->efficiency          = $request->efficiency;
            $appraisal->integrity           = $request->integrity;
            $appraisal->professionalism     = $request->professionalism;
            $appraisal->team_work           = $request->team_work;
            $appraisal->critical_thinking   = $request->critical_thinking;
            $appraisal->conflict_management = $request->attendance;
            $appraisal->attendance          = $request->attendance;
            $appraisal->ability_to_meet_deadline = $request->ability_to_meet_deadline;
            $appraisal->status              = $request->status;
            $appraisal->save();

            DB::commit();
            Toastr::success('Create new performance appraisal successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add performance appraisal fail :)','Error');
            return redirect()->back();
        }
    }

    // delete record
    public function deleteAppraisal(Request $request)
    {
        try {

            performance_appraisal::destroy($request->id);
            Toastr::success('Performance Appraisal deleted successfully :)','Success');
            return redirect()->back();

        } catch(\Exception $e) {

            DB::rollback();
            Toastr::error('Performance Appraisal delete fail :)','Error');
            return redirect()->back();
        }
    }

    //updateAppraisal
    public function updateAppraisal(Request $request)
    {
        DB::beginTransaction();
        try {

            $update = [
                'id'                        => $request->id,
                'date'                      => $request->date,
                'customer_experience'       => $request->customer_experience,
                'marketing'                 => $request->marketing,
                'management'                => $request->management,
                'administration'            => $request->administration,
                'presentation_skill'        => $request->presentation_skill,
                'quality_of_Work'           => $request->quality_of_work,
                'efficiency'                => $request->efficiency,
                'integrity'                 => $request->integrity,
                'professionalism'           => $request->professionalism,
                'team_work'                 => $request->team_work,
                'critical_thinking'         => $request->critical_thinking,
                'conflict_management'       => $request->conflict_management,
                'attendance'                => $request->attendance,
                'ability_to_meet_deadline'  => $request->ability_to_meet_deadline,
                'status'                    => $request->status,
            ];
            performance_appraisal::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Performance Appraisal deleted successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Performance Appraisal fail :)','Error');
            return redirect()->back();
        }
    }

}
