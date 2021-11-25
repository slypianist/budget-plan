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
                    <h3>Add Budget</h3>
                </div>
                    <div class="card-body">
                        <form action="{{route('budget.update', $budget->id)}}" method="post">
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
                                <label for="head">Head</label>
                                <input type="text" name="head" id="" class="form-control" value="{{$budget->head}}">
                            </div>
                            <div class="mb-3">
                                <label for="head">Amount</label>
                                <input type="text" name="amount" id="" class="form-control" value="{{$budget->amount}}">
                            </div>

                            <div class="mb-3">
                                <label for="head">Balance</label>
                                <input type="text" name="balance" id="" class="form-control" value="{{$budget->balance}}" readonly>
                            </div>

                            <input type="submit" value="Submit" class="btn btn-primary">
                            @csrf
                            @method('PATCH')

                        </form>
                    </div>

            </div>
        </div>
    </div>
</div>

@endsection
