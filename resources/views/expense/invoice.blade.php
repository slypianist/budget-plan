@extends('layouts.app')
@section('content')

<div class="card container">
    <div class="card-header">
        <h5 class="card-title">Vendor Payment Details</h5>
    </div>
    <div class="card-body">
        {{-- <h5 class="card-title">Vendor Payment Details</h5> --}}
        <p class="card-text">

            <table class="table table-light caption-top">
               
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Invoice</th>
                        <th>Account Number</th>
                        <th>Bank</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$vendor->name}}</td>
                        <td>
                            <a href="{{asset('uploads/invoices/'.$vendor->invoice)}}">Click here to view Invoice</a>
                            </td>
                            <td>{{$vendor->account}}</td>
                            <td>{{$vendor->bank}}</td>
                    </tr>
                </tbody>
            </table>


        </p>
    </div>
    
</div>
    
@endsection