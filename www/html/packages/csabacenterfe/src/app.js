import './scss/app.scss';
import "bootstrap";
import "@fortawesome/fontawesome-free";
import main from './js/main';
import 'slick-slider';
import 'ekko-lightbox';
import 'Lazysizes';
import Scrollbar from 'smooth-scrollbar';

window.addEventListener("load", function () {
  main();
  // Scrollbar.init(document.querySelector("#my-scrollbar"));

});