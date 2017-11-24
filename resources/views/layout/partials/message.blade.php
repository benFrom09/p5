@if(count($errors) > 0)
<div class="row">
    <div class="col-md-4 col-md-offset-6 alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@if(Session::has('message'))
<div class="row">
    <div class="col-md-6 col-md-offset-6 alert alert-success">
        {{Session::get('message')}}
    </div>
</div>
@endif
