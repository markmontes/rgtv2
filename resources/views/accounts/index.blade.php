@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Accounts</div>
                <div class="card-body">

                    <button class="btn btn-primary col-lg-4 m-3">Add Account</button>

                        @php ($num=1) @endphp
                        <table class="table table-stripped">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $num }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <button class="btn btn-primary pl-1 pb-0 pr-0">
                                                <i class="fa fa-edit fa-2x text-white" ></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @php ($num++) @endphp
                                @endforeach
                            </tbody>
                        </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
