import {GosSocket, WS} from '../../vendor/gos/web-socket-bundle/public/js/websocket.min.js';

var webSocket = GosSocket.connect('ws://127.0.0.1:8080');
      webSocket.on('socket/connect', function (session) {
    //session is an AutobahnJS WAMP session.
      console.log('Successfully connected to websocket!');
});
