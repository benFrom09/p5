<div class="col-md-6 ">
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
                    <label for="content">exprimez-vous</label>
                    <textarea class="form-control" name="content" id="content"></textarea>
                </div>

                You are logged in!
            </div>
            <div class="panel-footer clearfix">
                <button class="btn btn-info pull-right btn-sm"><i class="fa fa-plus"></i> Ajouter un statut</button>
            </div>
        </div>
    </form>
    @foreach($top_20_posts as $post)

               @include('layout.partials.top_20_post') 

     @endforeach
</div>