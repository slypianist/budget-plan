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
                        <th>User Dept</th>
                        <th>Date Created</th>
                        <th>Prepared by</th>
                        <th>Approved by</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pettys as $petty)

                    <tr>
                        <td>{{++$i}}</td>
                        <td><a href="{{route('pettyexpense.show', $petty->id)}}">{{$petty->description}}</a></td>
                        <td>{{$petty->total}}</td>
                        <td>{{$petty->user->dept}}</td>
                        <td>{{date($petty->created_at)}}</td>
                        <td>{{$petty->prep_by}}</td>
                        <td>{{$petty->apprv_by}}</td>
                        <td>{{$petty->status}}</td>
                        <td>
                            <a href="{{route('pettyexpense.edit', $petty->id)}}"><button class="btn btn-success btn-sm">Edit</button></a>
                            <form action="{{route('pettyexpense.destroy', $petty->id)}}" method="post">
                                <button class="btn btn-danger btn-sm">Delete</button>
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>

                    </tr>
                        
                    @endforeach
                    
                </tbody>
            </table>
                
<div class="d-flex justify-content-center">
 {{--   {{ $expenses->links() }} --}}
</div>

        </div>
        
    </div>
</div>

@endsection





