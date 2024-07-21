@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

@section('content')
<style>
    .edit-icon,
    .delete-icon {
        cursor: pointer;
        margin-right: 10px;
    }
    .dataTables_filter {
    display: none;
  }
</style>
<section>
<div class="alert alert-success" id="success-alert" style="display: none;">
        Employee deleted successfully!
    </div>
    <div class="container mt-5">
    <div class="row mb-3">
            <div class="col-md-12">
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>
        </div>
        <table id="employee-table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Birth Date</th>
                    <th>Married</th>
                    <th>emp_id</th>
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
        var emptable=$('#employee-table').DataTable({
            processing: true,
            searching: true,
            serverSide: false,
            lengthChange: false,
            "pageLength": 30,
            ajax: "{!! route('getemployees') !!}",
            columns: [{
                    data: 'first_name',
                    name: 'first_name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'date_of_birth',
                    name: 'date_of_birth'
                },
                {
                    data: 'married',
                    name: 'married',
                    render: function(data, type, row) {
                        return data == 0 ? 'No' : 'Yes';
                    }
                },

                {
                    data: 'id',
                    name: 'id',
                    visible: false
                },
                {
                    data: null,
                    name: 'action_edit',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<i class="fas fa-edit edit-icon" aria-hidden="true" data-id="${row.id}"></i>`;
                    }
                }, {
                    data: null,
                    name: 'action_delete',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<i class="fa fa-trash-alt delete-icon" aria-hidden="true" data-id="${row.id}"></i>`;
                    }
                }
            ]
        });

        $('#searchInput').on('keyup', function() {
            emptable.search($(this).val()).draw();
        });
    });

    $(document).on('click', '.edit-icon', function() {
        var id = $(this).data('id');
        var url = '{{ route("employeeedit", ":id") }}';
        url = url.replace(':id', id);
        window.location.href = url;
    });

    $(document).on('click', '.delete-icon', function() {
        var id = $(this).data('id');
        var confirmed = confirm('Are you sure you want to delete this employee?');
        if (confirmed) {
            $.ajax({
                url: '/employee/delete/' + id, 
                type: 'get',
                success: function(result) {
                    $('#employee-table').DataTable().row($(this).parents('tr')).remove().draw();
                    $("#success-alert").fadeIn(); 
                    setTimeout(function() {
                        $("#success-alert").fadeOut(); 
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        alert('You do not have admin access.');
                    }
                }
            });
        }
    });
</script>
</body>

</html>