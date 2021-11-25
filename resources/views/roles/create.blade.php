@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            @if (Session::has('message'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
           <p>{{Session::get('message')}}</p>
        </div>
        @endif
            <div class="card">
                <div class="card-header">
                    <h3>Add Role</h3>
                </div>
                    <div class="card-body">
                        <form action="{{route('roles.store')}}" method="post">
                            <div class="mb-3">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>

                                        @endforeach
                                    </ul>
                                </div>

                                @endif
                                <label for="name"><strong>Name</strong></label>
                                <input type="text" name="name" id="" class="form-control" required>
                            </div>

                            <div class="mb-3">


                                <label for="Permission"><strong>Permissions</strong></label>
                                @foreach ($permissions as $permission)
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="flexCheckDefault" value="{{$permission->id}}">
                                <label class="form-check-label" for="{{$permission->name}}" >{{$permission->name}}</label>
                            </div>
                            @endforeach
                            </div>


                            <input type="submit" value="Submit" class="btn btn-primary">
                            @csrf

                        </form>
                    </div>

            </div>
        </div>
    </div>
</div>

@endsection
