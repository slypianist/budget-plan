@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Users Management</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right mb-3">
                <a href="{{route('users.create')}}" class="btn btn-success">Create user</a>
            </div>
            @include('includes.success')
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>

                    </tr>

                </thead>
                <tbody>
                    @foreach ($data as $user)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$user->fname .' '. $user->lname}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $role)
                            <label class="badge badge-success">{{$role}}</label>
                            @endforeach

                            @endif
                        </td>
                        <td> <a href="users/{{$user->id}}"><button class="btn btn-sm btn-primary">View</button></a>
                            <a href="users/{{$user->id}}/edit"><button class="btn btn-sm btn-danger">Edit</button></a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

