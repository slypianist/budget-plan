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
                    <h3>Petty Expense Voucher</h3>
                </div>
                <div class="card-body form-group">
                    <form action="{{route('pettyexpense.store')}}" method="post" enctype="multipart/form-data">
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
                            <input type="text" name="description" id="" class="form-control" required>
                        </div>


                        <label for="hod"><strong>Approving HOD</strong></label>
                        <div class="input-group mb-3" >

                            <select name="apv_hod" id="" class="form-control">
                                @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->fname}} {{$user->lname}} </option>
                                @endforeach

                            </select>
                        </div>
                        <label for="Expense Description"><strong>Expense Description</strong></label>
                <div class="mb-3">

                        <table class="table table-bordered">
                            <thead class="bg-success">
                                <tr>
                                    <th>Qty</th>
                                    <th>Item Description</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th><a href="#/" class="btn btn-info btn-sm addRow">+</a></th>

                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr>
                                    <td><input type="text" name="multi[0][qty]" class="form-control multi" id="qty"></td>
                                    <td><input type="text" name="multi[0][item]" class="form-control multi" id="item"></td>
                                    <td><input type="text" name="multi[0][rate]" class="form-control multi" id="rate"></td>
                                    <td><input type="text" name="multi[0][amount]" class="form-control multi amount"  id="amount"></td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <td colspan="3"><input type="text" name="total" class="form-control total" id="totalex"aria-colspan="40" readonly></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mb-3">
                        <h2>Invoice Details</h2>
                       <table class="table table-bordered">
                           <thead>
                               <tr>
                                   
                                   <th>Invoice(if any)</th>
                               </tr>
                           </thead>
                           <tbody id="tb">
                               <tr>
                                   <td>
                                       <input type="file" name="invoice" id="" class="form-control">
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

            '<td>'+ '<input type="text" name="multi['+i+'][qty]" class="form-control multi" id="qty"></td>' +
            '<td>' + '<input type="text" name="multi['+i+'][item]" class="form-control multi" id="item"></td>'+
            'td'+ '<td><input type="text" name="multi['+i+'][rate]" class="form-control multi" id="rate"></td>'+
            '<td>'+ '<input type="text" name="multi['+i+'][amount]" class="form-control amount multi" data-action="sumExpense" id="amount"></td>'+
            '<td>' + '<a href="#/" class="btn btn-danger btn-sm remove">-</a></td>'+

            '</tr>';

            $('#tbody').append(tr);

    };

    $('#tbody').on('click', '.remove', function() {
        $(this).parent().parent().remove();
       GrandTotal();

    });

    /* $('body').on('change', '[data-action="sumExpense"]', function() {
  evaluateTotal();
}); */

$('#tbody').on("keyup",".multi",function(){
    var parent = $(this).closest('tr');
    var quant= $(parent).find('#qty').val();
    var price= $(parent).find('#rate').val();
    console.log(price);

    $(parent).find('#amount').val(quant* price);
    GrandTotal();
  });

  function GrandTotal(){
     var sum=0;

     $('.amount').each(function(){
       sum+=Number($(this).val());
     });

     $('#totalex').val(sum);
   }
    
    </script>

@endsection