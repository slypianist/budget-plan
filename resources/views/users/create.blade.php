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

<form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">

    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="form-group">
                <strong>First Name</strong>
                <input type="text" name="fname" id="" class="form-control" required>
            </div>

            <div class="form-group">
                <strong>Last Name</strong>
                <input type="text" name="lname" id="" class="form-control" required>
            </div>

            <div class="form-group">
                <strong>Email</strong>
                <input type="email" name="email" id="" class="form-control" required>
            </div>

            <div class="form-group">
                <strong>Department</strong>
                <input type="text" name="dept" id="" class="form-control" required>
            </div>

            <div class="form-group">
                <strong>Password</strong>
                <input type="password" name="password" id="" class="form-control" required>
            </div>

            <div class="form-group">
                <strong>Confirm Password</strong>
                <input type="password" name="confirm-password" id="" class="form-control">
            </div>

            <div class="form-group">
                <strong>Signature</strong>
                <input type="file" name="signature" id="">
            </div>

            <div class="form-group">
                <strong>Role</strong>
                    <select name="roles[]" id="" class="form-control" multiple required>Roles
                        @foreach ($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>

                        @endforeach

                    </select>


            </div>
            <input type="submit" value="Submit" name="submit" class="btn btn-success btn-md">
        </div>



    </div>

    @csrf
</form>

</div>

@endsection

