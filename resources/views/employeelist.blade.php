@extends('layouts.app')
<!DOCTYPE html>
<html>
<head>
    <title>Laravel DataTables</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
</head>
@section('content')

<section>
<body>
<div class="container mt-5">
    <table id="users-table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Birth Date</th>
                <th>Married</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
    </section>
    @endsection
    <script type="text/javascript">
       
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('getemployees') !!}",
                columns: [
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email', name: 'email' },
                    { data: 'company', name: 'email' },
                    { data: 'date_of_birth', name: 'date_of_birth' },
                    { data: 'married', name: 'married' },
                    { data: 'phone_numbers', name: 'phone_numbers' },
                ]
            });
        });
    </script>
</body>
</html>

