import "../css/main.css";
import data from "./init-alpine";
import selfSignImage from '../images/self-sign.jpg'
import signAndShareImage from '../images/sign-and-share.jpg'
import shareOnlyImage from '../images/share-only.jpg'

import Alpine from "alpinejs";
window.Alpint = Alpine;

Alpine.data("data", data);
Alpine.start();

document.querySelector('#selfSign').src = selfSignImage;
document.querySelector('#signAndShare').src = signAndShareImage;
document.querySelector('#shareOnly').src = shareOnlyImage;
