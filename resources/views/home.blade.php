@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if ($user->fname=="Theodore" || $user->fname == "Nyaudo")


                <div class="card-header bg-success" style="color: white">Welcome <strong>{{$user->fname}} (Substantive CFO)</strong></div>

                @else
                <div class="card-header bg-success" style="color: white">Welcome <strong>{{$user->fname}} {{$user->lname}}</strong></div>
                @endif


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="alert alert-success" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                        <p> {{ __('You are logged in!') }} </p>
                    </div>




                    @if ($data['expense_count']== 0)

                    Total Expense Initiated: {{$data['expense_count']}}

                    <p>You have initiated {{$data['expense_count']}} Expense.</p>



                    @else
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
                                    @foreach ($data['user_expense'] as $expense)


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
                                        <td>{{date_format($expense->created_at, 'D, d-m-Y')}}</td>
                                        <td>{{$expense->status}}</td>
                                        <td>
                                            @if (auth()->user()->can('expense-edit') && auth()->user()->can('expense-delete'))
                                            <a href="{{route('expense.edit', $expense->id)}}"><button class="btn btn-primary btn-sm">Edit</button></a>
                                            <form action="{{route('expense.send', $expense->id)}}" method="GET" style="display: inline">

                                             <button class="btn btn-danger btn-sm">Send for approval</button>

                                                @csrf
                                            </form>
                                            @endif


                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                <div class="d-flex justify-content-center">
                   {{ $data['user_expense']->links() }}
                </div>
                    @endif


                </div>

            </div>
        </div>
    </div>
</div>
@endsection
