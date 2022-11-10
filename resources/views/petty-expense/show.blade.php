@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="text-align:center" >
                    REQUISITION FORM
                </div>
                <div class="card-body">
                    <h5 class="card-title" style="text-align:center">{{$petty->description}}</h5>
                    <div class="row">
                        <div class="col-md-10">
                            <p class="card-text">No: <u>{{$petty->exp_no}}</u></p>
                        </div>
                        <div class="col-md-2">
                            <p class="card-text move-right">Date: <u>{{date_format($petty->created_at, 'd-m-Y')}}</u></p>

                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <th>S/N</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                </thead>
                                <tbody>
                                    @foreach ($pitems as $pitem)
                                    

                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$pitem->item}}</td>
                                        <td>{{$pitem->qty}}</td>
                                        <td>{{$pitem->rate}}</td>
                                        <td>{{$pitem->amount}}</td>
                                    </tr>
                                    @endforeach
                                        
                                </tbody>
                            </table>
                            <span class="float-right">Total:N<b>{{$petty->total}}</b></span>
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    Footer
                </div>
            </div>
        </div>
    </div>
</div>

    
@endsection

<h2></h2>
