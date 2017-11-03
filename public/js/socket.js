var SocketInterface = {

    url: "ws:localhost:3000",
    ws: new WebSocket("ws:localhost:3000"),
    data: null,
    auth: 'ben',
    OUTPUT: document.getElementById("chats"),

    init: function() {


        this.ws.onopen = this.onOpen;
        this.ws.onerror = this.onErrors;
        this.ws.onmessage = this.onMessages;
        console.log(this.url);
    },

    onOpen: function(event) {
        this.send(JSON.stringify({
            action: 'status',
            auth: this.auth

        }));
        event.message = "la connection au serveur a bien été établie";
        Socket.displayMessages(event.message);

    },

    onErrors: function(event) {

    },

    onMessages: function(event) {
        this.data = JSON.parse(e.data);
        switch (data.action) {
            case 'status':
                this.setOnlineStatus('online');
                this.send(JSON.stringify({
                    action: 'online'

                }));
                break;
        }
    },

    setOnlineStatus: function(status) {

        if (status === 'online') {
            document.querySelector("#remoteStatus").style.color = 'green';
            document.querySelector("#remoteStatusTxt").innerHTML = 'online';
        } else {
            document.querySelector("#remoteStatus").style.color = 'black';
            document.querySelector("#remoteStatusTxt").innerHTML = 'offline';
        }

    },

    displayMessages: function(msg) {
        var p = document.createElement('p');
        p.innerHTML = msg;
        //this.OUTPUT.appendChild(p);
        console.log(this.OUTPUT);

    }

}

var socket = Object.create(SocketInterface);
socket.init();