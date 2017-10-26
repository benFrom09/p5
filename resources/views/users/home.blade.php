@extends('layout.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Workgroup</div>
                <div class="panel-body">
                    <h3 class="text-center">Groupes de travail</h3>
                    <hr>
                    <!-- --> 
                                     
                    <ul>
                    @if($user->groups->count() === 0)

                        <div class="alert alert-info"> vous n'etes affilié(e) à aucun groupe</div>
                    @else
                        @foreach($user->groups as $group)
                     
                         <li><a href=""></a>{{$group->name}} </li>  
                       
                         @endforeach
                    @endif
                    </ul>
                    <!-- --> 
                </div>
            </div>
        </div>
        <div class="col-md-8 ">
            <form action="" method="post">
                {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">Ajouter un statut</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="status-text">exprimez-vous</label>
                            <textarea class="form-control" name="status-text" id="status-text" ></textarea>
                        </div>
                    
                        You are logged in!
                    </div>
                    <div class="panel-footer clearfix">
                        <button class="btn btn-info pull-right btn-sm"><i class="fa fa-plus"></i> Ajouter un statut</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
