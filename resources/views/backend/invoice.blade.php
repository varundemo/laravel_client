@extends('layouts.backend') 

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Contractor Name</th>
                        <th>Contractor ID</th>
                        {{-- <th>Payment Id</th> --}}
                        <th>Amount</th>
                        <th>Receipt URL</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payment_details as $key=>$detail)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $detail->contractor->first_name }} {{ $detail->contractor->last_name }}</td>
                        <td>{{ $detail->contractor_id }}</td>
                        {{-- <td>{{ $detail->payment_id }}</td> --}}
                        <td>{{ $detail->amount }}</td>
                        <td>
                            <a href="{{ $detail->receipt_url }}" target="_blank" class="btn btn-warning" download>Download Invoice</a>
                        </td>
                        <td>{{ date("Y-m-d", strtotime($detail->created_at))  }}</td>
                        <td>{{ date("H:i", strtotime($detail->created_at))  }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!-- Summernote JS -->
<script src="{{asset('assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
@endsection