@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <table class="table table-bordered yajra-datatable">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Doctor</th>
                                <th>Surname</th>
                                <th>Image</th>
                                <th>Clinic Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function () {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.doctors') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'doctor_name', name: 'doctor_name'},
                    {data: 'surname', name: 'surname'},
                    {data: 'image', name: 'image'},
                    {data: 'clinic_name', name: 'clinic_name'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
@endsection


