@extends('layout.grouptemplate')

@section('content')

<div class="container">
    <div class="row">
        @include('layout.partials.chat')
        
        @include('layout.partials.posts')
        
       
    </div>

</div>

<script>
    var token = '{{Session::token()}}';
    var url = '{{ route('edit')}}';
    
</script>

@stop