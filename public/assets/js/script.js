"use strict";

var BASE64_MARKER = ";base64,";
function convertDataBase64ToBinary(dataBase64) {
  var base64Index = dataBase64.indexOf(BASE64_MARKER) + BASE64_MARKER.length;
  var base64 = dataBase64.substring(base64Index);
  var raw = window.atob(base64);
  var rawLength = raw.length;
  var array = new Uint8Array(new ArrayBuffer(rawLength));

  for (var i = 0; i < rawLength; i++) {
    array[i] = raw.charCodeAt(i);
  }
  return array;
}

function dataURItoBlob(dataURI) {
  // convert base64 to raw binary data held in a string
  // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
  var byteString = atob(dataURI.split(",")[1]);

  // separate out the mime component
  var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];

  // write the bytes of the string to an ArrayBuffer
  var ab = new ArrayBuffer(byteString.length);
  var ia = new Uint8Array(ab);
  for (var i = 0; i < byteString.length; i++) {
    ia[i] = byteString.charCodeAt(i);
  }

  //Old Code
  //write the ArrayBuffer to a blob, and you're done
  //var bb = new BlobBuilder();
  //bb.append(ab);
  //return bb.getBlob(mimeString);

  //New Code
  return new Blob([ab], { type: mimeString });
}

function renderPDF(url, canvasContainer, options) {
  var pdfjs = window["pdfjs-dist/build/pdf"];
  var options = options || { scale: 1 };

  function renderPage(page) {
    var viewport = page.getViewport({ scale: 1 });
    var canvas = document.createElement("canvas");
    canvas.setAttribute("id", page.pageNumber);
    var contex = canvas.getContext("2d");
    var renderContext = {
      canvasContext: contex,
      viewport: viewport,
    };

    canvas.height = viewport.height;
    canvas.width = viewport.width;
    canvasContainer.appendChild(canvas);

    page.render(renderContext);
  }

  function pageNumber(pdfDoc) {
    for (var page = 1; page <= pdfDoc.numPages; page++) {
      pdfDoc.getPage(page).then(renderPage);
    }
  }

  //   url = convertDataBase64ToBinary(url);
  var setPDF = pdfjs.getDocument(url);
  setPDF.promise.then(pageNumber);
}

renderPDF(
  `/uploads/documents/original/${document.querySelector("#fileName").value}`,
  document.getElementById("documentRender"),
  {
    scale: 1,
  }
);

document.getElementById("save").addEventListener("click", async function () {
  var container = document.getElementById("documentRender");
  var image = document.getElementById("drag");

  var childs = container.childNodes;
  var childsFiltered = Array.from(childs).filter((e) => e.nodeName == "CANVAS");
  var gapSize = 9.6; // Gap size
  var dataX = image.getAttribute("data-x"); // Sumbu X
  var dataY = image.getAttribute("data-y"); // Sumbu Y
  var imageWidth = image.getAttribute("width"); // Lebar tanda tangan
  var imageHeight = image.getAttribute("height"); // Tinggi tanda tangan

  // Get selected page canvas
  var selectedPageNode = childsFiltered.find(
    (e) => e.getAttribute("id") == Math.ceil(dataY / 842)
  );

  // Get selected Page number
  var selectedPage = Math.ceil(dataY / 842);
  dataY =
    selectedPage == 1
      ? dataY
      : dataY - 842 * (selectedPage - 1) - gapSize * (selectedPage - 1);

  // initialize new context
  var context = selectedPageNode.getContext("2d");
  context.drawImage(image, dataX, dataY, imageWidth, imageHeight);

  // Create time stamp for signature
  const datetime = new Date();
  var dataYText = parseInt(dataY) + parseInt(imageHeight) + 10;
  context.font = "10px Georgia";
  context.fillText(datetime.toLocaleDateString(), dataX, dataYText);
  context.fillText(datetime.toLocaleTimeString(), dataX, dataYText + 12);

  // Create new PDF
  window.jsPDF = window.jspdf.jsPDF;
  var jspdf = new window.jsPDF("p", "mm", "a4");

  // Re-Create pdf file
  console.log("Re-Create PDF file");
  // for (const child of childsFiltered) {
  //   var blob = dataURItoBlob(child.toDataURL());
  //   var file = new File([blob], "test", { type: "image/png" });
  //   const formData = new FormData();
  //   formData.append("image", child.toDataURL());

  //   var files = await fetch("https://api.deepai.org/api/torch-srgan", {
  //     method: "POST",
  //     body: formData,
  //     headers: {
  //       "api-key": "caa5e5ce-c76a-4597-8ecb-8fb4a1f28e18",
  //     },
  //   }).then((response) => response.json());

  //   var blob = await fetch(files.output_url).then((response) =>
  //     response.blob()
  //   );

  //   var fileReader = new FileReader();
  //   fileReader.readAsDataURL(blob);
  //   fileReader.onloadend = function (pe) {
  //     const pdfWidth = jspdf.internal.pageSize.getWidth();
  //     const pdfHeight = jspdf.internal.pageSize.getHeight();

  //     jspdf.addPage();
  //     jspdf.addImage(pe.target.result, "JPG", 0, 0, pdfWidth, pdfHeight);
  //   };
  // }

  childsFiltered.forEach((el, index) => {
    const pdfWidth = jspdf.internal.pageSize.getWidth();
    const pdfHeight = jspdf.internal.pageSize.getHeight();
    jspdf.addImage(el.toDataURL(), "PNG", 0, 0, pdfWidth, pdfHeight);
    if (index < childsFiltered.length - 1) jspdf.addPage();
  });

  // console.log("Done re-create pdf file");

  var file = jspdf.output("blob");

  var formData = new FormData();
  formData.append("pdf", file);
  formData.append("filename", document.querySelector("#fileName").value);
  formData.append("documentID", document.querySelector("#documentID").value);
  formData.append("xPDF", parseInt(dataX));
  formData.append("yPDF", parseInt(dataY));
  formData.append("imageWidth", parseInt(imageWidth));
  formData.append("imageHeight", parseInt(imageHeight));
  formData.append("selectedPage", selectedPage);

  console.log("Upload file to server");

  // await fetch("/edited", {
  //   method: "POST",
  //   body: formData,
  // })
    
  //   .finally(function () {
  //    console.log('done')
  //   });

  $.ajax({
    method: "POST",
    url: "/edited",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      console.log(response);
    },
    error: function (error) {
      console.log(error);
    },
  })
  .done(function () {
    var url = new URL(location.href);
    var redirect = url.searchParams.get('redirect') ?? '';

    if(redirect != '') {
      console.log(redirect);
      location = '/sent-docs'
    } else {
      console.log(redirect);
      location = '/mydocuments'
    }
  });
});

const position = { x: 0, y: 0 };

function dragMoveListener(event) {
  var target = event.target;
  // keep the dragged position in the data-x/data-y attributes
  var x = (parseFloat(target.getAttribute("data-x")) || 0) + event.dx;
  var y = (parseFloat(target.getAttribute("data-y")) || 0) + event.dy;
  // console.log("Coordinates X : " + x + " Coordinates Y : " + y);

  // translate the element
  target.style.transform = "translate(" + x + "px, " + y + "px)";

  // update the posiion attributes
  target.setAttribute("data-x", x);
  target.setAttribute("data-y", y);
}

// this function is used later in the resizing and gesture demos
window.dragMoveListener = dragMoveListener;

interact("#drag")
  .resizable({
    // resize from all edges and corners
    edges: { left: true, right: true, bottom: true, top: true },

    listeners: {
      move(event) {
        var target = event.target;
        var x = parseFloat(target.getAttribute("data-x")) || 0;
        var y = parseFloat(target.getAttribute("data-y")) || 0;

        // update the element's style
        target.style.width = event.rect.width + "px";
        target.style.height = event.rect.height + "px";

        // translate when resizing from top or left edges
        x += event.deltaRect.left;
        y += event.deltaRect.top;

        target.style.transform = "translate(" + x + "px," + y + "px)";

        target.setAttribute("data-x", x);
        target.setAttribute("data-y", y);
        target.setAttribute("width", event.rect.width);
        target.setAttribute("height", event.rect.height);
        target.textContent =
          Math.round(event.rect.width) +
          "\u00D7" +
          Math.round(event.rect.height);
      },
    },
    modifiers: [
      // keep the edges inside the parent
      interact.modifiers.restrictEdges({
        outer: "parent",
      }),

      // minimum size
      interact.modifiers.restrictSize({
        min: { width: 100, height: 50 },
      }),
    ],
  })
  .draggable({
    listeners: { move: window.dragMoveListener },
    autoScroll: true,
    modifiers: [
      interact.modifiers.restrictRect({
        restriction: "parent",
        endOnly: true,
      }),
    ],
  });
