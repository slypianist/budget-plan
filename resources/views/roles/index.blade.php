@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2>All User Roles</h2>
                    <a href="{{route('roles.create')}}"><button class="btn btn-success">New</button></a>
                </div>
                <div class="card-body">
                    @include('includes.success')
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th width="250px">Name</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td><a href="{{route('roles.edit', $role->id)}}"><button class="btn btn-primary btn-sm ">Edit</button></a>
                                    <form action="{{route('roles.destroy', $role->id)}}" method="post"style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                    <a href=""><button class="btn btn-danger btn-sm">Delete</button></a>

                                </form>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
