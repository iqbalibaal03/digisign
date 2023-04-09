import { Chart } from "chart.js/auto";

import barConfig from "./charts-bars";
import lineConfig from "./charts-lines";
import pieConfig from "./charts-pie";

// change this to the id of your chart element in HMTL
const barsCtx = document.getElementById("bars");
window.myBar = barsCtx ? new Chart(barsCtx, barConfig) : null;

// change this to the id of your chart element in HMTL
const lineCtx = document.getElementById("line");
window.myLine = lineCtx ? new Chart(lineCtx, lineConfig) : null;

// change this to the id of your chart element in HMTL
const pieCtx = document.getElementById("pie");
window.myPie = pieCtx ? new Chart(pieCtx, pieConfig) : null;
