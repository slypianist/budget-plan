@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2>Budget Clear Expense</h2>
                </div>


            <div class="card-body">
                <form action="{{route('budget.clear', $expense->id)}}" method="post"  >

                    <div class="mb-3">
                        <label for="description">Expense Description</label>
                        <input type="text" name="expense" id="" class="form-control" value="{{$expense->description}}" readonly>
                    </div>
                <div class="mb-3">

                    <label for="budget">Budget</label>
                    <select name="budget" id="" class="form-control">
                        @foreach ($budgets as $budget)
                        <option value="{{$budget->id}}">{{$budget->head}}</option>

                        @endforeach
                    </select>

                </div>
                    <input type="submit" value="Budget Clear" class="btn btn-primary btn-sm">
                    @method('PATCH')
                    @csrf
                </form>


            </div>

            </div>


        </div>
    </div>
</div>

@endsection
