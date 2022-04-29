@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ($user->fname=="Theodore" || $user->fname == "Nyaudo")

                <div class="card-header bg-success" style="color: white">Welcome <strong>{{$user->fname}} (Substantive CFO)</strong></div>

                @else
                <div class="card-header bg-success" style="color: white">Welcome <strong>{{$user->fname}}</strong></div>
                @endif


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <div class="expense">

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
