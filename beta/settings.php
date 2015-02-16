<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Urlinq - Account Settings</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
    $( document ).ready(function() {
        $("#ch_pwd_btn").click(function(){
              var cur_pwd = $("#cur_pwd").val();
              var new_pwd = $("#new_pwd").val();
                $.ajax({
                    type: "POST",
                    url: "php/profile/settings.php",
                    cache: false,
                    data: {cur_pwd: cur_pwd,
                      new_pwd: new_pwd
                      },
                    success: function (html) {
                        $("#ch_pwd")[0].reset();
                    }
                });
            });

});
        </script>

  </head>
  <body>

    <div class="panel panel-default col-md-6 col-md-offset-3">
	  <div class="panel-body">
	    <h1>Account Settings</h1>
        <h3>Change Password</h3>
            <form role="form" name="ch_pwd">
                <div class="form-group">
                    <label for="exampleInputPassword1">Current Password</label>
                    <input type="password" class="form-control" id="cur_pwd" name="cur_pwd" placeholder="Enter current Password">
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="Enter new password">
                    <br/>
                    <input type="password" class="form-control" id="new_pwd_again" name="new_pwd_again"  placeholder="Re-enter new password">
                </div>

                <button type="button" id="ch_pwd_btn" class="btn btn-success">Change password</button>
            </form>

	  </div>
	</div>

  </body>
</html>