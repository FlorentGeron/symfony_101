import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
  static targets = ["messageField", "form"]


  connect() {
      console.log( 'Hello Stimulus! Now trying to initialize connection with websocket');
      var webSocket = GosSocket.connect('ws://127.0.0.1:8080');
      webSocket.on('socket/connect', function (session) {
    //session is an AutobahnJS WAMP session.
      console.log('Successfully connected to websocket!');
});
  }

  displaymessage(e) {
    e.preventDefault();
    const form = document.querySelector('form');
    const url = `${form.action}`;
    const options = {
      method: 'POST',
      headers: { accept: 'text/plain'},
      body: new FormData(form)
    }

    fetch(form.action, options)
    .then(response => response.text())
    .then((data)=> {
      this.messageFieldTarget.insertAdjacentHTML('beforeend',data)
    })
    form.reset();
    console.log('Prout');

  }
}
