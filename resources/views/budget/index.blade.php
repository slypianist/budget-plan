@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2>Budget Head</h2>
                    <a href="{{route('budget.create')}}"><button class="btn btn-success">New</button></a>
                </div>
                <div class="card-body">
                    @include('includes.success')
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th width="250px">Budget Head</th>
                                <th>Amount(N)</th>
                                <th>Balance(N)</th>
                                <th width="250px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets as $budget)
                            <tr>
                                <td>{{$budget->id}}</td>
                                <td>{{$budget->head}}</td>
                                <td>{{number_format($budget->amount, 2 , '.', ',')}}</td>
                                <td>{{number_format($budget->balance, 2 , '.', ',')}}</td>
                                <td><a href="{{route('budget.edit', $budget->id)}}"><button class="btn btn-primary btn-sm">Edit</button></a>
                                    <form action="{{route('budget.destroy', $budget->id)}}" method="post" style="display: inline">
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
