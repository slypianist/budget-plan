@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            @if (Session::has('message'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p>{{Session::get('message')}}</p>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>Expense Overhead</h3>
                </div>
                <div class="card-body form-group">
                    <form action="{{url('expense')}}" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>

                                        @endforeach
                                    </ul>
                                </div>

                            @endif
                            <label for="name" class="form-label"><strong>Expense Description</strong></label>
                            <input type="text" name="description" id="" class="form-control" value="{{$expense->description}}">
                        </div>

                        <div class="mb-3">
                            <label for="budget"><strong>Budget head</strong></label>
                            <select name="budget" id="" class="form-control">
                                @foreach ($budgets as $budget)
                                <option value="{{$budget->id}}">{{$budget->head}}</option>
                                @endforeach

                            </select>
                        </select>
                        </div>

                        <label for="hod"><strong>Approving HOD</strong></label>
                        <div class="input-group mb-3" >

                            <select name="hod" id="" class="form-control">
                                <option value="Sylvester Umole">Sylvester Umole </option>
                            </select>
                        </div>
                        <label for="Expense Description"><strong>Expense Description</strong></label>
                <div class="mb-3">

                        <table class="table table-bordered">
                            <thead class="bg-success">
                                <tr>
                                    <th>Qty</th>
                                    <th>Item Description</th>
                                    <th>Amount</th>
                                    <th><a href="#/" class="btn btn-info btn-sm addRow">+</a></th>

                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach ($ex_items as $item)
                                <tr>
                                    <td><input type="text" name="multi[0][qty]" class="form-control" value="{{$item->qty}}" ></td>
                                    <td><input type="text" name="multi[0][item]" class="form-control" value="{{$item->item}}" ></td>
                                    <td><input type="text" name="multi[0][amount]" class="form-control" value="{{$item->amount}}"></td>
                                </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <td colspan="3"><input type="text" name="total" class="form-control" aria-colspan="40"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mb-3">
                        <h2>Vendor Details</h2>
                       <table class="table table-bordered">
                           <thead>
                               <tr>
                                   <th>Name</th>
                                   <th>Account Number</th>
                                   <th>Bank</th>
                                   <th>Invoice</th>
                               </tr>
                           </thead>
                           <tbody id="tb">
                               <tr>
                                   <td>
                                       <input type="text" name="name" id="" class="form-control" value="{{$vendors->name}}" required>
                                   </td>
                                   <td>
                                       <input type="text" name="account" id="" class="form-control" value="{{$vendors->account}}" required>
                                   </td>
                                   <td>
                                       <input type="text" name="bank" id="" class="form-control" value="{{$vendors->bank}}" required>
                                   </td>
                                   <td>
                                       <input type="file" name="invoice" id="" class="form-control" value="{{$vendors->invo}}">
                                   </td>
                               </tr>
                           </tbody>
                       </table>
                    </div>

                        <div class="mb-3">
                            <label for="comments"><strong>Comments</strong></label>
                            <textarea name="comment" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>


                        <input type="submit" value="Submit" class="btn btn-primary btn-md">
                        @csrf

                    </form>

                    </div>
                    @auth
                    <div class="card-footer">
                        <small>SYMOLE Technologies</strong>
                    </div>
                @endauth
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  var i = 0;
    $('.addRow').on('click', function () {
        addRow();
    });

    function addRow() {

        ++i;
        var tr = '<tr>' +

            '<td>'+ '<input type="text" name="multi['+i+'][qty]" class="form-control"></td>' +
            '<td>' + '<input type="text" name="multi['+i+'][item]" class="form-control"></td>'+
            '<td>'+ '<input type="text" name="multi['+i+'][amount]" class="form-control"></td>'+
            '<td>' + '<a href="#/" class="btn btn-danger btn-sm remove">-</a></td>'+

            '</tr>';

            $('#tbody').append(tr);

    };

    $('#tbody').on('click', '.remove', function() {
        $(this).parent().parent().remove();

    });

    </script>





    {{-- <script type="text/javascript">
var i = 0;
    $('.addVendor').on('click', function () {
        addVendor();
    });

    function addVendor() {

        ++i;
        var tr = '<tr>' +

            '<td>'+ '<input type="text" name="vendor['+i+'][name]" class="form-control"></td>' +
            '<td>' + '<input type="text" name="vendor['+i+'][account]" class="form-control"></td>'+
            '<td>'+ '<input type="text" name="vendor['+i+'][bank]" class="form-control"></td>'+
            '<td>'+ '<input type="file" name="vendor['+i+'][invoice]" class="form-control"></td>'+
            '<td>' + '<a href="#/" class="btn btn-danger btn-sm remove">-</a></td>'+

            '</tr>';

            $('#tb').append(tr);

    };

    $('#tb').on('click', '.remove', function() {
        $(this).parent().parent().remove();

    });
    </script> --}}

@endsection
