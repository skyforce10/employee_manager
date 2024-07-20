@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

@section('content')

<section>
<div class="container mt-1">
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
                ajax: "{!! route('getemployees') !!}",
                columns: [
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email', name: 'email' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'date_of_birth', name: 'date_of_birth' },
                    { data: 'married', name: 'married',
                        render: function(data, type, row) {
                           return data == 0 ? 'No' : 'Yes';
                         }
                     },
                    { data: 'phone_numbers', name: 'phone_numbers' },
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

