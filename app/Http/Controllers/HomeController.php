<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\DepartmentsAssigned;
use App\Models\LeavesEmployee;
use App\Models\StaffSalary;
use App\Models\StaffSalaryPaid;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use PDF;
use App\Models\User;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // main dashboard
    public function index()
    {
        $pendingTransactions = StaffSalary::where('status', 'pending')->count();
        $paidTransactions = StaffSalary::where('status', 'paid')->count();
        $pendingLeaves = LeavesEmployee::where('status', 'pending')->count();
        $approvedLeaves = LeavesEmployee::where('status', 'approved')->count();
        $declinedLeaves = LeavesEmployee::where('status', 'declined')->count();
        $farmSections = department::count();
        $allTransactionsCount = StaffSalaryPaid::count();
        $allUsersCount = User::count();

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
        return view('dashboard.dashboard', compact('pendingTransactions', 'paidTransactions', 'allTransactionsCount', 'allUsersCount', 'pendingLeaves', 'approvedLeaves', 'declinedLeaves', 'farmSections', 'chart1', 'chart2', 'chart3' , 'chart4'));
    }
    // employee dashboard
    public function emDashboard()
    {
        $dt        = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
        return view('dashboard.emdashboard',compact('todayDate'));
    }

    public function generatePDF(Request $request)
    {
        // $data = ['title' => 'Welcome to ItSolutionStuff.com'];
        // $pdf = PDF::loadView('payroll.salaryview', $data);
        // return $pdf->download('text.pdf');
        // selecting PDF view
        $pdf = PDF::loadView('payroll.salaryview');
        // download pdf file
        return $pdf->download('pdfview.pdf');
    }
}
