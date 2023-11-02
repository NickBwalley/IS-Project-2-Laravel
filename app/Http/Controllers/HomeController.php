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
        return view('dashboard.dashboard', compact('pendingTransactions', 'paidTransactions', 'allTransactionsCount', 'allUsersCount', 'pendingLeaves', 'approvedLeaves', 'declinedLeaves', 'farmSections'));
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
