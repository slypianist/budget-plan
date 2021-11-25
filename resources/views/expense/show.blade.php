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
                                <td>
                                    Repairs and maintenance
                                </td>
                                <td>
                                    1,836,500.00
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td colspan="2">
                                    <p><b>Prior Utilization in Amount: </b></p>
                                    <p>Current expense:</p>
                                    <p>Current Expense(if approved):</p>
                                    <p>Available budget:</p>
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
                                <b>Utilization(% of budget)</b>
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
                                    {{$eitem->amount}}
                                </td>
                            </tr>

                            @endforeach

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
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                               <h3>Comment</h3>
                            <textarea name="comment" id="" cols="30" rows="5" class="form-control"></textarea>

                            </div>

                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>

@endsection
