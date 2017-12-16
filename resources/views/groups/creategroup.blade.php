@extends('layout.default')

@section('content')

<div class="container">

<form action="" method="post" class="create-group-form">
{{csrf_field()}}

    <div class="form-group">
        <label for="name">Nom du groupe</label>
        <input class="form-control" type="text" name="name" id="name" placeholder ="Entrez le nom du groupe ici">
    </div>
    <div class="form-group">
        <label for="user_name">username</label>
        <input class="form-control" type="text" name="user_name" id="name" placeholder ="Entrez votre pseudo">
    </div>
    
    <button class="btn btn-info" type="submit">creer</button>




</form>

</div>

@stop


