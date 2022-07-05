import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ["messageField"]


  connect() {
      console.log( 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js');
  }

  displaymessage() {
    console.log('Prout');
  }
}
