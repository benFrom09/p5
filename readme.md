# App-name
App-name est un espace de partage utilisant la technologie Webrtc,
qui met a votre disposition les outils pour faciliter l'echange..

#Description 
- Engeristrez-vous
- Créer votre profil
- Créer\rejoindre un groupe de travail
- Communiquer


# Requis
- laravel
- PHP >= 5.4
- require __ "cboden/ratchet": "^0.4"


# Utilisation
Pour installer en local
- Ratchet doit etre démarrré  *__App//bin/__* pour demarrer le serveur *__php chatserver.php__*
- Démarer: `http://localhost/Votreprojet/`
- Ouvrez *__Projet5/p5/public/js/webrtc.js/ et changer let socket = new WebSocket("ws:localhost:3000/group") par
new WebSocket("ws:localhost:votre serveurIp/group").
- Ouvrez *__Projet5/p5/bin/chat.php et changer $server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    3000
); par
new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    serveur_port
);
- Engeristrez-vous
- Créer votre profil
- Créer\rejoindre un groupe de travail
- Communiquer
- Pour une utilisation optimale utiliser google chrome.
- Pour eviter les feedback audio il est conseillé d'utiliser un casque
#features

- Création de profil
- Video-chat
- Live chat
- Partage d'articles

