@extends('layout.default', ['title' =>'about'])

@section('content')

    <div class="container contact">

        <h2>WHAT is {{config('app.name')}}</h2>
        <hr>

        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quo nulla id, ex dolore voluptatibus vero excepturi.
         Ducimus exercitationem, fuga expedita itaque illum accusantium ex ratione voluptatem amet sint soluta debitis!
        </p>

        <div class="row">
            <div class="col-md-6">
                <p class="about-alert">
                    <strong><i class="fa fa-smile-o" aria-hidden="true"></i> {{config('app.name')}} has been built by <a href="https://github.com/benFrom09/p5">@ben09</a> for webrtc demo </strong>
                </p>
            </div><!-- /.col-md-6 -->

        </div><!-- /.row -->
       

        <hr>

        <h2>tools and services used in {{config('app.name')}}</h2>
        <hr>
        <ul>
            <li>Laravel</li>
            <li>Bootstrap</li>
            <li>Ratchet</li>
            <li>Webrtc Api</li>
        </ul>


    </div><!-- /.container -->

@stop