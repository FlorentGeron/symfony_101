import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ["messageField"]


  connect() {
      console.log( 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js');
  }

  displaymessage(e) {
    e.preventDefault()
    const form = this.document.find('form');
    const url = '${this.form.action}';
    fetch(url, { headers: { 'Accept': 'text/plain' } })
    .then(response => response.text())
    .then((data)=> {
      this.messageField.innerHTML = data;
    })
    console.log('Prout');
  }
}
