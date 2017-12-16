let mic = document.querySelector('#unmuted-mic');
let mutedMic = document.querySelector('#muted-mic');
let pauseIcon = document.querySelector('#pause-icon');
let playIcon = document.querySelector('#play-icon');

let vgaButton = document.querySelector('#vga');
let qvgaButton = document.querySelector('#qvga');
let hdButton = document.querySelector('#hd');
let fullHdButton = document.querySelector('#full-hd');

let video = document.querySelector('video');
let messagebox = document.querySelector('#errormessage');
let stream;


let constraints = {
    audio: true,
    video: true
}
let qvgaConstraints = {
    video: { width: { exact: 320 }, height: { exact: 240 } }
};

let vgaConstraints = {
    video: { width: { exact: 640 }, height: { exact: 480 } }
};

let hdConstraints = {
    video: { width: { exact: 1280 }, height: { exact: 720 } }
};

let fullHdConstraints = {
    video: { width: { exact: 1920 }, height: { exact: 1080 } }
};






function muteMic(event) {
    mic.style.display = 'none';
    mutedMic.style.display = 'inline-block';
}

function unmuteMic(event) {
    mutedMic.style.display = 'none';
    mic.style.display = 'inline-block';
}

function videoPause(event) {
    pauseIcon.style.display = 'none';
    playIcon.style.display = 'inline-block';
    video.pause();
}

function videoPlay(event) {
    playIcon.style.display = 'none';
    pauseIcon.style.display = 'inline-block';
    video.play();
}

function vga(event) {
    getMedia(vgaConstraints);
}

function qvga(event) {
    getMedia(qvgaConstraints);
}

function hd(event) {
    getMedia(hdConstraints);
}

function fullHd() {
    getMedia(fullHdConstraints);
}


function getMedia(constraints) {
    navigator.mediaDevices.getUserMedia(constraints)
        .then(gotStream)
        .catch(function(e) {
            errorMessage('getUserMedia', e.name);
        });
}


mic.addEventListener('click', muteMic);
mutedMic.addEventListener('click', unmuteMic);
pauseIcon.addEventListener('click', videoPause);
playIcon.addEventListener('click', videoPlay);