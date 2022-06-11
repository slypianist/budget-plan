@if (Session::has('message'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
               <p>{{Session::get('message')}}</p>
            </div>
            @endif

@if (Session::has('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                <p>{{Session::get('error')}}</p>

            </div>
    
@endif
