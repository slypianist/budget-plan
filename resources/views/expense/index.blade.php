@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Expenses</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Expense Description</th>
                        <th>Budget Head</th>
                        <th>Budget Amount</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)


                    <tr>
                        <td><a href="{{route('expense.show', $expense->id)}}">{{$expense->description}}</a></td>
                        <td></td>
                        <td></td>
                        <td>{{date_format($expense->created_at, 'd-m-Y')}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
<div class="d-flex justify-content-center">
    {{ $expenses->links() }}
</div>

        </div>
        <div class="card-footer">
            <p class="text-center text-primary"><small>SYMOLE Technologies Ltd</small></p>
        </div>
    </div>
</div>
@endsection



