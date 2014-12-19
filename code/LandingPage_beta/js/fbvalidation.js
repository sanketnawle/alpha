

$(document).ready(function(){
	//global vars
	var form = $("#signupform");
	var university= $("#university-signup");
        var universityerror=$("#universityerror");
       
	
	//On blur
	university.blur(validateUniversity);
	//On key press
        //name.keyup(validateName);
	//email.keyup(validateEmail);
        //university.keyup(validateUniversity);
	//password.keyup(validatePassword);
	
	
	//On Submitting
	form.submit(function(){
		if(validateUniversity())
			return true;
		else
			return false;
        });
        //validation functions
	
        function validateUniversity()
        {
            if(university.val().length < 1){
			
			universityerror.text("Required");
			$("#university-signup").css({"border-color":"#cb2027", "box-shadow": "0 0 6px rgba(255, 0, 0, 0.35)"});

			return false;
		}
		//if it's valid
		else{
			universityerror.innerHTML="";
			$("#university-signup").css({"border-color":"#cccccc", "box-shadow": "none"});

                        universityerror.text("");
			return true;
		}
            
        }

});