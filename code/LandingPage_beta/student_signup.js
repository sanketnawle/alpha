
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
        if(name === 'account-types')
            data[name]=$('.typecheck:checked').val();
        else
            data[name]=value;
  });
  
  var key;

  $.ajax({
  url: url,
  type: type,
  data: data,
  success: function(response){
  if(response.indexOf("success")>=0)
      {
           testing = true;
		   var str = response.replace("success","");
		   var s = str.split(' ');
		   var key = s[0];
		   var email = s[1];
		   var path = 'confirm_email.php?key='+key+'&email='+email;
           $(this).attr('action', 'signupsucess.php').off('submit').submit();
           window.location = path;
      }
   else if(response.indexOf("NYU")>=0)
       {
           key = response.substr(3,35);
           testing = true;
           var path = "school_select.php?key="+key;
           window.location=path;
       }
   else if(response === "other")
      {
           testing = true;
           window.location="test.php";
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