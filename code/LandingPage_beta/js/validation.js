

$(document).ready(function(){
	//global vars
	var form = $("#signupform");
	var name = $("#name-signup");
        var nameerror=$("#nameerror");
	var email = $("#email-signup");
	var emailerror = $("#emailerror");
	var password = $("#password-signup");
	var passworderror= $("#passworderror");
        var university= $("#university-signup");
        var universityerror=$("#universityerror");
        
	//var pass2 = $("#pass2");
	//var pass2Info = $("#pass2Info");
	//var message = $("#message");
	
	//On blur
	name.blur(validateName);
	email.blur(validateEmail);
        university.blur(validateUniversity);
	password.blur(validatePassword);
        //On key press
        //name.keyup(validateName);
	//email.keyup(validateEmail);
        //university.keyup(validateUniversity);
	//password.keyup(validatePassword);
	
	
	//On Submitting
	form.submit(function(){
		if(validateName() & validateEmail() & validatePassword() & validateUniversity())
			return true;
		else
			return false;
        });
        //validation functions
	function validateEmail(){
		//testing regular expression
		var a = email.val();
		var filter = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+\.edu$/;
		//if it's valid email
                if(a.length<1)
                    {
                        emailerror.text("Required");
			$("#email-signup").css({"border-color":"#cb2027", "box-shadow": "0 0 6px rgba(255, 0, 0, 0.35)"});

			return false;
                    }
		else if(filter.test(a)){
			//email.removeClass("error");
			//emailerror.text("Valid E-mail please, you will need it to log in!");
			emailerror.innerHTML="";
                        emailerror.text("");
                        $("#email-signup").css({"border-color":"#cccccc", "box-shadow": "none"});

			return true;
		}
		//if it's NOT valid
		else{
			//email.addClass("error");
			emailerror.text("No .edu");
			$("#email-signup").css({"border-color":"#cb2027", "box-shadow": "0 0 6px rgba(255, 0, 0, 0.35)"});

			return false;
		}
	}
	function validateName()
        {
		//if it's NOT valid
		if(name.val().length < 1)
                {
			
                        nameerror.text("Required");
                        $("#name-signup").css({"border-color":"#cb2027", "box-shadow": "0 0 6px rgba(255, 0, 0, 0.35)"});

                        return false;
		}
		//if it's valid
		else
                {
                	    $("#name-signup").css({"border-color":"#cccccc", "box-shadow": "none"});

                        nameerror.innerHTML="";
                        nameerror.text("");
                        return true;
		}
        }
        function validatePassword(){
		//if it's NOT valid
                if(password.val().length < 1)
                {
			
			passworderror.text("Required");
			$("#password-signup").css({"border-color":"#cb2027", "box-shadow": "0 0 6px rgba(255, 0, 0, 0.35)"});

			return false;
		}
		else if(password.val().length < 6){
			
			passworderror.text("Too Short");
			$("#password-signup").css({"border-color":"#cb2027", "box-shadow": "0 0 6px rgba(255, 0, 0, 0.35)"});

			return false;
		}
		//if it's valid
		else{
			passworderror.innerHTML="";
                        passworderror.text("");
                        $("#password-signup").css({"border-color":"#cccccc", "box-shadow": "none"});

			return true;
		}
	}
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