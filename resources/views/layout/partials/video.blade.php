<div class="video-container">

    <!-- Remote Video -->
    <video id="remoteVideo" controls autoplay></video>
    <!-- Remote Video -->
    <!-- Local Video -->
    <video id="localVideo" class="local-outCall" muted autoplay></video>
    <!-- Local Video -->
    <div id ='icons'>
        <div id="unmuted-mic" class="i-margin-right">
            <i class="fa fa-microphone"></i>
        </div>
        <div id="muted-mic" class="i-margin-right">
            <i class="fa fa-microphone-slash"></i>
        </div>
        <div id="play-icon" class="i-margin-right">
            <i class="fa fa-play-circle"></i>
        </div>
        <div id="pause-icon" class="i-margin-right">
            <i class="fa fa-pause-circle"></i>
        </div>
    </div>
</div>

<div class="video-init">
    <!-- Call Buttons -->
    <div class="video-int-btn" id="callBtns">
        
        <button class="btn btn-info btn-sm initCall" id="initVideo"><i class="fa fa-video-camera"></i></button>
        <button class="btn btn-danger btn-sm" id="terminateCall" disabled><i class="fa fa-stop"></i></button>
    </div>
    <!-- Call Buttons -->

    <!-- Timer -->
    <!--<div class="video-couter" style="color:#fff">
        <span id="countHr"></span>h:
        <span id="countMin"></span>m:
        <span id="countSec"></span>s
    </div>-->
    <!-- Timer -->
</div>
<div id="display-modal-message"></div>