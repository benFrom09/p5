@extends('layout.grouptemplate')

@section('content')

<div class="container">
    <div class="row">
    @if($groups)
    @foreach($groups as $group)
       
        <div class="panel panel-default group-list-container">
            <div class="panel panel-heading group-name">
                {{$group->name}}
            </div>
            <div class="panel panel-body panel-group">
                <p class="group-skill">
                   cliquez sur rejoindre le groupe pour acceder a l'espace de travail
                </p>
                <hr>
                <div class="link-chat">
                    <form action="{{route('add.user.group')}}" method="post">
                    {{ csrf_field() }}
                        <input type="hidden" name="group_id" id="group_id" value ="{{$group->id}}">
                        <input type="hidden" name="user_id" id="user_id" value ="{{Auth::user()->id}}">
                        @if($group->id != Auth::user()->id)
                        <input class="btn btn-primary"  value="Déjà membre" disabled> 
                        <a href="group/{{$group->id}}" class="btn btn-primary">Rejoindre</a>
                        @else
                        <input class="btn btn-primary" type="submit" value="Adherer">
                        @endif
                    
                    </form>
                
                </div>


            </div>

            

        
         </div>
        
     @endforeach  
     @endif 
    </div>

</div>


@stop