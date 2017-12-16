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
    <div class="modal-content text-center">
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