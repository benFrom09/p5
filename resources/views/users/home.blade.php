@extends('layout.grouptemplate') @section('content')
<div class="container">
    <div class="row">
        <div class="col col-md6"></div>
        <div class="col col-md6">
            <div class="menu-wrapper">
                <div class="menu">
                    <div class="hello"><h2>Bonjour {{Auth::user()->name}}!</h2></div>
                    <div class="message"><p>Appeler un amis, envoyer lui un message, exprimez vous...</p></div>
                    <ul class="menu-icon-list">
                        <li>
                            <div class="icon-container"><a href=""><i class="fa fa-video-camera fa-4x" aria-hidden="true"></i></a></div>
                            <div class="icon-title">Lancer un appel video</div>
                        </li>
                        <li>
                            <div class="icon-container"><a href=""><i class="fa fa-commenting-o fa-4x" aria-hidden="true"></i></a></div>
                            <div class="icon-title">Live chat</div>
                        </li>
                        <li>
                            <div class="icon-container"><a href="{{url('/profile')}}/{{ Auth::user()->id}}"><i class="fa fa-user fa-4x" aria-hidden="true"></i></a></div>
                            <div class="icon-title">Modifiez votre profiil</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection