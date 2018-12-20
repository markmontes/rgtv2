@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <form id="testpost" method="POST" action="{{ route('reports.create') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-header">New Report</div>
                    <div class="card-body">

                    @if($addStatus=="save")
                        <div class="card bg-success text-white">
                            <div class="card-body">Report Added!</div>
                        </div>
                        <br>
                    @endif
    
                    Report Name<br>
                    <input type="text" name="report_name" class="form-control" required><br>

                    Client<br>
                    <input type="text" name="client" class="form-control"><br>
                        
                    Upload Excel File<br>
                    <input type="file" name="file"  class="btn btn-primary" accept=".xlsx"><br><br>

                    Description<br>
                    <textarea id="description" name="description" class="form-control"></textarea><br>

                    
                    <input type="submit" value="Upload And Save" name="submit" class="btn btn-primary form-control">
                </form> 
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">My Reports</div>
                <div class="card-body">

                     <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Report Name</th>
                                <th>Last Update</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php ($num=1) @endphp
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{ $num }}</td>
                                    <td>{{ $report->report_name }}</td>
                                    <td>{{ $report->updated_at->diffForHumans() }}</td>
                                    <td>{{ $report->status }}</td>
                                    <td>
                                        <a href="/reports/manage/{{ $report->id }}" target="_blank">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                    </td>
                                </tr>
                                @php ($num++) @endphp
                            @endforeach
                        </tbody>
                    
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
