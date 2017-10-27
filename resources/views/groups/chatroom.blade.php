<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/video.css')}}">
    <!--- LOAD FILES -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.8/font-awesome-animation.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
    <title>Document</title>

</head>
<body>
<div class="container-fluid">
            <div class="row">
                <!-- Remote Video -->
                <video id="remoteVideo"  autoplay></video>
                <!-- Remote Video -->
            </div>
            
            <div class="row margin-top-20">                
                <!-- Call Buttons -->
                <div class="col-sm-12 text-center" id="callBtns">
                   
                    <button class="btn btn-info btn-sm initCall" id="initVideo"><i class="fa fa-video-camera"></i></button>
                    <button class="btn btn-danger btn-sm" id="terminateCall" disabled><i class="fa fa-phone-square"></i></button>
                </div>
                <!-- Call Buttons -->
                
                <!-- Timer -->
                <div class="col-sm-12 text-center margin-top-5" style="color:#fff">
                    <span id="countHr"></span>h:
                    <span id="countMin"></span>m:
                    <span id="countSec"></span>s
                </div>
                <!-- Timer -->
            </div>
            
            
            <!-- Local Video -->
            <div class="row">
                <div class="col-sm-12">
                    <video id="localVideo" muted autoplay></video>
                </div>
            </div>
            <!-- Local Video -->
        </div>

        <div class="container-fluid chat-pane">
            <!-- CHAT PANEL-->
            <div class="row chat-window col-xs-12 col-md-4">
                <div class="">
                    <div class="panel panel-default chat-pane-panel">
                        <div class="panel-heading chat-pane-top-bar">
                            <div class="col-xs-10" style="margin-left:-20px">
                                <i class="fa fa-comment" id="remoteStatus"></i> chat
                                <b id="remoteStatusTxt"></b>
                            </div>
                            <div class="col-xs-2 pull-right">
                                <span id="minim_chat_window" class="panel-collapsed fa fa-plus icon_minim pointer"></span>
                            </div>
                        </div>
                        
                        <div class="panel-body msg_container_base" id="chats"></div>
                        
                        <div class="panel-footer">
                            <span id="typingInfo"></span>
                            <div class="input-group">
                                 
                                <input id="chatInput" type="text" class="form-control input-sm chat_input" placeholder="Type message here...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm" id="chatSendBtn"  >Send</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CHAT PANEL -->
        </div>

        <!--Modal to show that we are calling-->
        <div id="callModal" class="modal">
            <div class="modal-content text-center">
                <div class="modal-header" id="callerInfo"></div>
                    
                <div class="modal-body">
                    <button type="button" class="btn btn-danger btn-sm" id='endCall'>
                        <i class="fa fa-times-circle"></i> Terminer l'appel
                    </button>
                </div>
            </div>
        </div>
        <!--Modal end-->


        <!--Modal to give options to receive call-->
        <div id="rcivModal" class="modal">
            <div class="modal-content">
                <div class="modal-header" id="calleeInfo"></div>

                <div class="modal-body text-center">
                    
                    <button type="button" class="btn btn-success btn-sm answerCall" id='startVideo'>
                        <i class="fa fa-video-camera"></i> accepter
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id='rejectCall'>
                        <i class="fa fa-times-circle"></i> refuser
                    </button>
                </div>
            </div>
        </div>
        <!--Modal end-->
        
        <!--Snackbar -->
        <div id="pannelInfo"></div>
        <!-- Snackbar -->
            
        <!-- custom js -->
        
        <script src="{{asset('js/checkmozaddon.js')}}"></script>
        <script src="{{asset('js/adapter.js')}}"></script>
        <script src="{{asset('js/function.js')}}"></script>
        <script src="{{asset('js/videochat.js')}}"></script>

        <!--<script src="js/websocket_client.js"></script>-->
    
</body>
</html>