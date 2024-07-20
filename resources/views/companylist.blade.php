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
                <th>Name</th>
                <th>Address</th>
                <th>website</th>
                <th></th>
                <th></th>
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
                ajax: "{!! route('getcopanies') !!}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'address', name: 'address' },
                    { data: 'website', name: 'website' },
                    { 
                data: null,
                name: 'action_edit',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<i class="fas fa-edit" aria-hidden="true"></i>';
                }
            }, { 
                data: null,
                name: 'action_delete',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<i class="fa fa-trash-alt" aria-hidden="true"></i>';
                }
            }
                ]
            });
        });
    </script>
</body>
</html>

