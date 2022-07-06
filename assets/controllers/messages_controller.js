import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
  static targets = ["messageField", "form"]


  connect() {
      console.log( 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js');
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
