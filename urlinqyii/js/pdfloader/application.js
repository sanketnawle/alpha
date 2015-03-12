var file_id = 0;
var previous = "";
var editable=" editable";
var events={};
var pdf_year= (new Date()).getFullYear();
var previous_title_empty = false;
var previous_title_index = "";
var class_color = "";


window.onload = function () {
  var edit_access = true;
  class_color = get_class_color();
  file_json = get_pdf();
  if(file_json["file_id"]){
    if(!file_json["edit_access"]){
      editable = "";
      edit_access = false;
      $('#btn_add_syllabus').html("View Syllabus");
      $('#btn_add_syllabus').attr("id", "btn_view_syllabus");

    }

    events_list = load_events(file_json["file_id"]);
    if(events_list.length>0){
      //$("#events_template_loc").show();
      Polymer('music-demo', {

            page: 0,

            items: events_list.slice(0,4),
            count_text : events_list.length+" Total events this semester",
            allitems: events_list,

            selectedAlbum: null,

            right_arrow: "block",
            edit_access: edit_access,
            left_arrow: "none",

            pagecount: Math.ceil(events_list.length/4),

            current_page: 0,

            showdesctext:false,

            descinput:false,

            showdescinput: function(e){
              if(this.edit_access){
                if(this.descinput){
                  this.descinput = false;
                }
                else{
                  this.descinput =true;
                }
            }
            },

            change_description: function() {
              desc_text_value = this.$.event_description.querySelector('textarea').value;
              desc_event_id = this.$.event_description.querySelector('span').textContent;
              $.ajax({
                   url: "UpdateSyllabusEvent",
                   type: "POST",
                   data: {"id":desc_event_id,"description":desc_text_value},
                   success: function(response) {
                   },
                   error: function(jqXHR, textStatus, errorMessage) {
                       console.log(errorMessage); // Optional
                   }
              });
              this.descinput=false;
              this.showdesctext=true;
              this.selectedAlbum.description=desc_text_value;
            },

            showlocationtext:true,

            locationinput:false,

            showlocationinput: function(e){
              if(this.edit_access){

                if(this.locationinput){
                this.locationinput =false;
                }
                else{
                this.locationinput =true;
                }
              }
            },

            change_location: function() {
              location_text_value = this.$.event_location.querySelector('textarea').value;
              location_event_id = this.$.event_location.querySelector('span').textContent;
              $.ajax({
                   url: "UpdateSyllabusEvent",
                   type: "POST",
                   data: {"id":location_event_id,"location":location_text_value},
                   success: function(response) {
                   },
                   error: function(jqXHR, textStatus, errorMessage) {
                       console.log(errorMessage); // Optional
                   }
              });
              this.locationinput=false;
              this.showlocationtext=true;
              this.selectedAlbum.location=location_text_value;
            },

            transition: function(e) {
              if (this.page === 0 && e.target.templateInstance.model.item) {
                this.selectedAlbum = e.target.templateInstance.model.item;
                this.page = 1;
              } else {
                this.page = 0;
              }
            },

            clicked_previous: function(e){
              var page_value = this.current_page;
                  this.current_page = this.current_page - 1;
                  if(page_value-1==0){
                    this.left_arrow = "none";
                  }
                  start = (page_value)*4;
                  this.items = this.allitems.slice(start-4,start);
                  console.log(start-4 ,start);
                  Platform.performMicrotaskCheckpoint();
                  this.right_arrow = "block";
            },
            clicked_next:function(e){
              console.log(this.items);
               var page_value = this.current_page;
                  this.current_page = this.current_page + 1;
                  if(page_value+2==this.pagecount){
                    this.right_arrow = "none";
                  }
                  start = (page_value+1)*4;
                  this.items = this.allitems.slice(start,start+4);
                  Platform.performMicrotaskCheckpoint();
                  this.left_arrow = "block";
            }
        });
   
        }

  run_pdf_algo(false, globals.base_url+file_json["file_url"]);
  }
  
};

var run_pdf_algo = function(db, pdf_url){
  if (typeof PDFJS === 'undefined') {
    alert('Built version of pdf.js is not found\nPlease run `node make generic`');
    return;
  }

  var scale = 1.34; //Set this to whatever you want. This is basically the "zoom" factor for the PDF.

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
              loadPdf(pdf_url);
  
}

function get_pdf(){
  var resp = $.ajax({
         url: "GetSyllabusPDF?class_id="+globals.origin_id,
         type: "GET",
         async: false,
         success: function(response) {
            
         },
         error: function(jqXHR, textStatus, errorMessage) {
             console.log(errorMessage); // Optional
         }
      });
  var respJSON = $.parseJSON(resp.responseText);
  if(respJSON){
              $("a#class_syllabus_pdf").attr("href",globals.base_url+respJSON["file_url"]);
              $('div#pdfContainer').attr("pdf_location",respJSON["file_url"]);
              return respJSON;
            }
  return false;
}

function highlightText(db){
  var data_cs = $('div.textLayer').children();
  var previous_css = "0";
  var div_dict = {};
  $.each(data_cs,function(index,value){
    if($(value).css("top")==previous_css || $(value).text()[0].match(/[a-z]/g)){

      div_dict[previous_css]+=" "+$(value).text();

    }
    else{
      div_dict[$(value).css("top")] = $(value).text();
      previous_css = $(value).css("top");
    }
  });
  $.each(div_dict,function(index,value){
   get_date_v2(value);
  });
  if(db){
  add_event_to_ui(events);
  }
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
    if(matched && $.trim(matched[0][0]).length>3 && isNaN($.trim(matched[0][0]))){
          if(text_value.indexOf(matched[0][0])<0){
            $(value).html('<span style="border-bottom: 1px solid '+class_color+';">'+$(value).text()+'</span>');
          }
          else{
          var after_rep=text_value.replace(matched[0][0],'<span style="border-bottom: 1px solid '+class_color+';">'+matched[0][0]+'</span>');
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
      var matched_month = input.match(/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)(,|\.)/ig);
      if(matched_month){
        var mon = [];
        mon[0]=matched_month;
        return mon;
      }
      return false;
    }
  }



var added_events = new Array();

var add_event_to_ui = function(events_generated){
  html_text = "";
  
  $.each(events_generated,function(index, value){
    var stamp = new Date(Date.parse(index));
    description = value;
    value = get_valid_title(value);
    if(stamp && added_events.indexOf(String(stamp))<0){
      var php_time = pdf_year+"-"+(stamp.getMonth()+1)+"-"+stamp.getDate()+" "+stamp.getHours()+":"+stamp.getMinutes()+":"+stamp.getSeconds();
      var get_data_json = {"class_id":globals.origin_id,"file_id":String(file_id),"event_title":value,"event_date":php_time,"event_type":"default", "description":description}; 
      $.ajax({
         url: "StoreEvent",
         type: "POST",
         data: get_data_json,
         success: function(response) {

            
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




var get_date_v2= function(input){
  input = input.replace(/\s{2,}/g, ' ');
  
  /*
    matches mm/dd, mm-dd, mm.dd
    matches mm/dd/yy mm-dd-yy mm.dd.yy mm/dd/yyyy mm-dd-yyyy mm.dd.yyyy
    matches Full month name dd,
  */
  var title = "";
  var stri = input.match(/((01|02|03|04|05|06|07|08|09|10|11|12)|(1|2|3|4|5|6|7|8|9))(\/)((01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)|(1|2|3|4|5|6|7|8|9))(((\/)(([0-9][0-9])|([1-3][0-9][0-9][0-9])))?)/ig);
  var replacing = /(?!(January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|am|pm|AM|PM|Am|Pm)\b)\b([a-z]+|@|th|nd)/ig;
  var replace_special = /@|!/g;
  if (stri){
    if(stri.length>1){
      $.each(stri, function(index,value){
        stri[index] = value.replace(replacing, "");
        stri[index] = value.replace(replace_special, "");
        var split_text=input.split(value);
        input = split_text[1];
        title = split_text[0];
        if(!events.hasOwnProperty(stri[index])){
          events[stri[index]] = title;
        }
      });
    }
    else{
      $.each(stri, function(index,value){
        stri[index] = value.replace(replacing, "");
        stri[index] = value.replace(replace_special, "");
        title=input.replace(value,"");
        if(!events.hasOwnProperty(stri[index])){
          events[stri[index]] = title;
          if($.trim(title) == ""){
            previous_title_empty = true;
            previous_title_index = stri[index];
          }
        }
      });
    }
  }
   else{
    if(previous_title_empty){
      events[previous_title_index] = input;
      previous_title_empty = false;
    }
  }

  var stri_2 = input.match(/(January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)(\s?)(|,|\.)(\s?)((01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)|(1|2|3|4|5|6|7|8|9))(\s?)(|,|\.)(\s?)((([0-9][0-9])|([1-3][0-9][0-9][0-9]))?)/ig);
  if (stri_2){
    if(stri_2.length>1){
      $.each(stri_2, function(index,value){
        var split_text=input.split(value);
        input = split_text[1];
        title = split_text[0];
        stri_2[index] = value.replace(replacing, "");
        stri_2[index] = value.replace(replace_special, "");
        if(!events.hasOwnProperty(stri_2[index])){
          events[stri_2[index]] = title;
        }
      });
    }
    else{
      $.each(stri_2, function(index,value){
        title=input.replace(value,"");
        stri_2[index] = value.replace(replacing, "");
        stri_2[index] = value.replace(replace_special, "");
        if(!events.hasOwnProperty(stri_2[index])){
          events[stri_2[index]] = title;
          if($.trim(title) == ""){
            previous_title_empty = true;
            previous_title_index = stri_2[index];
          }
        }
      });
    }

  }
  else{
    if(!stri && previous_title_empty){
      events[previous_title_index] = input;
      previous_title_empty = false;
    }
  }
}

var get_valid_title= function(title){
  mid_term_keywords = ["midterm","mid"];
  test_keywords = ["test"];
  exam_keywords = ["final exam", "finals", "exam", "final"];
  lab_keywords = ["lab", "practical"];
  lecture_keywords = ["lecture", "class", "session"];
  lower_case_title = title.toLowerCase();

  for(i=0; i<mid_term_keywords.length; i++){
    if(lower_case_title.indexOf(mid_term_keywords[i])>=0){
      return "Midterm";
    }
  }
  for(i=0; i<exam_keywords.length; i++){
    if(lower_case_title.indexOf(exam_keywords[i])>=0){
      return "Final Exam";
    }
  }
  for(i=0; i<lab_keywords.length; i++){
    if(lower_case_title.indexOf(lab_keywords[i])>=0){
      return "Lab";
    }
  }
  for(i=0; i<lecture_keywords.length; i++){
    if(lower_case_title.indexOf(lecture_keywords[i])>=0){
      return "Lecture";
    }
  }
  console.log("Returning default");
  return "Lecture";
};
//(((.*)((\d{1,2}\s?am|pm)|(((\d{1,2}:\d{1,2})?)(\s?)((am|pm)?))))?)