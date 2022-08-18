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
                                <th>Clinic</th>
                                <th>D.Name</th>
                                <th>D.Surname</th>
                                <th>Date</th>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function () {
            var id="{{$id}}";
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('get.appointments',$id)}}" ,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'clinic_name', name: 'clinic_name'},
                    {data: 'name', name: 'name'},
                    {data: 'surname', name: 'surname'},
                    {data: 'date', name: 'date'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });

        $('.form-check-input').on('change',function (){
            const value =$(this).value() ;
            const isDisable =  $(this).is(':clicked') ? true : false;
            $.ajax({
                type:'POST',
                url:"{{route('take.appointment.from.doctor')}}",
                data:{
                    value:value,
                    isDisable:isDisable
                },
                success:function (){
                   //do some things
                }
            })
        })
    </script>

@endsection


