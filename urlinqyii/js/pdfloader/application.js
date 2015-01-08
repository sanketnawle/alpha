var previous = "";
var events={};

window.onload = function () {
  run_pdf_algo();
  
};

function run_pdf_algo(){
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

}


function highlightText(){
  var rex=[];
  var text = $('div.textLayer').children();

  $.each(text,function(index, value){
    if($(value).attr("analyzed")!="1"){
    $(value).css({'padding-left':'6px'});
    var text_value = $(value).text();
    var matched = chronotext(text_value.replace(".", ""));
    if(matched && $.trim(matched[0][0]).length>3){
          get_date(text_value+" "+$(text[index+1]).text().slice(0,5));
          if(text_value.indexOf(matched[0][0])<0){
            $(value).html('<span style="opacity:0.1;background-color:#2E0854;">'+$(value).text()+'</span>');
          }
          else{
          var after_rep=text_value.replace(matched[0][0],'<span style="opacity:0.1;background-color:#2E0854;">'+matched[0][0]+'</span>');
          $(value).html(after_rep);
          }
          $(value).attr("analyzed","1");
    }

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
      //get_date(input);
      return data;
    }
    else{
      previous = input;
      return false;
    }
  }

var get_date= function(input){
  var raw_input = input;
  var found = false;
  /*
    matches mm/dd, mm-dd, mm.dd
    matches mm/dd/yy mm-dd-yy mm.dd.yy mm/dd/yyyy mm-dd-yyyy mm.dd.yyyy
    matches Full month name dd,
  */
  var months = "(January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)";
  var days = "(01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)";
  var days_one_char = "(1|2|3|4|5|6|7|8|9)";
  var years = "([1-3][0-9][0-9][0-9])";
  var times = "((([1-9])|(0[1-9])|(1[0-9])|(2[0-4])):((0[0-9])|([1-5][0-9])|(60))|((1|2|3|4|5|6|7|8|9)(| )(am|pm)))";
  var times_moment = "("+times+"(| )(am|pm))";

  var matched_month = input.match(new RegExp(months+"( |, | , |. | . )"+days, 'ig'));
  if (!matched_month){
    matched_month = input.match(new RegExp(months+"( |, | , |. | . )"+days_one_char, 'ig'));
  }
  if(matched_month){
    for(i=0;i<matched_month.length;i++){
      var final_date = "";
      input = input.slice(input.indexOf(matched_month[i])+matched_month[i].length, input.length); //input.replace(matched_month[i],"");
      final_date+=matched_month[i]+",";
      var matched_year = input.match(new RegExp(years, 'ig'));
      if (matched_year){
      final_date+=" "+matched_year[0];
      input = input.slice(input.indexOf(matched_year[0])+matched_year[0].length, input.length);//input.replace(matched_year[0],"")
      }
      else{
        final_date+=" "+(new Date()).getFullYear();
      }
      var matched_time = input.match(new RegExp(times_moment, 'ig')) ;
      if(matched_time){
        matched_time[0] = $.trim(matched_time[0]);
        if(matched_time.indexOf(" ")<0){
          matched_time[0] =matched_time[0].slice(0,matched_time[0].length-2) +" "+ matched_time[0].slice(matched_time[0].length-2,matched_time[0].length);
        }
        final_date+=" "+matched_time[0].toUpperCase();
      input = input.slice(input.indexOf(matched_time[0])+matched_time[0].length, input.length);//input.replace(matched_time[0],"")
      }
      else {
        matched_time = input.match(new RegExp(times, 'ig')) ;
        if(matched_time){
          matched_time[0] = $.trim(matched_time[0]);
          if(matched_time.indexOf(" ")<0){
            matched_time[0] =matched_time[0].slice(0,matched_time[0].length-2) +" "+ matched_time[0].slice(matched_time[0].length-2,matched_time[0].length);
          }
          final_date+=" "+matched_time[0].toUpperCase();
          input = input.slice(input.indexOf(matched_time[0])+matched_time[0].length, input.length);//input.replace(matched_time[0],"")
        }
      }
      if(!events.hasOwnProperty(final_date)){
        events[final_date] = ((previous+raw_input).split(matched_month)[0]).split(".").pop();
      }
    }
  }
  var stage_two_input = input;
  var mmddyyyy = "([1-3]?[0-9])(\/|-|.)([1-3]?[0-9])(\/|-|.)([0-9][0-9][0-9][0-9])";
  var mmddyy = "([1-3]?[0-9])(\/|-|.)([1-3]?[0-9])(\/|-|.)([0-9][0-9])";
  var matched_mmddyyyy = stage_two_input.match(new RegExp(mmddyyyy, 'ig'));
  if (matched_mmddyyyy){
    if(!events.hasOwnProperty(matched_mmddyyyy[0])){
        events[matched_mmddyyyy[0]] = ((previous+raw_input).split(matched_month)[0]).split(".").pop();
      }
  }
  else{
    var matched_mmddyy = stage_two_input.match(new RegExp(mmddyy, 'ig'));
    if(matched_mmddyy){
      if(!events.hasOwnProperty(matched_mmddyy[0])){
        events[matched_mmddyy[0]] = ((previous+raw_input).split(matched_month)[0]).split(".").pop();
      }
    }
  }
  console.log(events);
}
