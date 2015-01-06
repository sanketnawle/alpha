window.onload = function () {

  console.log("clicked");
  if (typeof PDFJS === 'undefined') {
    alert('Built version of pdf.js is not found\nPlease run `node make generic`');
    return;
  }

  var scale = 0.85; //Set this to whatever you want. This is basically the "zoom" factor for the PDF.

  function loadPdf(pdfPath) {
    var pdf = PDFJS.getDocument(pdfPath);
    return pdf.then(renderPdf);
  }

  function renderPdf(pdf) {
    var numPages = pdf.numPages;
    var page_list = [];
    for(page_number = 1; page_number <= numPages; page_number++){
      page_list.push( pdf.getPage(page_number).then(renderPage));
    }
    return page_list;
  }

  function renderPage(page) {
    var viewport = page.getViewport(scale);

    // Create and append the 'pdf-page' div to the pdf container.
    var pdfPage = document.createElement('div');
    pdfPage.className = 'pdfPage';
    var pdfContainer = document.getElementById('pdfContainer');
    pdfContainer.appendChild(pdfPage);

    // Set the canvas height and width to the height and width of the viewport.
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');

    // The following few lines of code set up scaling on the context, if we are
    // on a HiDPI display.
    var outputScale = getOutputScale(context);
    canvas.width = (Math.floor(viewport.width) * outputScale.sx) | 0;
    canvas.height = (Math.floor(viewport.height) * outputScale.sy) | 0;
    context._scaleX = outputScale.sx;
    context._scaleY = outputScale.sy;
    if (outputScale.scaled) {
      context.scale(outputScale.sx, outputScale.sy);
    }

    // The page, canvas and text layer elements will have the same size.
    canvas.style.width = Math.floor(viewport.width) + 'px';
    canvas.style.height = Math.floor(viewport.height) + 'px';

    pdfPage.style.width = canvas.style.width;
    pdfPage.style.height = canvas.style.height;
    pdfPage.appendChild(canvas);

    var textLayerDiv = document.createElement('div');
    textLayerDiv.className = 'textLayer';
    textLayerDiv.style.width = canvas.style.width;
    textLayerDiv.style.height = canvas.style.height;
    pdfPage.appendChild(textLayerDiv);
    
    // Painting the canvas...
    var renderContext = {
      canvasContext: context,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    //Step : hook into the pdf render complete event
    var completeCallback = renderTask.internalRenderTask.callback;
    renderTask.internalRenderTask.callback = function (error) {
      //Step 2: what you want to do before calling the complete method 
      highlightText()                 ;
      completeCallback.call(this, error);
      //Step 3: do some more stuff
    };
    // ... and at the same time, getting the text and creating the text layer.
    var textLayerPromise = page.getTextContent().then(function (textContent) {

      var textLayerBuilder = new TextLayerBuilder({
        textLayerDiv: textLayerDiv,
        viewport: viewport,
        pageIndex: 0
      });
      textLayerBuilder.setTextContent(textContent);
    });

    // We might be interested when rendering complete and text layer is built.
    return Promise.all([renderTask.promise, textLayerPromise]);
  }
  document.addEventListener('resolved', highlightText, true);
  $.ajax({
         url: "GetSyllabusPDF?class_id="+globals.origin_id,
         type: "GET",
         success: function(response) {
            loadPdf(globals.base_url+response["file_url"])
        
         },
         error: function(jqXHR, textStatus, errorMessage) {
             console.log(errorMessage); // Optional
         }
      });

};


function highlightText(){
  var rex=[];
  var text = $('div.textLayer').children();

  $.each(text,function(index, value){
    $(value).css({'padding-left':'6px'});
    var text_value = $(value).text();
    var matched = chronotext(text_value);
    if(matched){
          var after_rep=text_value.replace(matched[0][0],'<span style="opacity:0.1;background-color:#52F7B4;">'+matched[0][0]+'</span>');
          $(value).html(after_rep);
    }

      
  });
}

var removeElements = function(text, selector) {
    var wrapped = $("<div>" + text + "</div>");
    wrapped.find(selector).remove();
    return wrapped.html();
}

var chronotext = function(input){
    var parsed = chrono.parse(input);
    var data = parsed.map(function(p) { return [p.text, p.startDate, Date.parse(p.text)]; });
    if(data.length>0){
      return data;
    }
    else{
      return false;
    }
  }