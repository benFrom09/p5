@foreach($top_20_posts as $post)
<div class="panel panel-default post-pannel" data-postid ="{{$post->id}}">
    <div class="panel-heading">
           {{app\User::find($post->user_id)->name}}
        
    </div>
    

    <div class="panel-body" >

        <p id='post_body' class="post-body" >{{$post->content}}</p>
        @if($post->type == 1)

        <img src="{{asset('post_images/'. $post->image_url)}}" alt="" class="img-responsive">

        @endif

    </div>
   
    @if(Auth::user() == $post->user)
    <div class="edit"><a href="#">editer</a></div>
    <div class="delete-post"><a href="{{route('post.delete',['post_id'=>$post->id])}}">effacer</a></div>
    @endif
</div>
@endforeach
<script>
    var post_user = '{{Auth::user()->name}}';
</script>