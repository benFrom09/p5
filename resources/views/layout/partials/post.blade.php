<div class="panel panel-default post-pannel">
    <div class="panel-heading">
           {{app\User::find($post->user_id)->name}}
        
    </div>
    

    <div class="panel-body" data-postid ="{{$post->id}}">

        <p id='post_body' class="post-body" >{{$post->content}}</p>
        @if($post->type == 1)
        
        <img src="{{asset('post_images/'. $post->image_url)}}" alt="" class="img-responsive">

        @endif

    </div>
   
    @if(Auth::user() == $post->user)
    <div class="edit"><a href="#">editer</a></div>
    <div><a href="{{route('post.delete',['post_id'=>$post->id])}}">effacer</a></div>
    @endif
</div>
<script>
    var post_user = '{{Auth::user()->name}}';
    var post_id = '{{$post->id}}';
    var deleteUrl = "{{route('post.delete',['post_id'=>$post->id])}}"
</script>