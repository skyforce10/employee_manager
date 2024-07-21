@extends('layouts.app')

@section('content')
<style>
        .btn-custom {
            padding-top: 50px;
            padding-bottom: 50px;
            font-size: 24px;
        }
    </style>
  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif  
<div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <button type="button" class="btn btn-primary btn-lg btn-block btn-custom d-flex flex-column align-items-center"
                onclick="callcompanylist()">
                    <i class="fas fa-home fa-2x mb-5"></i> Companies list
                </button>
            </div>
            @if (auth()->user()->role == 'admin')
            <div class="col-lg-3 col-md-6 mb-4">
                <button type="button" class="btn btn-secondary 
                btn-lg btn-block btn-custom d-flex flex-column 
                align-items-center" onclick="callcompanymanager()">
                    <i class="fas fa-building fa-2x mb-5"></i> Add new company
                </button>
            </div>
            @endif
            <div class="col-lg-3 col-md-6 mb-4">
                <button type="button" class="btn btn-success btn-lg btn-block btn-custom d-flex flex-column align-items-center"
                onclick="callemployeelist()">
                    <i class="fas fa-user-circle fa-2x mb-5"></i> Employees list
                </button>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <button type="button" class="btn btn-danger btn-lg btn-block btn-custom d-flex flex-column align-items-center"
                onclick="callemployeemanager()">
                    <i class="fas fa-user-plus fa-2x mb-5"></i> Add new employee
                </button>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <button type="button" class="btn btn-warning btn-lg btn-block btn-custom d-flex flex-column align-items-center"
                onclick="callcompstatistic()">
                    <i class="fas fa-print fa-2x mb-5"></i> Company Statistics
                </button>
            </div>
        </div>
    </div>
@endsection

<script>
        function callcompanymanager() {
            window.location.href = "{{ route('company') }}";
        }
        function callcompanylist() {
            window.location.href = "{{ route('companylist') }}";
        }
        function callemployeemanager() {
            window.location.href = "{{ route('employeemanager') }}";
        }
        function callemployeelist() {
            window.location.href = "{{ route('employeelist') }}";
        }
        function callcompstatistic() {
            window.location.href = "{{ route('statistic') }}";
        }
    </script>
