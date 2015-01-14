var file_id = 0;
var previous = "";
var events={};
var pdf_year= (new Date()).getFullYear();

window.onload = function () {
  load_events();
  run_pdf_algo(false);
  
};

var run_pdf_algo = function(db){
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
      highlightText(db)                 ;
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
            if(response["file_url"]){
              $('div#pdfContainer').attr("pdf_location",response["file_url"]);
              loadPdf(globals.base_url+response["file_url"]);
            }
            
         },
         error: function(jqXHR, textStatus, errorMessage) {
             console.log(errorMessage); // Optional
         }
      });

}



function highlightText(db){
  var full_text = "";
  var text = $('div.textLayer').children();
  $.each(text,function(index, value){
    full_text+= $(value).text()+" ";
  });
  var sem_year = "(spring|fall|summer|winter)(.*?)([0-9][0-9][0-9][0-9])";
  full_text = full_text.replace(/\s{2,}/g, ' ');
  sem_year_matched = full_text.match(new RegExp(sem_year, "ig"));
  if (sem_year_matched){
    pdf_year = sem_year_matched[0].slice(sem_year_matched[0].length-4,sem_year_matched[0].length);
  }
  $.each(text,function(index, value){
    if($(value).attr("analyzed")!="1"){
    $(value).css({'padding-left':'6px'});
    previous = $(text[index-1]).text();
    next = $(text[index+2]).text();
    var text_value = $(value).text();
    var matched = chronotext(text_value);
    if(matched && $.trim(matched[0][0]).length>2 && isNaN($.trim(matched[0][0]))){
          if(db){
          get_date(text_value+" "+$(text[index+1]).text().slice(0,5));
          }

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
      return data;
    }
    else{
      var matched_month = input.match("(Jan(.|,)|Feb(.|,)|Mar(.|,)|Apr(.|,)|May(.|,)|Jun(.|,)|Jul(.|,)|Aug(.|,)|Sep(.|,)|Oct(.|,)|Nov(.|,)|Dec(.|,))",'ig')
      if(matched_month){
        var mon = [];
        mon[0]=matched_month;
        return mon;
      }
      return false;
    }
  }

var get_date= function(input){
  input = input.replace(/\s{2,}/g, ' ');
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
        final_date+=" "+pdf_year;
      }
      var matched_time = input.match(new RegExp(times_moment, 'ig')) ;
      if(matched_time){
        matched_time[0] = $.trim(matched_time[0]);
        if(matched_time.indexOf(" ")<0){
          matched_time[0] =matched_time[0].slice(0,matched_time[0].length-2) +" "+ matched_time[0].slice(matched_time[0].length-2,matched_time[0].length);
        }
          matched_time[0] = format_time(matched_time[0])
        final_date+=" "+matched_time[0].toUpperCase();
      input = input.slice(input.indexOf(matched_time[0])+matched_time[0].length, input.length);//input.replace(matched_time[0],"")
      }
      else {
        matched_time = input.match(new RegExp(times, 'ig'));
        if(matched_time){
          matched_time[0] = $.trim(matched_time[0]);
          if(matched_time.indexOf(" ")<0){
            matched_time[0] =matched_time[0].slice(0,matched_time[0].length-2) +" "+ matched_time[0].slice(matched_time[0].length-2,matched_time[0].length);
          }
          matched_time[0] = format_time(matched_time[0])
          final_date+=" "+matched_time[0].toUpperCase();
          input = input.slice(input.indexOf(matched_time[0])+matched_time[0].length, input.length);//input.replace(matched_time[0],"")
        }
      }
      if(!events.hasOwnProperty(final_date)){
        var title = get_title(((previous+" "+raw_input).split(matched_month)[0]).split(".").pop());
        events[final_date] = title;
      }
    }
  }
  var stage_two_input = input;
  var mmddyyyy = "(([1-3]?[0-9])\/([1-3]?[0-9])\/([0-9][0-9][0-9][0-9]))|(([1-3]?[0-9])-([1-3]?[0-9])-(([0-9][0-9][0-9][0-9])))|(([1-3]?[0-9]).([1-3]?[0-9]).(([0-9][0-9][0-9][0-9])))";
  var mmddyy = "(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{2})";
  var mmdd = "([1-3]?[0-9])\/([1-3]?[0-9])";
  var matched_mmddyyyy = stage_two_input.match(new RegExp(mmddyyyy, 'ig'));
  if (matched_mmddyyyy){
    if(!events.hasOwnProperty(matched_mmddyyyy[0])){
      var title = get_title(((previous+" "+raw_input).split(matched_mmddyyyy)[0]).split(".").pop());
        events[matched_mmddyyyy[0]] = title;
      }
  }
  else{
    var matched_mmddyy = stage_two_input.match(new RegExp(mmddyy));
    if(matched_mmddyy){
      if(!events.hasOwnProperty(matched_mmddyy[0])){
        var title = get_title(((previous+" "+raw_input).split(matched_mmddyy)[0]).split(".").pop());
        events[matched_mmddyy[0]] = title;
      }
    }
    else{
      var matched_mmdd = stage_two_input.match(new RegExp(mmdd, 'ig'));
      if (matched_mmdd){
        matched_mmdd[0] = matched_mmdd[0]+"/"+pdf_year;
        if(!events.hasOwnProperty(matched_mmdd[0])){
          var title = get_title(((previous+" "+raw_input).split(matched_mmdd)[0]).split(".").pop());
            events[matched_mmdd[0]] = title;
          }
      }
    }
  }
  add_event_to_ui(events);
}


var format_time = function(time_value){
  time_value = time_value.replace(/\s{2,}/g, ' ');
  var split_space = time_value.split(" ");
  var split_time = split_space[0].split(":");
  if(split_time.length>1){
    if(split_time[0].length==1){
      if(split_time[1].length==1){
        return "0"+split_time[0]+":0"+split_time[1]+" " + split_space[1];
      }
      else{
        return "0"+split_time[0]+":"+split_time[1]+" " + split_space[1];
      }
    }
    else{
      if(split_time[1].length==1){
        return split_time[0]+":0"+split_time[1]+" " + split_space[1];
      }
      else{
        return split_time[0]+":"+split_time[1]+" " + split_space[1];
      }
    }
  }
  else{
    if(split_time[0].length==1){
      return "0"+split_time[0]+":00 " + split_space[1];
    }
    else{
      return split_time[0]+":00 " + split_space[1];
    }
  }
}


var get_title = function(title){
  var junk = ",|-|.|!|\/";
  var after_rep_junk = title.replace(new RegExp(junk), "");
  var after_rep_num = after_rep_junk.replace(new RegExp("[0-9]", "g"), "")
  if($.trim(after_rep_num).length<4){
    return next;
  }
  else{
    return title;
  }
}

var added_events = new Array();

var add_event_to_ui = function(events_generated){
  html_text = "";
 
  $.each(events_generated,function(index, value){
    var stamp = new Date(Date.parse(index));
    if(stamp && added_events.indexOf(String(stamp))<0){
      var php_time = stamp.getFullYear()+"-"+(stamp.getMonth()+1)+"-"+stamp.getDate()+" "+stamp.getHours()+":"+stamp.getMinutes()+":"+stamp.getSeconds();
      var get_data_json = {"class_id":globals.origin_id,"file_id":String(file_id),"event_title":value,"event_date":php_time,"event_type":"default"}; 
      $.ajax({
         url: "StoreEvent",
         type: "GET",
         data: get_data_json,
         success: function(response) {
          //var parsed_response = ;
          html_text='<div id="'+response+'" class = "syllabus_event editable">\
                    <div class = "day_month_box day_box_color">\
                        <div class = "calendar_top_border"></div>\
                        <div class = "calendar_bottom_section">\
                            <span class = "day">'+stamp.getDate()+'</span>\
                            <span class = "month">'+month[stamp.getMonth()]+'</span>\
                        </div>\
                    </div>\
                    <div class = "event_name_buttons">\
                        <span class ="event_name_text">\
                            Midterm 1\
                        </span>\
                        <input class = "syla_tab_event_editor" type = "text" name = "event_name" value="'+value+'"">\
                        <div class = "done_editing_button">\
                            Done\
                        </div>\
                    </div>\
                </div>';
            $('div#events_list').append(html_text);
         },
         error: function(jqXHR, textStatus, errorMessage) {
             console.log(errorMessage); // Optional
         }
      });
      
      added_events.push(String(stamp));
    }
    else{
      console.log(index);
    }
  });
}