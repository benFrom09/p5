@extends('layout.default')

@section('content')

<div class="container">

<form action="" method="post">
{{csrf_field()}}

    <div class="form-group">
        <label for="name">Nom du groupe</label>
        <input class="form-control" type="text" name="name" id="name" placeholder ="entrez le nom du groupe ici">
    </div>
    <div class="form-group">
        <label for="user_name">username</label>
        <input class="form-control" type="text" name="user_name" id="name" placeholder ="entrez le nom du groupe ici">
    </div>
    <div class="form-group">
        <label for="description">description du groupe</label>
       <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
    </div>
    
    <select class="form-control" name="category_id" id="">
        <option value="1">Musique</option>
        <option value="2">Math</option>
        <option value="3">Francais</option>
        <option value="4">Sciences</option>
        <option value="5">Langues</option>
        <option value="6">Divers</option>
    </select>

    <button class="btn btn-info" type="submit">creer</button>




</form>

</div>

@stop


