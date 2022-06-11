@extends('layouts.app')
@section('content')
<div class="container">
    <div class="alert alert-success" style="display: none"></div>
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

                            <p>Initiator: {{-- {{$expense->user->fname}} {{$expense->user->lname}}  --}}</p>
                            <p>Dept: {{-- {{$expense->user->dept}} --}}</p>
                            <p>Date/Signature: {{$expense->created_at}}</p>
                          <img src="{{-- {{asset('uploads/signatures/'.$expense->user->signature)}} --}}" alt="" sizes="" srcset="">
                            </p>

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
                            <br><b>Recommended for approval</b>
                            <br>Chief Finance Officer

                            @if ($expense->cfo_approval)
                            <br>{{$cfo->fname}} {{$cfo->lname}}
                            <br><img src="{{asset('storage/uploads/signatures/'.$cfo->signature)}}" alt="" width="50%" height="50px" srcset="">

                            @endif
                        </td>
                        <td></td>
                        {{-- <td></td> --}}
                        <td>
                            <br><b>Approved by:</b>
                            <br>Chief Executive Officer
                            @if ($expense->md_approval)
                            <br>{{$md->fname}} {{$md->lname}}
                            <br><img src="{{asset('storage/uploads/signatures/'.$md->signature)}}" alt="" width="50%" height="50px" srcset="">


                            @endif
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                               <h3>Comments</h3>
                               <b>Kindly Pay into:</b>
                               <p>
                                   {{-- <a href="{{route('vendor.show', $vendor->id)}}">
                                    <strong>Name:</strong>  {{$vendor->name}} --}}
                                
                                </a>
                                  
                               </p>
                               {{-- <p>
                                   <strong>Account Number:</strong> {{$vendor->account}}
                               </p>
                               <p>
                                   <strong>Bank:</strong> {{$vendor->bank}}
                               </p>
 --}}
                              

                               @if ($expense->cfo_comment)

                               <td>

                               <h4>CFO's COMMENT</h4>

                               <p>{{$expense->cfo_comment}}</p>

                               </td>

                               @endif
                               {{-- @isset()

                               @endisset --}}
                               

                            </div>

                        </td>

                        <td>
                            <h4>MD's COMMENT</h4>

                            <p>{{$expense->md_comment}}</p>

                           

                               <tr>
                                   <td>
                                    @can('hod-approval')

     
                                    @endcan
                                   </td>

                                   <td>
                                    @can('md-approval')
                                  
                                    @endcan
                                   </td>

                                   <td>

                                    @can('cfo-approval')
                                    
                                    @endcan

                                   </td>
                               </tr>
                            
                        </td>

                        
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

