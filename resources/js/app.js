import "./bootstrap";

import "../css/app.css";

import "@glidejs/glide/dist/css/glide.core.min.css";

import "../scss/main.scss";

import $ from 'jquery';

window.$ = $;
window.jQuery = $;

//Glide Slider
import Glide from "@glidejs/glide";

//AlpineJS
import Alpine from "alpinejs";

window.Glide = Glide;
