
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @if (Auth::user()->role_name == 'Admin')
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="{{ set_active(['home', 'em/dashboard']) }} submenu">
                    <a href="#" class="{{ set_active(['home', 'em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span> Dashboard</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{ set_active(['home']) }}" href="{{ route('home') }}">Admin Dashboard</a></li>
                        {{-- <li><a class="{{ set_active(['em/dashboard']) }}" href="{{ route('em/dashboard') }}">Employee Dashboard</a></li> --}}

                    </ul>
                </li>
                
                {{-- AUTHENTICATIONS AS WELL  --}}
                <li class="menu-title"> <span>Authentication</span> </li>
                <li class="{{set_active(['search/user/list','userManagement','activity/log','activity/login/logout'])}} submenu">
                    <a href="#" class="{{ set_active(['search/user/list','userManagement','activity/log','activity/login/logout']) ? 'noti-dot' : '' }}">
                        <i class="la la-user-secret"></i> <span> Manage Users</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['search/user/list','userManagement'])}}" href="{{ route('userManagement') }}">All Users</a></li>
                        <li><a class="{{set_active(['activity/log'])}}" href="{{ route('activity/log') }}">Activity Log</a></li>
                        <li><a class="{{set_active(['activity/login/logout'])}}" href="{{ route('activity/login/logout') }}">Activity Users</a></li>
                    </ul>
                </li>
                @endif

                @if (in_array(Auth::user()->role_name, ['Admin', 'Manager']))
                {{-- @if (Auth::user()->role_name == 'Manager') --}}
                <li class="menu-title"> <span>Manage Employees</span> </li>
                <li class="{{set_active(['all/employee/list','all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leavesemployee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page'])}} submenu">
                    <a href="#" class="{{ set_active(['all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leavesemployee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        
                        </li>
                        <li><a class="{{set_active(['search/user/list','userManagement'])}}" href="{{ route('userManagement') }}">Add Employee</a></li>
                        <li><a class="{{set_active(['form/leavesemployee/new'])}}" href="{{route('form/leavesemployee/new')}}">Assign Leave</a></li>
                        @if (Auth::user()->role_name == 'Admin')
                        <li><a class="{{set_active(['form/departments/page'])}}" href="{{ route('form/departments/page') }}">Farm Section</a></li>
                        @endif
                        <li><a class="{{set_active(['form/designations/page'])}}" href="{{ route('form/designations/page') }}">Assign Section</a></li>
                        
                    </ul>
                </li>
                <li class="menu-title"> <span>Payments</span> </li>
                                
                <li class="{{set_active(['form/salary/page','form/payroll/items'])}} submenu">
                    <a href="#" class="{{ set_active(['form/salary/page','form/payroll/items']) ? 'noti-dot' : '' }}"><i class="la la-money"></i>
                    <span> Payroll </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/salary/page'])}}" href="{{ route('form/salary/page') }}"> Remuneration Pay </a></li>
                        <li><a class="{{set_active(['form/salary/advPage'])}}" href="{{ route('form/salary/advPage') }}"> Advance Pay </a></li>
                        @if (Auth::user()->role_name == 'Admin')
                        <li><a class="{{set_active(['form/salary/checkout'])}}" href="{{ route('form/salary/checkout') }}"> Final Pay </a></li>
                        <li><a class="{{set_active(['form/salary/epaid'])}}" href="{{ route('form/salary/epaid') }}"> Paid Transactions </a></li>
                        <li><a class="{{set_active(['form/salary/pagePaid'])}}" href="{{ route('form/salary/pagePaid') }}"> Paid Remuneration </a></li>
                        <li><a class="{{set_active(['form/salary/advPagePaid'])}}" href="{{ route('form/salary/advPagePaid') }}"> Paid Advance </a></li>
                        @endif
                    </ul>
                </li>
                

                 @endif


                @if (Auth::user()->role_name == 'Admin')
                <li class="menu-title"> <span>Analysis</span> </li>
                <li class="{{set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page']) ? 'noti-dot' : '' }}"><i class="la la-graduation-cap"></i>
                    <span> Performance  </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/performance/indicator/page'])}}" href="{{ route('form/performance/indicator/page') }}"> Leading Indicator </a></li>
                        <li><a class="{{set_active(['form/performance/appraisal/page'])}}" href="{{ route('form/performance/appraisal/page') }}"> Lagging Indicator </a></li>
                        {{-- <li><a class="{{set_active(['form/performance/page'])}}" href="{{ route('form/performance/page') }}"> Performance Review </a></li> --}}
                    </ul>
                </li>
                
                @endif
               


                {{-- EMPLOYEES AUTHORIZATIONS --}}
                @if (Auth::user()->role_name=='Employee')
                    <li class="{{set_active(['form/salary/epage','form/payroll/items'])}} submenu">
                        <a href="#" class="{{ set_active(['form/salary/epage','form/payroll/items']) ? 'noti-dot' : '' }}"><i class="la la-dashboard"></i>
                        <span> Dashboard </span> <span class="menu-arrow"></span></a>
                        <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                            <li><a class="{{set_active(['form/salary/epage'])}}" href="{{ route('form/salary/epage') }}"> Pending Transactions </a></li>
                            <li><a class="{{set_active(['form/salary/eviewpaid'])}}" href="{{ route('form/salary/eviewpaid') }}"> Paid Transactions </a></li>
                            <li><a class="{{set_active(['form/employeeleaves/new'])}}" href="{{route('form/employeeleaves/new')}}">Apply Leave</a></li>
                            
                            {{-- <li><a class="{{set_active(['form/payroll/items'])}}" href="{{ route('form/payroll/items') }}"> Payslip </a></li> --}}
                        </ul>
                    </li>
                @endif
                
                @if (Auth::user()->role_name=='Manager')
                
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
