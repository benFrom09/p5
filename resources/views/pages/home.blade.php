@extends('layout.grouptemplate', ['title' =>'home']) @section('content')
<div class="container ">
    <div class="row flex">
        <div class="col col-md6"></div>
        <div class="col col-md6">
            <div class="menu-wrapper" style="padding-top:50px;">
                <div class="menu">
                    <div class="hello">
                        
                    </div>
                    <div class="hello">
                        <h2>Prennez un cours simplement, ou communiquer avec un amis...</h2>
                        <p></p>
                    </div>
                    <div class="message"><p class="description">App-name est un espace de partage utilisant la technologie Webrtc,</br>
                     qui met a votre disposition les outils pour faciliter l'echange.. </p></div>
                    <ul class="menu-icon-list">
                        <li>
                            <div class="icon-container"><i class="fa fa-registered fa-4x" aria-hidden="true"></i></div>
                            <div class="icon-title">Enregisterz-vous</div>
                        </li>

                        <li>
                            <div class="icon-container"><i class="fa fa-user fa-4x" aria-hidden="true"></i></div>
                            <div class="icon-title">creer votre profiil</div>
                        </li>
                        <li>
                            <div class="icon-container"><i class="fa fa-users fa-4x" aria-hidden="true"></i></div>
                            <div class="icon-title">Creer un groupe de travail</div>
                        </li>
                        <li>
                            <div class="icon-container"><i class="fa fa-globe fa-4x" aria-hidden="true"></i></div>
                            <div class="icon-title">communiquez</div>
                        </li>
                        
                    </ul>
                    <div class="message" style="margin-top:50px">
                        <h4 style="text-align:center;padding:20px;">features :</h4>
                        <ul class="menu-icon-list-bottom">

                            <li>
                                <div class="icon-container"><i class="fa fa-video-camera fa-3x" aria-hidden="true"></i></div>
                                <div class="icon-title">Appel video</div>
                            </li>
                            <li>
                                <div class="icon-container"><i class="fa fa-comments-o fa-3x" aria-hidden="true"></i></div>
                                <div class="icon-title">live chat</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop