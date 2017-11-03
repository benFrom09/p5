const SPINER = 'fa fa-spinner faa-spin animated';
const OUTPUT = document.getElementById("chats");
const username = $('#messageSender').value;
console.log(OUTPUT);
// server stun

var servers = {
    iceServers: [
        { urls: "stun:stun.l.google.com:19302" }
    ]
};

var socket = new WebSocket("ws:localhost:3000");
var pc;
var localStream;
var constraintsOne = { video: true, audio: false };
var constraintsTwo = { audio: false, video: true };
var awaitingResponse;

/*---------------------------------------------------------------------------------/
 *
 *              websocket evt
 *
 *-----------------------------------------------------------------------------------*/

socket.onopen = function(e) {

    socket.send(JSON.stringify({
        action: 'status'
    }));
    e.message = username + ": vous etes connecté au serveur :) "
    displayMessage(e.message);
}

socket.onerror = function(e) {

    e.error = 'erreur de connection au serveur websocket'
    displayMessage('<span style="color: red;">ERROR:</span> ' + e.error);
}

socket.onmessage = function(e) {

    var data = JSON.parse(e.data);
    switch (data.action) {
        case 'status':
            setOnlineStatus('online');
            socket.send(JSON.stringify({
                type: 'online'

            }));
            break;
    }
    console.trace(data.type);
    switch (data.type) {
        case 'online':
            setOnlineStatus('online');
            break;
        case 'offline':
            setOnlineStatus('offline');
            break;
        case 'text':
            displayMessage('<span style="color: blue;"> ' + data.username + ' : ' + data.msg + ' ' + data.date + '</span>');
            break;
        case 'typingTxt':
            if (data.status) {

                $("#typingInfo").textContent = "un utilsateur est en train d'ecrire...";
            } else {
                $("#typingInfo").textContent = "";
            }
            break;
        case 'initCall':
            document.getElementById('calleeInfo').style.color = 'black';
            document.getElementById('calleeInfo').innerHTML = data.msg;

            document.getElementById("rcivModal").style.display = 'block';
            break;
        case 'candidate':
            //message is iceCandidate
            console.log(data.candidate);
            pc ? pc.addIceCandidate(new RTCIceCandidate(data.candidate)) : "";

            break;

        case 'sdp':
            //message is signal description
            pc ? pc.setRemoteDescription(new RTCSessionDescription(data.sdp)) : "";

            break;

        case 'isCalling':
            isCalling(false); //to start call when callee gives the go ahead (i.e. answers call)

            document.getElementById("callModal").style.display = 'none'; //hide call modal

            //clearTimeout(awaitingResponse); //clear timeout

            //stop tone
            // document.getElementById('callerTone').pause();
            break;
        case 'cancelCall':
            console.log('message transmit');
            //endCall(data.msg);
            document.getElementById("rcivModal").style.display = 'none';
            // stopMediaStream();
            break;

    }





}

/*--------------------------------------------------------------------------------*
 *
 *           chat text 
 *---------------------------------------------------------------------------------*/
$("#chatSendBtn").addEventListener('click', function(e) {
    var validateMsg = userInputSupplied();
    if (validateMsg !== '') {
        alert(validateMsg);
        return;
    }
    var msg = $("#chatInput").value;

    if (msg) {
        // insere la date
        var date = new Date().toLocaleTimeString();
        // insere un id au mssage


        //vide l'input
        $("#chatInput").value = '';
        $("#chatInput").focus();
        //envoie le message 
        sendChat(msg, date, username);
        displayMessage(msg);


    }
});

function sendChat(msg, date, username) {
    socket.send(JSON.stringify({
        type: 'text',
        msg: msg,
        date: date,
        username: username
    }));
}

// notify user is typing text

$("#chatInput").addEventListener('keyup', function(e) {

    var msg = this.value;
    if (msg) {
        socket.send(JSON.stringify({
            type: 'typingTxt',
            msg: msg,
            status: true
        }));
    } else {
        socket.send(JSON.stringify({
            type: 'typingTxt',
            status: false
        }));
    }
});








function userInputSupplied() {
    var msg = $("#chatInput").value;
    if (msg = '') {
        return 'veuillez saisir du texte svp'
    } else {
        return '';
    }
}


/*--------------------------------------------------------------------------------*
 *
 *           usal function
 *---------------------------------------------------------------------------------*/


function displayMessage(msg) {
    var p = document.createElement('p');
    if (msg.match(/http/)) {
        var link = document.createElement('a');
        link.href = msg;
        link.textContent = msg;
        p.appendChild(link);
    } else {
        p.innerHTML = msg;

    }
    OUTPUT.appendChild(p);
}






function setOnlineStatus(status) {
    if (status === 'online') {
        $("#remoteStatus").style.color = 'green';
        $("#remoteStatusTxt").innerHTML = 'online';
    } else {
        $("#remoteStatus").style.color = 'green';
        $("#remoteStatusTxt").innerHTML = 'offline';
    }
}


function browserSupportsWebSockets() {

    /*
    if ("WebSocket" in window) {
        return true;
    } else {
        //console.log('votre navigateur ne supporte pas websocket');
        return false;
    }
    */
    return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia || navigator.msGetUserMedia);
}

/*----------------------------------------------------------------------------
 *
 *   video chat
 *
 *------------------------------------------------------------------------------*/

var callIcon = $class('initCall');
console.log(callIcon.length);
for (var i = 0; i < callIcon.length; i++) {
    callIcon[i].addEventListener('click', initCall);
}

var answerCallElems = document.getElementsByClassName('answerCall');

for (var i = 0; i < answerCallElems.length; i++) {
    answerCallElems[i].addEventListener('click', answerCall);
}


function initCall() {

    //choose type of the call
    var call = this.id === 'initVideo' ? 'Video' : 'Audio';
    callerInfo = document.getElementById('callerInfo');
    console.log(callerInfo);
    //infos d el'appelant

    //check support
    if (browserSupportsWebSockets) {

        //define options
        constraintsOne = call === 'Video' ? { video: true, audio: false } : { audio: true };
        constraintsTwo = call === 'Video' ? { video: true, audio: false } : { audio: true };
        //display message to dialog
        callerInfo.style.color = 'black';
        callerInfo.innerHTML = call === 'Video' ? 'Video call to Remote' : 'Audio call to Remote';
        //start calling tone

        //notify calee
        socket.send(JSON.stringify({
            type: 'initCall',
            msg: call === 'Video' ? "Video call from remote" : "Audio call from remote",

        }));
        //Btn btn
        document.getElementById('terminateCall').removeAttribute('disabled');
    }

    document.getElementById("callModal").style.display = 'block';

}

function answerCall() {

    if (browserSupportsWebSockets) {
        constraints = this.id === 'startVideo' ? { video: true, audio: false } : { audio: true };
        constraintsTwo = this.id === 'Video' ? { video: true, audio: false } : { audio: true };
        alert('ok');
        $("#calleeInfo").innerHTML = "<i class= " + SPINER + "></i> Setting up call...";
        console.log(constraintsOne, constraintsTwo)
        isCalling(true);
        document.getElementById("rcivModal").style.display = 'none';
        document.getElementById('terminateCall').removeAttribute('disabled');
    }

}

function isCalling(caller) {
    if (browserSupportsWebSockets) {
        pc = new RTCPeerConnection(servers);

        pc.onicecandidate = function(e) {
            if (e.candidate) {
                //send to peer
                socket.send(JSON.stringify({
                    type: 'candidate',
                    candidate: e.candidate
                }))
            }
        };
        //avaible remote stream

        pc.ontrack = function(e) {
            $("#remoteVideo").src = window.URL.createObjectURL(e.streams[0]);
        };
        getUserMedia(constraintsOne, caller);
    }

}


function getUserMedia(constraintsOne, caller) {

    navigator.mediaDevices.getUserMedia(constraintsOne).then(function(stream) {



        $("#localVideo").src = window.URL.createObjectURL(stream);

        //add localstream to rtcpeer
        //stream.addTrack(screenStream.getVideoTracks()[0]);

        pc.addStream(stream);


        localStream = stream;
        console.log(localStream);

        if (caller) {
            pc.createOffer().then(gotDescription, function(e) {
                console.error('creating offer ERROR', e.message);
            });

            //notify callee star call

            socket.send(JSON.stringify({
                type: 'isCalling'
            }))

        } else {
            pc.createAnswer().then(gotDescription, function(e) {
                console.error('failed creaye answer', e);
            })
        }

    }).catch(function(error) {

    });

}

function gotDescription(desc) {
    pc.setLocalDescription(desc);
    console.trace('offer from pc \n' + desc);

    // send sdp

    socket.send(JSON.stringify({
        type: 'sdp',
        sdp: desc
    }))
}

document.getElementById("terminateCall").addEventListener('click', function(e) {
    e.preventDefault();

    endCall("Call ended by remote");

    //enable call buttons
    enableCallBtns();
});

document.getElementById("endCall").addEventListener('click', function(e) {
    e.preventDefault();

    cancelCall("Call cancelled by remote");

    document.getElementById("callModal").style.display = 'none';



    //enable call buttons
    enableCallBtns();
});

function endCall(msg) {
    socket.send(JSON.stringify({
        type: 'endCall',
        msg: msg,

    }));

    stopMediaStream()
}

function cancelCall(msg) {
    socket.send(JSON.stringify({
        type: 'cancelCall',
        msg: msg,

    }));


}


function stopMediaStream() {
    console.log();
    //pc.removeTrack(localStream);
    //pc.close();


    var allStream = localStream.getVideoTracks();
    allStream[0].stop();
    var elmt = document.getElementsByTagName('video');
    for (var i = 0; i < elmt.length; i++) {
        elmt[i].src = '';


        //elmt[i].src = '';
    }

    for (var j = 0; j < elmt.length; j++) {
        elmt[j].removeAttribute('src');
    }


}

function enableCallBtns() {

}