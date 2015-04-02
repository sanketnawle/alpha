
$(document).on('click','.facebook_login',function(){
    console.log('Faceboook');
    FB.login(function(r){
        checkLoginState();
    });
})
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
        // Logged into your app and Facebook.
        grabPicture();
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        alert('Please log into this app.');
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        alert('Please log into Facebook.');
    }
}

function grabPicture() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me/picture?width=300', function(response) {

        save_fb_picture(response.data.url);


    });
}

function save_fb_picture(url){
    var post_url = base_url + '/site/saveFacebookProfilePicture';
    var post_data = {url:url};
    $.post(
        post_url,
        post_data,
        function(response){
            if(response['success']){
                $('div.step_6_card_r0').css('background-image','url("'+base_url+response.file_url+'")');
                $('#profile_image_upload_form').hide();
                $('div.step_6_card_r0').attr('data-file_id',response['file_id']);
            }
        }
    );
}

function fb_login(){
    FB.login(function(r){
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                FB.api('/me', function(response) {
                    var fb_email = response.email;
                    //var access_token =
                    var post_url = globals.base_url+"/facebookLogin";
                    var post_data = {fb_email:fb_email};
                    $.post(
                        post_url,
                        post_data,
                        function(response){
                            if(response['success']){
                                window.location.href = base_url + '/home';
                            }else if (response['error_id'] == 6) {
                                window.location.replace(globals.base_url + '/onboard');
                            }
                        }
                    );
                });
            }
        });
    }, {scope: 'email'});
}

function fb_signup(){
    FB.login(function(r){
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                store_facebook_info();
            }
        });
    }, {scope: 'email'});

}

function store_facebook_info(){
    FB.api('/me', function(response) {
        var fb_email = response.email;
        var first_name = response.first_name;
        var last_name = response.last_name;
        //var access_token =
        var post_url = globals.base_url+"/facebookSignup";
        var post_data = {fb_email:fb_email, first_name: first_name, last_name:last_name};
        $.post(
            post_url,
            post_data,
            function(response){
                if(response['success']){
                    window.location.href = base_url + '/onboard';
                }
            }
        )
    });
}