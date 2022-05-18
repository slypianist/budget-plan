@extends('layouts.app');
@section('content')
<div class="container">


<div class="row justify-content-center" >

        <div class="pull-left">
            <h2>Create User</h2>
        </div>
        <div class="pull-right mb-3">
            <a href="{{route('users.index')}}" class="btn btn-success">Back</a>
        </div>

</div>

@if (count($errors) > 0)
<br>
<div class="alert alert-danger">
    <strong>Whoops! An error Occurred</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{$error}}</li>

        @endforeach
    </ul>
</div>

@endif

<form action="{{route('users.update', $user->id)}}" method="post">

    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="form-group">
                <strong>First Name</strong>
                <input type="text" name="fname" id="" value="{{$user->fname}}" class="form-control">
            </div>

            <div class="form-group">
                <strong>Last Name</strong>
                <input type="text" name="lname" id="" value="{{$user->lname}}" class="form-control">
            </div>

            <div class="form-group">
                <strong>Email</strong>
                <input type="email" name="email" id="" value="{{$user->email}}" class="form-control" readonly>
            </div>

            <div class="form-group">
                <strong>Designation</strong>
                <input type="text" name="designation" id="" class="form-control" value="{{$user->designation}}">
            </div>

            <div class="form-group">
                <strong>Password</strong>
                <input type="password" name="password" id="" class="form-control">
            </div>

            <div class="form-group">
                <strong>Role</strong>
                    <select name="roles[]" id="" class="form-control" multiple>Roles
                        @foreach ($roles as $role)
                        <option value="{{$role->id}}" @if (in_array($role->id, $userRole))
                            selected

                        @endif>{{$role->name}}</option>

                        @endforeach

                    </select>
            </div>
            <input type="submit" value="Submit" name="submit" class="btn btn-success btn-md">
        </div>



    </div>

    @csrf
    @method('PATCH')
</form>

</div>

@endsection

