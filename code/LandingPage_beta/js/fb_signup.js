
$('form.ajax').on('submit', function(){
 var testing=false;
  var that=$(this),
      url=that.attr('action'),
      type=that.attr('method'),
      data={};
    
  that.find('[name]').each(function(index,value){

    var that=$(this),
        name=that.attr('name'),
        value=that.val();
        data[name]=value;
  });
  

  $.ajax({
  url: url,
  type: type,
  data: data,
  success: function(response){
  if(response === "true")
      {
           testing = true;
           window.location="home.php";
      }
   else
       {
           testing = false;
            $('#ack').text(response);
            console.log(response);
            setTimeout(function() {
            $("#ack").text("");
          }, 5000);
       }
  }
   });
  
 
return testing;

});