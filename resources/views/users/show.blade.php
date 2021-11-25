@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>User Details</h2>
                    <a href="/users" class="btn btn-success pull-right">Back</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$user->fname. ' '. $user->lname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->dept}}</td>
                                <td>
                                    @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $role )
                               <label class="badge badge-success">{{$role}}</label>

                                    @endforeach

                                @endif
                                </td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <form action="{{route('users.destroy', $user->id)}}" method="POST">
                                     <a href=""><button class="btn btn-danger btn-sm">Delete</button></a>
                                     @csrf
                                     @method('DELETE')

                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

