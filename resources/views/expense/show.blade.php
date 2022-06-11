@extends('layouts.app')
@section('content')
<div class="container">
    <div class="alert alert-success" style="display: none"></div>
<div class="row justify-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>EXPENSE DETAILS</h2>
                @if ($expense->md_approval)
                <a href="{{route('show.pdf')}}"><button type="button" class="btn btn-success btn-sm float-end">Export as PDF</button></a>
                @endif
             
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>

                            <p>Initiator: {{$expense->user->fname}} {{$expense->user->lname}} </p>
                            Dept: {{$expense->user->dept}}
                            <br>
                          <img src="{{asset('uploads/signatures/'.$expense->user->signature)}}" alt="" width="10%" height="10%" srcset="">
                          <br>
                          {{date_format($expense->created_at, 'd-M-Y')}}

                        </td>
                        <td><p>Approving HOD/HoU: {{$hod->fname}} {{$hod->lname}}</p>
                            Name / Signature / Date:
                            @if ($expense->hod_approval == 1)
                            <br>

                            <img src="{{asset('uploads/signatures/'.$hod->signature)}}" alt="" height="20%" width="20%">
                                
                            @endif
                            
                        </td>
                            



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
                                
                                    Name / Signature
                            
                                <br>
                                    Budget Officer: {{$bo->fname}} {{$bo->lname}}
                                    <br>
                                    @if ($expense->budget_cleared == 1)

                                    <img src="{{asset('uploads/signatures/'.$bo->signature)}}" alt="" height="5%" width="5%">
                                        
                                    @endif
                                    
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
                            <br><img src="{{asset('uploads/signatures/'.$cfo->signature)}}" alt="" width="50%" height="50px" srcset="">

                            @endif
                        </td>
                        <td></td>
                        {{-- <td></td> --}}
                        <td>
                            <br><b>Approved by:</b>
                            <br>Chief Executive Officer
                            @if ($expense->md_approval)
                            <br>{{$md->fname}} {{$md->lname}}
                            <br><img src="{{asset('uploads/signatures/'.$md->signature)}}" alt="" width="50%" height="50px" srcset="">


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
                                   <a href="{{route('vendor.show', $vendor->id)}}">
                                    <strong>Name:</strong>  {{$vendor->name}}
                                
                                </a>
                                  
                               </p>
                               <p>
                                   <strong>Account Number:</strong> {{$vendor->account}}
                               </p>
                               <p>
                                   <strong>Bank:</strong> {{$vendor->bank}}
                               </p>

                              

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

                                    <form action="{{route('expense.approvalhod', $expense->id)}}" method="POST">
                                     <input type="submit" value="Approve Expense for Clearing" class="btn btn-primary">
                                     @csrf
                                     @method('PATCH')
                                 </form>
     
                                    @endcan
                                   </td>

                                   <td>
                                    @can('md-approval')
                                    <form action="{{route('expense.approvalmd', $expense->id)}}" method="post">
     
                                     <input type="submit" value="Approve Expense" class="btn btn-primary btn-md">
                                     <button type="button" id="addNewComment" class="btn btn-danger d-inline m-5 edit" data-id="{{$expense->id}}">Disapprove</button>
                                     @csrf
                                     @method('PATCH')
     
                                    </form>
                                    @endcan
                                   </td>

                                   <td>

                                    @can('cfo-approval')
                                    <form action="{{route('expense.approvalcfo', $expense->id)}}" method="post">
     
                                     <input type="submit" value="Recommend Expense for approval" class="btn btn-primary">
                                     <button type="button" id="cfoComment" class="btn btn-danger d-inline m-5 edit-form" data-expid="{{$expense->id}}">Disapprove</button>
                                     @csrf
                                     @method('PATCH')
                                    </form>
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

{{-- Modal Section for MD comment --}}

@section('modal-section')
<div class="modal fade" id="comment-model">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="comTitle"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="post" id="addCommentForm" name="addCommentForm" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="hod_com" id="comLbl"></label>
                        <div class="col-sm-12">
                            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"></textarea>
                            <small id="error" style="display: none"></small>
                        </div>
                    </div>
                    <button type="button" id="btn-save" class="btn btn-success">Add Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- CFO Modal --}}

<div class="modal fade" id="cfo-comment-model">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cfoTitle"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="post" id="addCfoForm" name="addCfoForm" class="form-horizontal">
                    <input type="hidden" name="expid" id="expid">
                    <div class="form-group">
                        <label for="cfo_com" id="cfoLbl"></label>
                        <div class="col-sm-12">
                            <textarea name="om" id="com" cols="30" rows="5" class="form-control"></textarea>
                            <small id="errors" style="display: none"></small>
                        </div>
                    </div>
                    <button type="button" id="btn-cfo" class="btn btn-success">Add Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

