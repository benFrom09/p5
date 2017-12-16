<div class="panel panel-default post-pannel" data-postid ="{{$post->id}}">
    <div class="panel-heading">
           {{$post->user->name}}
        
    </div>
    

    <div class="panel-body panel-body-post-content">

        <p id='post_body' class="post-body" >{{$post->content}}</p>
        <hr>
        @if($post->type == 1)
        
        <img src="{{asset('post_images/'. $post->image_url)}}" alt="" class="img-responsive">

        @endif

    </div>
   
    @if(Auth::user() == $post->user)
    <div class="post-edit">
    <div class="edit"><a href="#">editer</a></div>
    <div class="delete-post"><a href="{{route('post.delete',['post_id'=>$post->id])}}">effacer</a></div>
    </div>
    @endif
</div>