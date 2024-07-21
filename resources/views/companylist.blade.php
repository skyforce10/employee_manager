@extends('layouts.app')
<!DOCTYPE html>
<html>

<script src="{{ asset('css/dataTables.bootstrap4.min.css') }}"></script>
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

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
        Company deleted successfully!
    </div>

    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-md-12">
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>
        </div>

        <table id="company-table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Website</th>
                    <th>Company ID</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- Table data will go here -->
            </tbody>
        </table>
    </div>
</section>
@endsection
<script type="text/javascript">
    $(document).ready(function() {
        var comptable = $('#company-table').DataTable({
            processing: true,
            searching: true,
            serverSide: false,
            lengthChange: false,
            "pageLength": 30,
            ajax: "{!! route('getcopanies') !!}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'website',
                    name: 'website'
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
            comptable.search($(this).val()).draw();
        });
    });

    $(document).on('click', '.edit-icon', function() {
        var id = $(this).data('id');
        var url = '{{ route("companyedit", ":id") }}';
        url = url.replace(':id', id);
        window.location.href = url;
    });

    $(document).on('click', '.delete-icon', function() {
        var id = $(this).data('id');
        var confirmed = confirm('Are you sure you want to delete this company?');
        if (confirmed) {
            $.ajax({
                url: '/company/delete/' + id,
                type: 'get',
                success: function(result) {
                    $('#company-table').DataTable().row($(this).parents('tr')).remove().draw();
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