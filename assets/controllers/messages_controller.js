import { Controller } from '@hotwired/stimulus';
import { format } from 'core-js/library/core/date';

export default class extends Controller {
  static targets = ["messageField", "form"]


  connect() {
      console.log( 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js');
  }

  displaymessage(e) {
    e.preventDefault();
    const form = document.querySelector('form');
    
  }
}
