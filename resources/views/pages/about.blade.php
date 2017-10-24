@extends('layout.default', ['title' =>'about'])

@section('content')

    <div class="container">

        <h2>WHAT is APP-Name</h2>

        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quo nulla id, ex dolore voluptatibus vero excepturi.
         Ducimus exercitationem, fuga expedita itaque illum accusantium ex ratione voluptatem amet sint soluta debitis!
        </p>

        <div class="row">
            <div class="col-md-6">
                <p class="alert alert-warning">
                    <strong><i class="fa fa-smile-o" aria-hidden="true"></i>App-Name has been built by <a href="https://github.com/benFrom09/p5">@ben09</a> for webrtc demo </strong>
                </p>
            </div><!-- /.col-md-6 -->

        </div><!-- /.row -->
        <p>contibute to help improvee <a href="#">source code</a></p>

        <hr>

        <h2>tools annd services used in App-Name</h2>
        <ul>
            <li>Laravel</li>
            <li>Bootstrap</li>
            <li>Ratchet</li>
            <li>Webrtc Api</li>
        </ul>


    </div><!-- /.container -->

@stop