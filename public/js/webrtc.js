/*************************************************************************
 * VIDEO CHAT JS
 *************************************************************************/

const SPINER = 'fa fa-spinner faa-spin animated';
const OUTPUT = document.querySelector("#chats");
const username = document.querySelector('#messageSender').value;
let groupId = getGroupId();

console.log(username);
let servers = {
    iceServers: [
        { urls: "stun:stun.l.google.com:19302" }
    ]
};

let socket = new WebSocket("ws:localhost:3000/group");
let pc;
let localStream;
let constraintsOne = { video: true, audio: true };
let constraintsTwo = { audio: false, video: true };
let awaitingResponse;
/*************************************************************************
 * WebSockets
 *************************************************************************/
socket.onopen = function(e) {

    socket.send(JSON.stringify({
        type: 'join',
        group: groupId
    }));
    e.message = username + ": vous etes connecté au serveur :) sur le groupe " + groupId;
    console.log(e.message);
    displayModalMessage(e.message, 6000);
}

socket.onerror = function(e) {

    e.error = 'erreur de connection au serveur websocket'
    displayMessage('<span style="color: red;">ERROR:</span> ' + e.error);
}

socket.onmessage = function(e) {

        let data = JSON.parse(e.data);

        if (data.group === groupId) {
            console.log('groupId');


            switch (data.type) {
                case 'join':
                    setOnlineStatus('online');
                    socket.send(JSON.stringify({
                        type: 'online',
                        group: groupId

                    }));
                    break;
            }
            console.log(data.type);
            switch (data.type) {
                case 'online':
                    setOnlineStatus('online');
                    displayModalMessage('veuillez patienter...', 6000);

                    break;
                case 'offline':
                    setOnlineStatus('offline');
                    displayModalMessage('veuillez patienter...', 6000);
                    break;
                case 'text':
                    openPannel();
                    displayMessage('<span style="color: #39653b;"> ' + data.username + ' : ' + data.msg + '</span>', data.date);
                    document.querySelector("#typingInfo").textContent = '';
                    break;
                case 'typingTxt':
                    if (data.status == true) {
                        document.querySelector("#typingInfo").textContent = "un utilsateur est en train d'ecrire...";
                    } else {
                        document.querySelector("#typingInfo").textContent = "";
                    }
                    break;
                case 'initCall':
                    document.querySelector('#calleeInfo').style.color = 'black';
                    document.querySelector('#calleeInfo').innerHTML = data.msg;

                    document.querySelector("#rcivModal").style.display = 'block';
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

                    document.querySelector("#callModal").style.display = 'none'; //hide call modal

                    //clearTimeout(awaitingResponse); //clear timeout

                    //stop tone
                    // document.querySelector('callerTone').pause();
                    break;
                case 'cancelCall':
                    console.log('message transmit');
                    displayModalMessage(data.msg, 10000);
                    //endCall(data.msg);
                    document.querySelector("#rcivModal").style.display = 'none';
                    stopMediaStream();
                    break;
                case 'rejectCall':
                    console.log('message transmit');
                    displayModalMessage(data.msg, 10000);
                    //endCall(data.msg);
                    document.querySelector("#callModal").style.display = 'none';
                    document.querySelector('.video-container').style.display = 'none';
                    document.querySelector('#terminateCall').setAttribute('disabled', '');
                    stopMediaStream();
                    break;
                case 'endCall':
                    stopMediaStream();
                    displayModalMessage("L'appel est terminé merci d'avoir participé a la session", 10000)
                    break;
                case 'isNewUser':

                    socket.send(JSON.stringify({
                        type: 'online',
                        group: groupId
                    }));
                    displayModalMessage("Un utilisteur se connecte veuillez patienter", 6000);
                    break;

            }
        }


    }
    /*************************************************************************
     * Video
     *************************************************************************/
let callIcon = document.getElementsByClassName('initCall');
console.log(callIcon.length);
for (let i = 0; i < callIcon.length; i++) {
    callIcon[i].addEventListener('click', initCall);
}

let answerCallElems = document.getElementsByClassName('answerCall');

for (let i = 0; i < answerCallElems.length; i++) {
    answerCallElems[i].addEventListener('click', answerCall);
}


function initCall() {

    //choose type of the call
    document.querySelector('.video-container').style.display = 'block';
    let call = this.id === 'initVideo' ? 'Video' : 'Audio';
    callerInfo = document.querySelector('#callerInfo');
    console.log(callerInfo);
    //infos d el'appelant

    //check support
    if (supportWebsockets) {

        //define options
        constraintsOne = call === 'Video' ? { video: true, audio: true } : { audio: true };
        constraintsTwo = call === 'Video' ? { video: true, audio: true } : { audio: true };
        //display message to dialog
        callerInfo.style.color = 'black';
        callerInfo.innerHTML = call === 'Video' ? 'Appel en cours...' : 'Appel audio';
        //start calling tone

        //notify calee
        socket.send(JSON.stringify({
            type: 'initCall',
            msg: call === 'Video' ? "Appel entrant" : "Appel audio entrant",
            group: groupId

        }));
        //Btn btn
        document.querySelector('#terminateCall').removeAttribute('disabled');
    }

    document.querySelector("#callModal").style.display = 'block';

}

function answerCall() {
    document.querySelector('.video-container').style.display = 'block'
    if (supportWebsockets) {
        constraints = this.id === 'startVideo' ? { video: true, audio: true } : { audio: true };
        constraintsTwo = this.id === 'Video' ? { video: true, audio: true } : { audio: true };
        alert('ok');
        document.querySelector("#calleeInfo").innerHTML = "<i class= " + SPINER + "></i> Setting up call...";
        console.log(constraintsOne, constraintsTwo)
        isCalling(true);
        document.querySelector("#rcivModal").style.display = 'none';
        document.querySelector('#terminateCall').removeAttribute('disabled');
    }

}

function isCalling(caller) {
    if (supportWebsockets) {
        pc = new RTCPeerConnection(servers);

        pc.onicecandidate = function(e) {
            if (e.candidate) {
                //send to peer
                socket.send(JSON.stringify({
                    type: 'candidate',
                    candidate: e.candidate,
                    group: groupId
                }))
            }
        };
        //avaible remote stream

        pc.ontrack = function(e) {
            document.querySelector("#remoteVideo").src = window.URL.createObjectURL(e.streams[0]);
        };
        getUserMedia(constraintsOne, caller);
    }

}




function getUserMedia(constraintsOne, caller) {

    navigator.mediaDevices.getUserMedia(constraintsOne).then(function(stream) {



        document.querySelector("#localVideo").src = window.URL.createObjectURL(stream);

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
                type: 'isCalling',
                group: groupId
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
        sdp: desc,
        group: groupId
    }))
}

document.querySelector("#terminateCall").addEventListener('click', function(e) {
    e.preventDefault();

    endCall("L'appel a été annulé :(");
    document.querySelector('.video-container').style.display = 'none'
        //enable call buttons
    enableCallBtns();
});

document.querySelector("#endCall").addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.video-container').style.display = 'none'
    cancelCall("Call cancelled by remote");

    document.querySelector("#callModal").style.display = 'none';



    //enable call buttons
    enableCallBtns();
});

document.querySelector("#rejectCall").addEventListener('click', function(e) {
    e.preventDefault();
    let r = confirm('voulez vous vraiment refuser l\'appel ?');
    if (r == true) {
        rejectCall("l'appel n'a pas été accepté");
        document.querySelector("#rcivModal").style.display = 'none';
        enableCallBtns();
    } else {
        return false;
    }


});



function endCall(msg) {
    socket.send(JSON.stringify({
        type: 'endCall',
        msg: msg,
        group: groupId

    }));



}

function cancelCall(msg) {
    socket.send(JSON.stringify({
        type: 'cancelCall',
        msg: msg,
        group: groupId

    }));
}

function rejectCall(msg) {
    socket.send(JSON.stringify({
        type: 'rejectCall',
        msg: msg,
        group: groupId
    }));
}


function stopMediaStream() {
    console.log();
    //pc.removeTrack(localStream);
    //pc.close();


    let allStream = localStream.getVideoTracks();
    allStream[0].stop();
    let elmt = document.getElementsByTagName('video');
    for (let i = 0; i < elmt.length; i++) {
        elmt[i].src = '';


        //elmt[i].src = '';
    }

    for (let j = 0; j < elmt.length; j++) {
        elmt[j].removeAttribute('src');
    }


}

function enableCallBtns() {

}

/*************************************************************************
 *video options
 *************************************************************************/




/*************************************************************************
 * Chat
 *************************************************************************/
document.querySelector("#chatSendBtn").addEventListener('click', function(e) {
    let validateMsg = userInputSupplied();
    if (validateMsg !== '') {
        alert(validateMsg);
        return;
    }
    let msg = document.querySelector("#chatInput").value;

    if (msg) {
        // insere la date
        let date = new Date().toLocaleTimeString();
        // insere un id au mssage


        //vide l'input
        document.querySelector("#chatInput").value = '';
        document.querySelector("#chatInput").focus();
        //envoie le message 
        sendChat(msg, date, username);
        displayMessage('vous: ' + msg + '' + '', date);


    }
});

function sendChat(msg, date, username) {
    socket.send(JSON.stringify({
        type: 'text',
        msg: msg,
        date: date,
        group: groupId,
        username: username
    }));
}

function maximizePannel() {
    let collapse = document.querySelector("#minim_chat_window");
    if (collapse.classList.contains('panel-collapsed')) {
        document.querySelector("#chats").style.display = 'block';
        collapse.classList.remove('panel-collapsed');
        collapse.classList.remove('fa-plus');
        collapse.classList.add('fa-minus');

    } else {
        document.querySelector("#chats").style.display = 'none';
        collapse.classList.add('panel-collapsed');
        collapse.classList.remove('fa-minus');
        collapse.classList.add('fa-plus');
    }

}

function openPannel() {
    let collapse = document.querySelector("#minim_chat_window");
    document.querySelector("#chats").style.display = 'block';
    collapse.classList.remove('panel-collapsed');
    collapse.classList.remove('fa-plus');
    collapse.classList.add('fa-minus');

}

// notify user is typing text

document.querySelector("#chatInput").addEventListener('keyup', function(e) {

    let msg = this.value;
    if (msg) {
        socket.send(JSON.stringify({
            type: 'typingTxt',
            msg: msg,
            status: true,
            group: groupId
        }));
    } else {
        socket.send(JSON.stringify({
            type: 'typingTxt',
            status: false,
            group: groupId
        }));
    }
});

// maximize panel

document.querySelector(".closeChat").addEventListener('click', maximizePannel);
document.querySelector("#chatInput").addEventListener('focusin', openPannel);


function userInputSupplied() {
    let msg = document.querySelector("#chatInput").value;
    if (msg = '') {
        return 'veuillez saisir du texte svp'
    } else {
        return '';
    }
}

/*************************************************************************
 * check function
 *************************************************************************/

function supportWebsockets() {
    return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia || navigator.msGetUserMedia);
}

/*************************************************************************
 * display function
 *************************************************************************/
function displayMessage(msg, date) {
    let p = document.createElement('div');
    //let time = document.createElement('p');
    p.classList.add('messages');

    if (msg.match(/http/)) {
        let link = document.createElement('a');
        link.href = msg;
        link.textContent = msg;
        p.appendChild(link);
    } else {
        // time.textContent = date;
        //p.appendChild(time);
        // p.innerHTML = msg;
        var newNode = `<div class="messageText">${msg}<p class="right">${date}</div>`;
        p.innerHTML = newNode;
    }
    OUTPUT.appendChild(p);

}

function setOnlineStatus(status) {
    if (status === 'online') {
        document.querySelector("#remoteStatus").style.color = 'green';
        document.querySelector("#remoteStatusTxt").innerHTML = 'online';
    } else {
        document.querySelector("#remoteStatus").style.color = 'green';
        document.querySelector("#remoteStatusTxt").innerHTML = 'offline';
    }
}

function displayModalMessage(msg, time) {
    let modal = document.querySelector("#display-modal-message");
    modal.classList.add('show');
    modal.innerHTML = msg;

    setTimeout(function() {
        modal.innerHTML = '';
        modal.classList.remove('show');
    }, time);

}


function getGroupId() {
    let url = window.location.pathname.split('/');
    let id = url[2].trim();
    console.log('ROOM ID = ' + id);
    return id;
}

function refreshPost() {
    let postId = $('.post-dashboard')[0].firstElementChild.dataset.postid;
    parseInt(postId);

    $.ajax('http://localhost:8000/get-last-post', {



    }).done(function(response) {
        newpostId = $(response)[0].dataset.postid;
        parseInt(newpostId);
        if (postId < newpostId) {
            $(response).prependTo($('.post-dashboard'));
        } else {
            return false;
        }

        console.log($(response)[0].dataset.postid);
        //$(response).prependTo('.post-dashboard');
    })
}

window.setInterval(refreshPost, 5000);