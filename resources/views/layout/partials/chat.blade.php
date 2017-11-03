<div class="col-md-6">

@include('layout.partials.video')

<div class="container-fluid chat-pane">
            <!-- CHAT PANEL-->
            <div class="row chat-window col-xs-12">
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
                                 <input type="hidden" id="messageSender" value="{{Auth::user()->name}}">
                                <input id="chatInput" type="text" class="form-control input-sm chat_input" placeholder="Type message here...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm" id="chatSendBtn"  >Send</button>
                                </span>
                            </div>
                            <input class="form-control" id="files" name="file" type="file">
                        </div>
                    </div>
                </div>
            </div>
            <!-- CHAT PANEL -->
        </div>
        @include('layout.modal.videomodal')
</div>
