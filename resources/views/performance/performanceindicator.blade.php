@extends('layouts.master')

@section('content')
    {{-- Display any messages --}}
    {!! Toastr::message() !!}

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Performance Indicator</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Performance</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Cards for Charts -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- Display Chart 1 -->
                            {!! $chart1->renderHtml() !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- Display Chart 2 -->
                            {!! $chart2->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- Display Chart 1 -->
                            {!! $chart3->renderHtml() !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- Display Chart 2 -->
                            {!! $chart4->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>

    </div>


    <!-- Load Chart Libraries and Scripts -->
    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
    {!! $chart2->renderJs() !!}
    {!! $chart3->renderJs() !!}
    {!! $chart4->renderJs() !!}
@endsection
