/*
 * # Pulser Animation- Kuan Wang
 *
 * Copyright 2014 
 *
 */

(function ($) {

$.fn.tooltip = function(options) {

    var params = $.extend({
    trigger: 'click', /*default click, valid values I accept include hover and click*/
    deTrigger: 'auto', /*auto means click outside of this, or click done button, the value can be mouseleave*/
    wedge: 'left', /*default left, valid value I accept include left, up and right; wedge down is invalid*/
    x: 0, /*x coordinate compensation of this popup*/
    y: 0, /*y coordinate compensation of this popup*/
    promptHeader: [""], /*the header of this popup prompt, as an array, maximum length= 6 */
    promptContent: [""], /*the content of this popup prompt, as an array, maximum length= 6 */
    footer: "",
    repeatable: false /*if this tooltip can be view again*/
    }, options );

    var btn_txt=["Done"];

    if(params.trigger=='click'){

        this.click(popup);
    }
    if(params.trigger=='hover'){
        this.mouseenter(popup);
    }

    var btn_associate=0;


    /*$(this).on( "click", ".popup_step", function() {
        btn_associate--;
        if (btn_associate<=0) {
            btn_associate=0;
        }
        $(".inactive").removeClass("inactive");
        $(".tip_card_content").find("h3").fadeOut();
        $(".tip_card_content").find("p").fadeOut(function(){
            $(".tip_card_content").find("h3").html(params.promptHeader[btn_associate]);
            $(".tip_card_content").find("p").html(params.promptContent[btn_associate]);

            $(".tip_card_content").find("h3").fadeIn();
            $(".tip_card_content").find("p").fadeIn();

            $(".tip_card_next").text(btn_txt[btn_associate]);
            $(".popup_step_"+btn_associate).addClass("inactive");
        });

    });*/

    $(this).on( "click", ".tip_card_next", function() {
        //alert(btn_txt.length);
        btn_associate++;

        if (btn_associate==btn_txt.length){
            hide();

            return;
        }

        $(".inactive").removeClass("inactive");
        

        $(".tip_card_content").find("h3").fadeOut();

        $(".tip_card_content").find("p").fadeOut(function(){
            $(".tip_card_content").find("h3").html(params.promptHeader[btn_associate]);
            $(".tip_card_content").find("p").html(params.promptContent[btn_associate]);

            $(".tip_card_content").find("h3").fadeIn();
            $(".tip_card_content").find("p").fadeIn();

            $(".tip_card_next").text(btn_txt[btn_associate]);
            $(".popup_step_"+btn_associate).addClass("inactive");
        });

        
    });

    /*if this has black canvas, then click on it will hide*/
    $(".black_canvas").click(hide);

    //this.find()




    function popup(){
        //alert(btn_associate);

        if($(this).find(".tip_card").length==0){

            $(this).append("<div class='tip_card hidden'> <div class='tip_card_callout'></div> <div class='tip_card_interior'><div class='tip_card_content'><h3>Loading header...</h3><p>Loading content...</p></div> <div class='tip_card_nav'><div class='tip_card_dots'>    </div></div> <div class='tip_card_next'>Done</div></div> <div class='tip_card_footer'><div class='tip_card_logo'></div><span></span></div> </div>"); 
            $(this).find(".tip_card_footer").find("span").html(params.footer);

            if(params.wedge=='right'){
                $(this).find(".tip_card_callout").addClass("pointRight");
            }else if(params.wedge=='top'){
                $(this).find(".tip_card_callout").addClass("pointTop");
            }else{
                $(this).find(".tip_card_callout").addClass("pointLeft");
            }

            var len= params.promptHeader.length>params.promptContent.length? params.promptContent.length : params.promptHeader.length;

            if (len>1) {
                for (var i = 0; i < len; i++) {
                    $(".tip_card_dots").append("<div class='popup_step popup_step_"+i+"'>&#8226;</div>");
                    
                    if (i!=len-1) {
                        btn_txt.unshift("Next");
                    }
                    
                    $(".popup_step_0").addClass("inactive");
                }
            }

            $(this).find(".tip_card_content").find("h3").html(params.promptHeader[0]);
            $(this).find(".tip_card_content").find("p").html(params.promptContent[0]);
            $(this).find(".tip_card_next").text(btn_txt[0]);

            var correct_x= $(this).find(".tip_card").position().left+params.x;
            var correct_y= $(this).find(".tip_card").position().top+params.y;

            $(this).find(".tip_card").css({"marginLeft":correct_x, "marginTop":correct_y});


            
            $(this).find(".tip_card_next").show();
            

            $(this).find(".tip_card").fadeIn();
            $(".black_canvas").fadeIn();
            
        }

    }



    function hide(){
        /*init btn_association*/
        btn_associate=0;

        $(".black_canvas").fadeOut();

        if (params.repeatable) {
            $(".tip_card").remove();
        }else{
            $(".tip_card").fadeOut();
        }
        
        
    }
};

}(jQuery));