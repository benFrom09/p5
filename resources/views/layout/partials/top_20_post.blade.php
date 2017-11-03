<div class="panel panel-default">
    <div class="panel-heading">
           {{app\User::find($post->user_id)->name}}
        
    </div>

    <div class="panel-body">

        <p>{{$post->content}}</p>
        @if($post->type == 1)

        <img src="{{asset('post_images/'. $post->image_url)}}" alt="" class="img-responsive">

        @endif

    </div>

</div>