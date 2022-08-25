@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Petty Cash Expenses</h3>
        </div>
        <div class="card-body">
            @include('includes.success')
            <table class="table table-bordered">
                <thead class="bg-success" style="color: rgba(246, 243, 30, 0.938)">
                    <tr>
                        <th>S/N</th>
                        <th>Expense Description</th>
                        <th>Expense Amount(₦)</th>
                        <th>Date Created</th>
                        <th>User Dept</th>
                        <th>Prepared by</th>
                        <th>Approved by</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
<div class="d-flex justify-content-center">
 {{--   {{ $expenses->links() }} --}}
</div>

        </div>
        
    </div>
</div>

@endsection





