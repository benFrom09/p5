@extends('layout.default', ['title' =>'home']) @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{asset('img/network1.jpg')}}" alt="" class="img-responsive">
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Workgroup</div>
                <div class="panel-body">
                    <h3 class="text-center">Groupes de travail</h3>
                    <hr>
                    <!-- -->

                    <ul>
                        @if($user)
                        @if($user->groups->count() === 0)

                        <div class="alert alert-info"> vous n'etes affilié(e) à aucun groupe</div>
                        @else @foreach($user->groups as $group)

                        <li><a href="{{route('group',$group->id)}}">{{$group->name}}</a></li>

                        @endforeach @endif
                        @endif
                        <li><a href="creategroup">creer un groupe</a></li>
                    </ul>
                    <!-- -->
                </div>
            </div>
        </div>

    </div>

</div>

@stop