@extends('layouts.app')

<script src="{{ asset('css/dataTables.bootstrap4.min.css') }}"></script>
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')

<section>

<div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <table id="company-table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Nb Employee</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <canvas id="employeePieChart"></canvas>

                </div>
            </div>
        </div>
        
</section>
@endsection
<script type="text/javascript">
    $(document).ready(function() {
        $('#company-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            searching: false,
            lengthChange: false,
            info: false,
            ajax: "{!! route('getstatistic') !!}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'nbemployee',
                    name: 'nbemployee'
                }
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var data = api.rows().data();
                var labels = [];
                var employeeCounts = [];

                data.each(function(value, index) {
                    labels.push(value.name);
                    employeeCounts.push(value.nbemployee);
                });

                updatePieChart(labels, employeeCounts);
            }
        });
    });

    function updatePieChart(labels, data) {
        var ctx = document.getElementById('employeePieChart').getContext('2d');

        window.employeePieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw;
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
</script>
</body>

</html>