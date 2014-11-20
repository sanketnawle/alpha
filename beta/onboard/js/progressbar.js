$(document).ready(function(){

$.fx.interval = 300;
   
$(".progress").animate( {width: "100%" }, { 
    duration: 9000,    
    step: function(now, fx){ 
    //if(fx.prop == 'width') {
    //          var countup = Math.round( (now / 100) * 100) + '%';
    //$(".countup").html(countup); }    
    },            
         
    });    

  });