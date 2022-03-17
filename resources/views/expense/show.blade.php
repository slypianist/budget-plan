@extends('layouts.app')
@section('content')
<div class="container">
<div class="row justify-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>EXPENSE DETAILS</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>

                            <p>Initiator: IT & ADMIN</p>
                            <p>Name / Signature/ Date</p>
                        </td>
                        <td><p>Approving HOD:</p>
                            <p>Name / Signature / Date</p></td>
                    </tr>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Expense Description</th>
                                <th>Budget Head</th>
                                <th>Budget Amount(N)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    {{$expense->description}}
                                </td>

                                    @if (!empty($expense->budget->head))
                                    <td>{{$expense->budget->head}}
                                    @else
                                        <td></td>
                                    @endif


                                    @if (!empty($expense->budget->amount))
                                    <td>{{$expense->budget->amount}}</td>

                                    @else
                                        <td></td>
                                    @endif

                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td colspan="2">
                                    <p>Prior Utilization in Amount: <b>{{number_format($data['priorUtil'],2,'.',',')}}</b> </p>
                                    <p>Current Expense(if approved): <strong>{{$data['curExpense']}}</strong></p>
                                    <p>Total Expense(if current is approved): <strong>₦{{number_format($data['totalExp'],2,'.',',')}}</strong></p>

                                    <p>Available budget: <strong>₦{{number_format($data['availBud'],2,'.',',')}}</strong> </p>
                                </td>

                            </tr>
                        </tbody>

                        <tr>
                            <td>
                                <p>
                                    Budget Officer:
                                </p>
                                <p>
                                    Name / Signature / Date
                                </p>
                            </td>
                            <td colspan="2">
                                Utilization(% of budget): {{number_format($data['percentUtil'],2,'.',',') }} <b>%</b>
                            </td>
                        </tr>
                    </tbody>

                    <table class="table table-bodered">
                        <h2>EXPENSE DESCRIPTION</h2>
                        <thead>
                            <tr>
                                <th>ITEM DESCRIPTION</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $eitem )
                            <tr>

                                <td>
                                    {{$eitem->item}}
                                </td>
                                <td>
                                    ₦{{$eitem->amount}}
                                </td>
                            </tr>

                            @endforeach

                            <tr>
                                <td><h4>Total:</h4></td>
                                <td><h4>₦{{number_format($expense->total,2,'.',',')}}</h4></td>
                            </tr>

                        </tbody>
                    </table>

                </table>

            </div>
            <div class="card-footer">
                <table class="table">
                    <h2>EXPENSE APPROVAL</h2>
                    <tr>
                        <td>
                            <p><b>Recommended for approval</b></p>
                            <p>Chief Finance Officer</p>
                        </td>
                        <td>
                            <p><b>Approved by:</b></p>
                            <p><b>Chief Executive Officer</b></p>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                               <h3>Comments</h3>
                               <b>Kindly Pay into:</b>
                               <p>
                                  <strong>Name:</strong>  {{$vendor->name}}
                               </p>
                               <p>
                                   <strong>Account Number:</strong> {{$vendor->account}}
                               </p>
                               <p>
                                   <strong>Bank:</strong> {{$vendor->bank}}
                               </p>

                               @can('cfo-approval')
                               <form action="{{route('expense.approvalcfo', $expense->id)}}" method="post">

                                <input type="submit" value="Approve" class="btn btn-primary btn-lg">
                                @csrf
                                @method('PATCH')
                               </form>
                               @endcan

                               @can('md-approval')
                               <form action="{{route('expense.approvalmd', $expense->id)}}" method="post">

                                <input type="submit" value="Approve" class="btn btn-primary btn-lg">
                                @csrf
                                @method('PATCH')

                               </form>
                               @endcan




                            </div>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
