
  $(function() {
  $('#popupDatepicker').datepick();
  $('#clickEvent1').bind('click', function(event) {
    $('#button1').empty();
    var eventContent = $('#clickEvent1').text();
    console.log(eventContent);
    var node1 = "<span id='eventIn1'>";
    $('#button1').text(eventContent);
    $('#button1').prepend(node1);

  });
  $('#popupDatepicker').datepick();
  $('#clickEvent2').bind('click', function(event) {
    $('#button1').empty();
    var eventContent = $('#clickEvent2').text();
    console.log(eventContent);
    var node1 = "<span id='eventIn2'>";
    $('#button1').text(eventContent);
    $('#button1').prepend(node1);

  });
  $('#popupDatepicker').datepick();
  $('#clickEvent3').bind('click', function(event) {
    $('#button1').empty();
    var eventContent = $('#clickEvent3').text();
    console.log(eventContent);
    var node1 = "<span id='eventIn3'>";
    $('#button1').text(eventContent);
    $('#button1').prepend(node1);

  });
  $('#popupDatepicker').datepick();
  $('#clickEvent4').bind('click', function(event) {
    $('#button1').empty();
    var eventContent = $('#clickEvent4').text();
    console.log(eventContent);
    var node1 = "<span id='eventIn4'>";
    $('#button1').text(eventContent);
    $('#button1').prepend(node1);

  });
  $('#popupDatepicker').datepick();
  $('#clickEvent5').bind('click', function(event) {
    $('#button1').empty();
    var eventContent = $('#clickEvent5').text();
    console.log(eventContent);
    var node1 = "<span id='eventIn5'>";
    $('#button1').text(eventContent);
    $('#button1').prepend(node1);

  });
});
                $.fn.autogrow = function(options)
    {
        return this.filter('textarea').each(function()
        {
            var self         = this;
            var $self        = $(self);
            var minHeight    = $self.height();
            var noFlickerPad = $self.hasClass('autogrow-short') ? 0 : parseInt($self.css('lineHeight')) || 0;

            var shadow = $('<div></div>').css({
                position:    'absolute',
                top:         -10000,
                left:        -10000,
                width:       $self.width(),
                fontSize:    $self.css('fontSize'),
                fontFamily:  $self.css('fontFamily'),
                fontWeight:  $self.css('fontWeight'),
                lineHeight:  $self.css('lineHeight'),
                resize:      'none',
          'word-wrap': 'break-word'
            }).appendTo(document.body);

            var update = function(event)
            {
                var times = function(string, number)
                {
                    for (var i=0, r=''; i<number; i++) r += string;
                    return r;
                };

                var val = self.value.replace(/</g, '&lt;')
                                    .replace(/>/g, '&gt;')
                                    .replace(/&/g, '&amp;')
                                    .replace(/\n$/, '<br/>&nbsp;')
                                    .replace(/\n/g, '<br/>')
                                    .replace(/ {2,}/g, function(space){ return times('&nbsp;', space.length - 1) + ' ' });

        // Did enter get pressed?  Resize in this keydown event so that the flicker doesn't occur.
        if (event && event.data && event.data.event === 'keydown' && event.keyCode === 13) {
          val += '<br />';
        }

                shadow.css('width', $self.width());
                shadow.html(val + (noFlickerPad === 0 ? '...' : '')); // Append '...' to resize pre-emptively.
                $self.height(Math.max(shadow.height() + noFlickerPad, minHeight));
            }

            $self.change(update).keyup(update).keydown({event:'keydown'},update);
            $(window).resize(update);
            update();
        });
    };
            $(document).ready(function() {
                $(function() {
                 $('#nevt-desc').autogrow();
                 $('#nevt-desc').css('overflow', 'hidden').autogrow()
              });        
                
                              
                              var renderEventAct0=[];
                              var renderEventAct1=[];
                              
                              $("#edit-picture").hide();    
                              
                              $(document).delegate("#profile-picture","mouseover",function(){
                                                   $("#edit-picture").show();
                                                   });  
                              $(document).delegate("#edit-picture","mouseover",function(){
                                                   $("#edit-picture").show();
                                                   }); 
                              $(document).delegate("#edit-picture","mouseout",function(){
                                                   $("#edit-picture").hide();
                                                   });         
                              $(document).delegate("#profile-picture","mouseout",function(){
                                                   $("#edit-picture").hide();
                                                   }); 
                              
                              
                              
                              
                              
                              
                              $( ".class-name" ).each(function( index ) {
                                                      if($(this).text().length>21){
                                                      //alert($(this).attr("id"));
                                                      $(this).text($(this).text().substr(0,18)+"...");
                                                      }
                                                      });
                              $( ".club-name" ).each(function( index ) {
                                                     if($(this).text().length>21){
                                                     //alert($(this).attr("id"));
                                                     $(this).text($(this).text().substr(0,18)+"...");
                                                     }
                                                     });
                              
                              
                              
                              
                              
                              
                              
                              $(document).delegate(".x-icon","mouseover",function(){
                                                   $(this).closest(".class-buttons").find(".xdescription").show();
                                                   });  
                              $(document).delegate(".x-icon","mouseout",function(){
                                                   $(this).closest(".class-buttons").find(".xdescription").hide();
                                                   });    
                              
                              
                              $(document).delegate(".edit-classes","mousedown",function(){
                                                   $(".edit-classes").hide();
                                                   $("#done-edit-classes").show();
                                                   $(".class-buttons").show();
                                                   });
                              
                              $(document).delegate(".announce","mouseover",function(){
                                                   $(this).closest(".announcecolumn").find(".anndescription").show();
                                                   });  
                              $(document).delegate(".announce","mouseout",function(){
                                                   $(this).closest(".announcecolumn").find(".anndescription").hide();
                                                   });  
                              
                              $(document).delegate(".addevent","mouseover",function(){
                                                   $(this).closest(".announcecolumn").find(".adedescription").show();
                                                   });  
                              $(document).delegate(".addevent","mouseout",function(){
                                                   $(this).closest(".announcecolumn").find(".adedescription").hide();
                                                   });    
                              
                              
                              $(document).delegate(".edit-classes","mousedown",function(){
                                                   $(".edit-classes").hide();
                                                   $("#done-edit-classes").show();
                                                   $(".class-buttons").show();
                                                   });  
                              
                              $(document).delegate("#done-edit-classes","mousedown",function(){
                                                   $(this).hide();
                                                   $(".edit-classes").show();
                                                   $(".class-buttons").hide();
                                                   });    
                              
                              
                              
                              $(document).delegate(".x-icon","click",function(){
                                                   var pid= "kw="+$(this).closest(".class-one").attr("id");
                                                   $("#blackcanvas").show();
                                                   $(".dropconfirm").attr("id",pid);
                                                   
                                                   });  
                              
                              
                              $(document).delegate("#blackcanvas","click",function(e){
                                                   
                                                   if(($(e.target).is(".dropconfirm > *"))||($(e.target).is(".dropconfirm"))){return false;
                                                   
                                                   }
                                                   
                                                   $(this).hide();
                                                   
                                                   });
                              
                              
                              $(document).delegate(".bc3cancel","click",function(e){
                                                  
                                                   $(".blackcanvasNew").fadeOut();
                                                   if(animationflag==1){
                                                   $( "#newbc3content" ).animate({marginRight:"-=700px"});
                                                   animationflag=0;
                                                   }
                                                   
                                                   });
                              
                              
                              
                              
                              $(document).delegate(".dbuttons","click",function(){
                                                   var v= $(this).val();
                                                   $("#blackcanvas").hide();
                                                   if(v==1){
                                                   var tid= $(".dropconfirm").attr("id").split("=");
                                                   $("#"+tid[1]).hide();
                                                   }
                                                   $("#blackcanvas").hide();
                                                   
                                                   });
                              
                              
                              $(document).delegate(".dexit","mouseover",function(){
                                                   
                                                   $(this).css("opacity","1");
                                                   });
                              
                              $(document).delegate(".dexit","mouseout",function(){
                                                   
                                                   $(this).css("opacity","1");
                                                   });
                              
                              
                              $(document).delegate(".dexit","click",function(){
                                                   
                                                   $("#blackcanvas").hide();
                                                   $("#blackcanvas2").fadeOut();
 
                                                   
                                                   $(".blackcanvasNew").fadeOut();
                                                   if(animationflag==1){
                                                   $( "#newbc3content" ).animate({marginRight:"-=700px"});
                                                   animationflag=0;
                                                   }
                                                   
                                                   });
                              
                              
                              
                              $(document).delegate(".dexit-p","mouseover",function(){
                                                   
                                                   $(this).css("opacity","1");
                                                   });
                              
                              $(document).delegate(".dexit-p","mouseout",function(){
                                                   
                                                   $(this).css("opacity","1");
                                                   });
                              
                              
                              $(document).delegate(".dexit-p","click",function(){
                                                   
                                                   $("#blackcanvas").hide();
                                                   $("#blackcanvas2").fadeOut();

                                                   
                                                   $(".blackcanvasNew").fadeOut();
                                                   if(animationflag==1){
                                                   $( "#newbc3content" ).animate({marginRight:"-=700px"});
                                                   animationflag=0;
                                                   }
                                                   
                                                   });
                              
                              
                              $(document).delegate(".edit-clubs","mousedown",function(){
                                                   $(".edit-clubs").hide();
                                                   $("#done-edit-clubs").show();
                                                   $(".club-buttons").show();
                                                   });    
                              
                              $(document).delegate("#done-edit-clubs","mousedown",function(){
                                                   $(this).hide();
                                                   $(".edit-clubs").show();
                                                   $(".club-buttons").hide();
                                                   });   
                              
                              var ut=$("#university-title").text();
                              var st=$("#school-title").text();
                              var mat=$("#study-title").text();
                              var mit=$("#minor-title").text();
                              var eml=$("#user-email").text();
                              var btx=$("#bio-contents").text();
                              var loc=$("#user-location").text();
                              $(document).delegate(".edit-profile","click",function(){
                                                   $(this).addClass("pediting");
                                                   $(this).text("Done Editing");
                                                   
                                                   $("#user-profile-info").hide();
                                                   $("#editcolumn-u").val(ut);
                                                   
                                                   $("#editcolumn-a").val(mat);
                                                   $("#editcolumn-i").val(mit);
                                                   $(".editprofile").show();
                                                   
                                                   $(".peditable").hide();
                                                   
                                                   $(".emailtext").val(eml);
                                                   $(".loctext").val(loc);
                                                   $(".biotext").val(btx);
                                                   $(".editingbio").show();
                                                   
                                                   });
                              $(document).delegate(".peditable","click",function(){
                                                  $(this).hide();
                                                   $('.biotext').contentEditable = true;
                                                 
                                                  $(".biotext").show();
                                                  $('.biotext').contentEditable = true;

                              });
                              
                              $(document).delegate(".pediting","click",function(){
                                                   
                                                   $(this).removeClass("pediting");
                                                   $(this).text("Edit Profile");
                                                   
                                                   $(".editprofile").hide();
                                                   $("#university-title").text(ut);
                                                   $("#school-title").text(st);
                                                   $("#study-title").text(mat);
                                                   $("#minor-title").text(mit);
                                                   $("#user-profile-info").show();
                                                   
                                                   $(".editingbio").hide();
                                                   $("#user-email").text(eml);
                                                   $("#bio-contents").text(btx);
                                                   $(".peditable").show();
                                                   $(".peditable2").show();
                                                   
                                                   /*Ajax goes here*/
                                                   /*ut= university title; 
                                                    st= school title
                                                    mat= major title
                                                    mit= minor title
                                                    eml= email address
                                                    btx= bio text
                                                    */
                                                   });
                              
                              $(document).delegate(".editcolumn","keyup",function(){
                                                   if($(this).attr("id")=="editcolumn-u"){
                                                   ut=$(this).val();
                                                   }
                                                   
                                                   if($(this).attr("id")=="editcolumn-a"){
                                                   mat=$(this).val();
                                                   }
                                                   if($(this).attr("id")=="editcolumn-i"){
                                                   mit=$(this).val();
                                                   }
                                                   });
                              
                              $(document).delegate(".editingbio","keyup",function(){
                                                   if($(this).hasClass("emailtext")){
                                                   eml=$(this).val();
                                                   }
                                                   if($(this).hasClass("loctext")){
                                                   eml=$(this).val();
                                                   }
                                                   if($(this).hasClass("biotext")){
                                                   btx=$(this).val();
                                                   }
                                                   
                                                   });
                              
                              
                              
                              $(document).delegate(".annbuttons","click",function(){
                                                   
                                                   $("#blackcanvas2").fadeOut();
                                                   
                                                   if($(this).hasClass("ann-submit")){
                                                   
                                                   var tid=$(this).attr("id").split("=");
                                                   var cid=tid[1];
                                                   /*cid is the course/club id*/
                                                   
                                                   /*Ajax goes here*/
                                                   
                                                   }
                                                   
                                                   });
                              
                              //need slightly revise!!
                              $(document).delegate(".acabuttons","click",function(){
                                                   
                                                  
                                                   
                                                   if($(this).hasClass("aca-submit")){
                                                   
                                                    /*cid is the course/club id*/
                                                   var tid=$(this).closest(".blackcanvasNew").attr("id").split("=");
                                                   var cid=tid[1];
                                                   
                                                   
                                                   var t="";
                                                   var t= $("#nevt-title").val();
                                                   var desc=$("#nevt-desc").val();
                                                   
                                                   var st="";
                                                   var tdate="";
                                                   var tdate=$(".stdate").text();
                                                   
                                                   
                                                   var st=tdate+" "+$('#timepicker1').data("timepicker").getTime();
                                                   var ed=tdate+" "+$('#timepicker2').data("timepicker").getTime();
                                                   
                                                   var repeatstt= $(".repeatstate").text();
                                                   
                                                   
                                                   
                                                   
                                                   
                                                   
                                                   if((t!="")&&(tdate!=""))
                                                   {
                                                   alert(t+","+desc+","+st+","+ed+","+repeatstt+". added, please remove me and add ajax here");
                                                   /*ajax goes here*/
                                                   /*
                                                    $.ajax({
                                                    url: "http://127.0.0.1/PhpProject/calendar_0114/fullcalendar/user/create_events.php",
                                                    data: "&id=" + gt+"&title=" + t+ "&start=" + dta+ "&end=" + dtb + "&description=" + desc,
                                                    type: "POST",
                                                    error: function(json){ alert('Error'); },
                                                    success: function(json) { alert('Added Successfully'); }
                                                    });
                                                    */
                                                   
                                                   
                                                   
                                                   
                                                   
                                                   //after ajax
                                                   //appearance part
                                                   
                                                   //alter the event state from active1 to active0
                                                   cleanBlinkActive1();
                                                   cleanActive0();
                                           
                                                   var tpid=$(".stdate").attr("id").split("=");
                                                   var nid= tpid[1];
                                                   
                                                   $("#"+nid).removeClass("active1");
                                                   
                                                   renderEventAct0.push(nid+"::"+$m);
                                                   
                                                   //retreive active0
                                                   $.each( renderEventAct0, function( index, value ) {
                                                          var mth=value.split("::");
                                                          var ind=mth[1];
                                                          var dte=mth[0];
                                                          if(parseInt(ind)==parseInt($m)){
                                                          $("#"+dte).addClass("active0");
                                                          }
                                                          });
                                                   
                                                   
                                                   $.each( renderEventAct1, function( index, value ) {
                                                          var mth=value.split("::");
                                                          var ind=mth[1];
                                                          var dte=mth[0];                                                          
                                                          if(dte==nid){
                                                          renderEventAct1.splice(index,value);
                                                          }
                                                          });
                                                   
                                                   
                                                   
                                                   //after added, remove everything
                                                   
                                                   $(".sb").remove();
                                                   $(".uploadevent").remove();
                                                   //remove complete
                                                   //pop up add more button
                                                   $(".successinfo").fadeIn();
                                                   $("#newstardate-input").animate({
                                                                    marginLeft: '+=70px'
                                                                                 }, 500);
                                                   moveflag=0;
                                                   
                                                   }
                                                   
                                                   
                                                   
                                                   }else{
                                                   $( "#newbc3content" ).animate({marginRight:"-=700px"});

                                                   $(".blackcanvasNew").hide();
                                                   animationflag=0;
                                                    
                                                   }
                                                   
                                                   });
                              
                              
                              
                              $(document).delegate(".addmore","click",function(){
                                                   $(".successinfo").hide();
                                                   
                                                   //add back removed elements
                                                   
                                                   
                                                   $(".uploadform").append("<div class='uploadevent'><input type='text' id='nevt-title' placeholder='Title' class='nevt-input'><input type='text' id='nevt-location' placeholder='Location' class='nevt-input'><textarea wrap id='nevt-desc' onkeypress='taHeight()' placeholder='Details' class='nevt-input'></textarea><hr><div class='pdateinfo'><span id = 'newstardate-input'>Pick a Date &#187; <span class='stdate'></span></span><div class='frtext'>from:</div><div class='totext'>to:</div></div><div class='hourpick1'><div class='input-append bootstrap-timepicker'><input id='timepicker1' type='text' class='input-small'><span class='add-on'><i class='icon-time'></i></span></div></div><div class='hourpick2'><div class='input-append bootstrap-timepicker'><input id='timepicker2' type='text' class='input-small'><span class='add-on'><i class='icon-time'></i></span></div></div></div>");
                                                   
                                                   $(".uploadform").append("<div class='sb'><button class='acabuttons aca-submit'>Add Event</button></div>");
                                                   
                                                   $(".uploadevent").append("<div class='repeatc'><div class='repeathead'>Repeat:</div> <span class='repeatstate'>None</span><div class='repeatoption'><span class='repeatoptiont'>None</span><span class='repeatoptiont'>Daily</span><span class='repeatoptiont'>Weekly</span><span class='repeatoptiont'>Monthly</span></div></div>");
                                                   
                                                   $('#timepicker1').timepicker();
                                                   $('#timepicker2').timepicker();
                                                   
                                                   //initiate the global vars
                                                   moveflag=0;
                                                   blinkflag=0;
                                                   
                                                   });
                              
                              
                              $(document).delegate(".announce","mousedown",function(){
                                                   var tid="";
                                                   if($(this).closest(".announcecolumn").hasClass("toolsforclass"))
                                                   {
                                                   tid="ed="+$(this).closest(".class-one").attr("id");
                                                   }
                                                   
                                                   if($(this).closest(".announcecolumn").hasClass("toolsforclub"))
                                                   {
                                                   tid="ed="+$(this).closest(".club-one").attr("id");
                                                   }
                                                   
                                                   
                                                   $(".annbuttons").attr("id",tid)
                                                   $("#blackcanvas2").fadeIn();
                                                   
                                                   });
                              
                              var animationflag=0;
                              $(document).delegate(".addevent","mousedown",function(){
                                                   var tid="";
                                                   if($(this).closest(".announcecolumn").hasClass("toolsforclass"))
                                                   {
                                                   tid="ed="+$(this).closest(".class-one").attr("id");
                                                   }
                                                   
                                                   if($(this).closest(".announcecolumn").hasClass("toolsforclub"))
                                                   {
                                                   tid="ed="+$(this).closest(".club-one").attr("id");
                                                   }
                                                   
                                                   
                                                   $(".blackcanvasNew").attr("id",tid);
                                                   $(".blackcanvasNew").fadeIn();
                                                   animationflag=1;
                                                   
                                                   //$("#newbc3content").css("margin-right","0px");
                                                   $( "#newbc3content" ).animate({marginRight:"+=700px"});
                                                   });
                              
                              
                             
                              
                              
                              function retyear(t){
                              var t0=t.split(" ");
                              var t1=t0[0].split("/");
                              return t1[0];
                              }
                              function retmonth(t){
                              var t0=t.split(" ");
                              var t1=t0[0].split("/");
                              return t1[1];
                              }
                              function retday(t){
                              var t0=t.split(" ");
                              var t1=t0[0].split("/");
                              return t1[2];
                              }  
                              function rethour(t){
                              var t0=t.split(" ");
                              var t1=t0[1].split(":");
                              return t1[0];
                              }
                              function retminute(t){
                              var t0=t.split(" ");
                              var t1=t0[1].split(":");
                              return t1[1];
                              }
                              
                              
                              
                              
                              /*JQ for mini calendar*/
                              function daysInMonth(month, year) {
                              return new Date(year, month+1, 0).getDate();
                              }
                              
                              function startAt(month, year) {
                              return new Date(year, month, 1).getDay();
                              }
                              
                              var date= new Date();
                              var months=new Array();
                              months[0]="January";
                              months[1]="February";
                              months[2]="March";
                              months[3]="April";
                              months[4]="May";
                              months[5]="June";
                              months[6]="July";
                              months[7]="August";
                              months[8]="September";
                              months[9]="October";
                              months[10]="November";
                              months[11]="December";
                              var $m= date.getMonth();
                              var $M = months[$m]; 
                              var $y = date.getFullYear(); 
                              $(".minical-h1").text($M+" "+$y);
                              
                              var $ds=daysInMonth($m,$y);
                              //alert(daysInMonth(m,y));
                              
                              var weekday=new Array(7);
                              weekday[0]="su";
                              weekday[1]="mo";
                              weekday[2]="tu";
                              weekday[3]="we";
                              weekday[4]="th";
                              weekday[5]="fr";
                              weekday[6]="sa";
                              var $w = weekday[startAt($m,$y)]; 
                              //alert(w);
                              
                              $( ".calcell" ).each(function( index ) {
                                                   var tid=$(this).attr("id");
                                                   var tidsp= tid.split("_");
                                                   var idx= tidsp[2];
                                                   var td= tidsp[1];
                                                   if((td==$w)&&(idx<=6))
                                                   {
                                                   
                                                   for ( var i = idx; i < (parseInt(idx)+parseInt($ds)); i++ ) {
                                                   
                                                   $(".cl_"+i).removeClass("disable");
                                                   $(".cl_"+i).text(parseInt(i)-parseInt(idx)+parseInt(1));
                                                   }
                                                   
                                                   }
                                                   });
                              //mutated
                              $(document).delegate(".m-next","click",function(){
                                                   /*archive event*/
                                                   $( ".calcell" ).each(function( index ) {
                                                                        var iid= $(this).attr("id")+"::"+$m;
                                                                        var inact0= jQuery.inArray( iid, renderEventAct0 );
                                                                        var inact1= jQuery.inArray( iid, renderEventAct1 );
                                                                        
                                                                        
                                                                        if($(this).hasClass("active0")&&(inact0=="-1")){renderEventAct0.push(iid);}
                                                                        if($(this).hasClass("active1")&&(inact1=="-1")){renderEventAct1.push(iid);}
                                                                        
                                                                        
                                                                        });
                                                   /*archive event end*/
                                                   cleanCalendar();
                                                   if($m<11){
                                                   $m=$m+1;
                                                   }else{
                                                   $m=0;
                                                   }
                                                   
                                                   var $M = months[$m]; 
                                                   var $ds=daysInMonth($m,$y);
                                                   $(".minical-h1").text($M+" "+$y);
                                                   
                                                   var $ds=daysInMonth($m,$y);
                                                   var $w = weekday[startAt($m,$y)];
                                                   $( ".calcell" ).each(function( index ) {
                                                                        var tid=$(this).attr("id");
                                                                        var tidsp= tid.split("_");
                                                                        var idx= tidsp[2];
                                                                        var td= tidsp[1];
                                                                        if((td==$w)&&(idx<=6))
                                                                        {
                                                                        
                                                                        for ( var i = idx; i < (parseInt(idx)+parseInt($ds)); i++ ) {
                                                                        
                                                                        $(".cl_"+i).removeClass("disable");
                                                                        $(".cl_"+i).text(parseInt(i)-parseInt(idx)+parseInt(1));
                                                                        }
                                                                        
                                                                        }
                                                                        });
                                                   
                                                   cleanActive0();
                                                   cleanBlinkActive1();
                                                   cleanBlinkActive2();
                                                   
                                                   /*retreive event*/
                                                   $.each( renderEventAct0, function( index, value ) {
                                                          var mth=value.split("::");
                                                          var ind=mth[1];
                                                          var dte=mth[0];
                                                          if(parseInt(ind)==parseInt($m)){
                                                          $("#"+dte).addClass("active0");
                                                          }
                                                          });
                                                   $.each( renderEventAct1, function( index, value ) {
                                                          //alert(value);
                                                          var mth=value.split("::");
                                                          var ind=mth[1];
                                                          var dte=mth[0];
                                                          if(parseInt(ind)==parseInt($m)){
                                                          $("#"+dte).addClass("active1");
                                                          
                                                          }
                                                          });
                                                   
                                                   /*retreive event end*/
                                                   
                                                   });
                              //mutated
                              $(document).delegate(".m-prev","click",function(){
                                                   /*archive event*/
                                                   $( ".calcell" ).each(function( index ) {
                                                                        var iid= $(this).attr("id")+"::"+$m;
                                                                        var inact0= jQuery.inArray( iid, renderEventAct0 );
                                                                        var inact1= jQuery.inArray( iid, renderEventAct1 );
                                                                    
                                                                        
                                                                        if($(this).hasClass("active0")&&(inact0=="-1")){renderEventAct0.push(iid);}
                                                                        if($(this).hasClass("active1")&&(inact1=="-1")){renderEventAct1.push(iid);}
                                                                        
                                                                        
                                                                        });
                                                   /*archive event end*/
                                                   
                                                   cleanCalendar();
                                                   if($m>0){
                                                   $m=$m-1;
                                                   }else{
                                                   $m=11;
                                                   }
                                                   
                                                   var $M = months[$m]; 
                                                   var $ds=daysInMonth($m,$y);
                                                   $(".minical-h1").text($M+" "+$y);
                                                   
                                                   var $ds=daysInMonth($m,$y);
                                                   var $w = weekday[startAt($m,$y)];
                                                   $( ".calcell" ).each(function( index ) {
                                                                        var tid=$(this).attr("id");
                                                                        var tidsp= tid.split("_");
                                                                        var idx= tidsp[2];
                                                                        var td= tidsp[1];
                                                                        if((td==$w)&&(idx<=6))
                                                                        {
                                                                        
                                                                        for ( var i = idx; i < (parseInt(idx)+parseInt($ds)); i++ ) {
                                                                        
                                                                        $(".cl_"+i).removeClass("disable");
                                                                        $(".cl_"+i).text(parseInt(i)-parseInt(idx)+parseInt(1));
                                                                        }
                                                                        
                                                                        }
                                                                        });
                                                   
                                                   
                                                   cleanActive0();
                                                   cleanBlinkActive1();
                                                
                                                   
                                                   /*retreive event*/
                                                   $.each( renderEventAct0, function( index, value ) {
                                                          var mth=value.split("::");
                                                          var ind=mth[1];
                                                          var dte=mth[0];
                                                          if(parseInt(ind)==parseInt($m)){
                                                          $("#"+dte).addClass("active0");
                                                          }
                                                          });
                                                   $.each( renderEventAct1, function( index, value ) {
                                                          //alert(value);
                                                          var mth=value.split("::");
                                                          var ind=mth[1];
                                                          var dte=mth[0];
                                                          if(parseInt(ind)==parseInt($m)){
                                                          $("#"+dte).addClass("active1");
                                                          
                                                          }
                                                          });
                                                   
                                                   /*retreive event end*/
                                                   
                                                   
                                                   });
                              
                              function cleanCalendar(){
                              $( ".calcell" ).each(function( index ) {
                                                   $(this).text("");
                                                   $(this).addClass("disable");
                                                   });
                              }
                              
                              function cleanBlinkActive1(){
                              $( ".calcell" ).each(function( index ) {
                                                   $(this).removeClass("active1");
                                                   $(this).removeClass("blink1");
                                                   
                                                   });
                              }
                              
                              function cleanBlinkActive2(){
                              $( ".calcell" ).each(function( index ) {
                                                   $(this).removeClass("active2");
                                                   $(this).removeClass("blink2");
                                                   
                                                   });
                              }
                              //mutated
                              function cleanActive0(){
                              $( ".calcell" ).each(function( index ) {
                                                   $(this).removeClass("active0");
                                                   
                                                   });
                              }
                              
                              function cleanBlink1(){
                              $( ".calcell" ).each(function( index ) {
                                                   
                                                   $(this).removeClass("blink1");
                                                   
                                                   });
                              }
                              
                              function cleanBlink2(){
                              $( ".calcell" ).each(function( index ) {
                                                   
                                                   $(this).removeClass("blink2");
                                                   
                                                   });
                              }
                              
                              var blinkflag=0;
                              var moveflag=0;
                              $(document).delegate(".calcell","click",function(){
                                                   if(!$(this).hasClass("disable")){
                                                   if(blinkflag==0){
                                                   
                                                   cleanBlinkActive1();
                                                   $(this).addClass("active1");
                                                   $(this).addClass("blink1");
                                                   
                                                   var ddd=$(this).text();
                                                   $M=months[$m];
                                                   if(moveflag==0){
                                                   $("#newstardate-input").animate({
                                                            marginLeft: '-=70px'
                                                                                 }, 500);
                                                   moveflag=1;
                                                   }
                                                   
                                                   var nid= "wk="+$(this).attr("id")
                                                   $(".stdate").text($M+" "+ddd);
                                                   $(".stdate").attr("id",nid);
                                                   /*
                                                   $(".stdate").fadeIn( 'slow', function(){ 
                                                                       
                                                                       });
                                                   
                                                   */
                                                   
                                                   
                                                   }
                                                   /*
                                                   if(blinkflag==1){
                                                   cleanBlinkActive2();
                                                   $(this).addClass("active2");
                                                   $(this).addClass("blink2");
                                                   if(hp2exists==0){
                                                   createHourPicker2();
                                                   
                                                   }
                                                   }
                                                   */
                                                   }
                                                   
                                                   });
                              
                              

                              
                              $(document).delegate(".hp1cells","mouseover",function(){
                                                   $(this).css({"background-color":"#44D37C","color":"white"});
                                                   });
                              $(document).delegate(".hp1cells","mouseout",function(){
                                                   $(this).css({"background-color":"transparent","color":"black"});
                                                   });
                              
                              $(document).delegate(".hp1cells","click",function(){
                                                   $(".hpdisplay1 span").text($(this).text());
                                                   $(".hpdisplay1").attr("id",$(this).attr("id"));
                                                   
                                                   });
                              
                              //mutated
                              $(document).delegate(".hp1ok","click",function(){
                                                   if($(".hpdisplay1").attr("id")!="notime1"){
                                                   
                                                   $(".hp1content").remove();
                                                   
                                                   cleanBlink1();
                                                   blinkflag=2;
                                                   
                                                   
                                                   //alert($m);
                                                   var tid=$y+"-"+$m+"-"+$(".active1").text()+"-"+$(".hpdisplay1").attr("id");
                                                   $(".hpdisplay1").attr("id",tid);
                                                   
                                                   
                                                   createHourPicker2();
                                                   var nid= "fnl="+$(".active1").attr("id");
                                                   $(".finalstep").css("margin-left","170px");
                                                   $(".finalstep").attr("id",nid);
                                                   }
                                                   });
                              
                              
                              
                              $(document).delegate(".hp2cells","mouseover",function(){
                                                   $(this).css({"background-color":"#44D37C","color":"white"});
                                                   });
                              $(document).delegate(".hp2cells","mouseout",function(){
                                                   $(this).css({"background-color":"transparent","color":"black"});
                                                   });
                              
                              $(document).delegate(".hp2cells","click",function(){
                                                   $(".hpdisplay2 span").text($(this).text());
                                                   $(".hpdisplay2").attr("id",$(this).attr("id"));
                                                   });
                              
                              //mutated
                              $(document).delegate(".hp2ok","click",function(){
                                                   if($(".hpdisplay2").attr("id")!="notime2"){
                                                   $(".hp2content").remove();
                                                   blinkflag=2;
                                                   }
                                                   //alert($m);
                                                   var tid=$y+"-"+$m+"-"+$(".active2").text()+"-"+$(".hpdisplay2").attr("id");
                                                   $(".hpdisplay2").attr("id",tid);
                                                   });
                              
                              //mutated
                    $(".connect-text-linqd").hide();
                    $(".connect-text-unlinq").hide();          
                    $(document).delegate(".connect-button","mouseup",function(){
                        $(".cb1").removeClass("connect-button");
                        $(".cb1").addClass( "connect-button-linqd" );
                        $(".connect-text").hide();
                        $(".connect-icon").hide();
                        $(".connect-text-linqd").show();
                                         });         
                    $(document).delegate(".connect-button-linqd","mouseenter",function(){
                        $(".cb1").removeClass("connect-button-linqd");
                        $(".cb1").addClass( "connect-button-unlinq" );
                        $(".connect-text-linqd").hide();
                        $(".connect-text-unlinq").show();
                                         });   

                    $(document).delegate(".connect-button-unlinq","mouseleave",function(){
                        $(".cb1").removeClass("connect-button-unlinq");
                        $(".cb1").addClass( "connect-button-linqd" );
                        $(".connect-text-unlinq").hide();
                        $(".connect-text-linqd").show();
                                         });   
                    $(document).delegate(".connect-button-unlinq","mouseup",function(){
                        $(".cb1").removeClass("connect-button-unlinq");
                        $(".cb1").addClass( "connect-button" );
                        $(".connect-text-unlinq").hide();
                        $(".connect-icon").show();
                        $(".connect-text").show();
                                         });
                              
                              
                              
                    
                    $(document).delegate(".repeatoptiont","mouseover",function(){
                                         $(this).css({"color":"#30E680","border-bottom":"1px solid #30E680"});
                                         });
                    $(document).delegate(".repeatoptiont","mouseout",function(){
                                                   $(this).css({"color":"rgba(0,0,0,0.7)","border-bottom":"1px solid #ccc"});
                                                   });
                              $(document).delegate(".repeatstate","mouseover",function(){
                                                   $(this).css({"opacity":"1"});
                                                   $(".repeatoption").fadeIn();
                                                   });

                              $(document).delegate(".repeatstate","mouseout",function(){
                                                   $(this).css({"opacity":"1"});
                                                   $(".repeatoption").fadeOut();
                                                   });
                              $(document).delegate(".repeatoption","mouseout",function(){
                                                   $(".repeatoption").fadeOut();
                                                   });

                              $(document).delegate(".repeatstate","mouseout",function(){
                                                   $(this).css({"opacity":"0.7"});
                                                   
                                                   });

                              $(document).delegate(".repeatoption","mouseover",function(){
                                                   $(this).stop(true,true).show();
                                                   });
                    
                              
                     $(document).delegate(".repeatstate","click",function(){
                                          $(".repeatoption").fadeIn();         
                                          });
                              
                              
                              
                    $(document).delegate(".repeatoptiont","click",function(){
                                        
                                         
                                         $(".repeatstate").text($(this).text());
                                         
                                         $(".repeatoption").hide();
                                        });
                              
                            
                              
                    $('#timepicker1').timepicker();
                    $('#timepicker2').timepicker();

                              
                                          
        });


$(document).ready(function() {
  
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    
    var calendar = $('#calendar').fullCalendar({
      height:700,
      aspectRatio:1.3,
      eventColor: 'rgba(126,224,141,0.9)',
      eventBoarderColor:'rgba(178,218,103,0.7)',
      eventTextColor: '#fff',
      weekMode:'variable',
      
      header: {
      left:   'prevYear,title,nextYear',
      center: 'month,agendaWeek,agendaDay',
      right:  'prev,today,next'
      },
      buttonText: {
      prevYear:'&lt;',
      nextYear: '&gt;'
      },
      selectable: true,
      selectHelper: true,
      viewRender: function(view,element){
          console.log(view);
          console.log(element);
          if(view.name === 'month') {
            $('#calendar').fullCalendar('option', 'contentHeight', 700);
          } else {
            $('#calendar').fullCalendar('option', 'contentHeight', 600);
          }
      },
      select: function(start, end, allDay) {
        alert("zkl1");
        $('#addEvent').trigger("click");
        var title = prompt('Event Title:');
        if (title) {
          calendar.fullCalendar('renderEvent',
            {
              title: title,
              start: start,
              end: end,
              allDay: allDay
            },
            true // make the event "stick"
          );
        }
        calendar.fullCalendar('unselect');
      },
      editable: true,
      events: [
        {
          title: 'All Day Event',
          start: new Date(y, m, 1),
          editable: true,
          startEditable: true,
          durationEditable: true

        },
        {
          title: 'Long Event',
          start: new Date(y, m, d-5),
          end: new Date(y, m, d-2)
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: new Date(y, m, d-3, 16, 0),
          allDay: false
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: new Date(y, m, d+4, 16, 0),
          allDay: false
        },
        {
          title: 'Meeting',
          start: new Date(y, m, d, 10, 30),
          allDay: false
        },
        {
          title: 'Lunch',
          start: new Date(y, m, d, 12, 0),
          end: new Date(y, m, d, 14, 0),
          allDay: false
        },
        {
          title: 'Birthday Party',
          start: new Date(y, m, d+1, 19, 0),
          end: new Date(y, m, d+1, 22, 30),
          allDay: false
        },
        {
          title: 'Click for Google',
          start: new Date(y, m, 28),
          end: new Date(y, m, 29),
          url: 'http://google.com/'
        }
      ],
      //点击事件，触发其他函数
      eventClick: function(calEvent, jsEvent, view) {
          alert('zkl');
          calEvent.title = "CLICKED!";
            $('#calendar').fullCalendar('updateEvent', calEvent);
          

         },

    });
    
  });
