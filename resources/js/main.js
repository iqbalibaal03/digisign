import "../css/main.css";
import data from "./init-alpine";
import "./focus-trap";

import Alpine from "alpinejs";
window.Alpint = Alpine;

Alpine.data("data", data);
Alpine.start();
