@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Expenses</h3>
        </div>
        <div class="card-body">
            @include('includes.success')
            <table class="table table-bordered">
                <thead class="bg-success" style="color: rgba(246, 243, 30, 0.938)">
                    <tr>
                        <th>S/N</th>
                        <th>Expense Description</th>
                        <th>Budget Head</th>
                        @can('budget-clear')
                        <th>Budget Balance(₦)</th>
                        @endcan
                        <th>Expense Amount(₦)</th>
                        <th>Date Created</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)


                    <tr>
                        <td>{{++$i}}</td>

                        <td><a href="{{route('expense.show', $expense->id)}}">{{$expense->description}}</a></td>
                        @if (!empty($expense->budget->head))
                        <td>{{$expense->budget->head}} </td>

                        @else

                        <td></td>

                        @endif
                            @can('budget-clear')

                            @if (!empty($expense->budget_exp_bal))
                            <td>{{number_format($expense->budget_exp_bal, 2, '.', ',')}}</td>

                            @else
                            <td></td>
                            @endif

                            @endcan


                        <td>{{number_format($expense->total,2,'.',',')}}</td>
                        <td>{{date_format($expense->created_at, 'd-m-Y')}}</td>
                        <td>{{$expense->status}}</td>
                        <td>
                            @if (auth()->user()->can('expense-edit') && auth()->user()->can('expense-delete'))
                            {{-- <a href="{{route('expense.edit', $expense->id)}}"><button class="btn btn-primary btn-sm">Edit</button></a> --}}
                            <form action="{{route('expense.destroy', $expense->id)}}" method="POST" style="display: inline">

                             {{-- <button class="btn btn-danger btn-sm">Delete</button> --}}
                                @method('DELETE')
                                @csrf
                            </form>
                            @endif

                            @can('budget-clear')
                            <a href="{{route('budget.check', $expense->id)}}"><button class="btn btn-primary btn-sm" id="submit">Budget Clear</button></a>
                            @endcan
                        </td>

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





