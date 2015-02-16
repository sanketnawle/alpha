<html>
  <head>
    <script>
      
      function onApiLoad() {
        gapi.load('auth',{'callback':onAuthApiLoad});
        gapi.load('picker');
      }

      function onAuthApiLoad() {
        window.gapi.auth.authorize({
          // 'client_id': '360539226262-fdlr751nak0qa08vt206berplgoeg23a.apps.googleusercontent.com',
          'client_id': '648831685142-djuu0p1kanvmn751rnj189avhde81ckt.apps.googleusercontent.com',
          'scope': ['https://www.googleapis.com/auth/drive']
        }, handleAuthResult);
      }

      var oauthToken;
      function handleAuthResult(authResult) {
        if(authResult && !authResult.error){
          oauthToken = authResult.access_Token;
          createPicker();
        }
      }

      function createPicker() {
        var picker = new google.picker.PickerBuilder()
          .addView(new google.picker.DocsUploadView())
          .addView(new google.picker.DocsView())
          .setOAuthToken(oauthToken)
          // .setDeveloperKey('AIzaSyBOP926y6DqlsoHqhqI1w9OiPA2gf6uS7A')
          .setDeveloperKey('AIzaSyDXcdGwlZUFArSbExSC81-g4PIlAA6vzD4')
          .setCallback(pickerCallback)
          .build();
        picker.setVisible(true);
      }

      function pickerCallback(data) {
        var url = 'nothing';
        if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
          var doc = data[google.picker.Response.DOCUMENTS][0];
          url = doc[google.picker.Document.URL];
        }
        var message = 'You picked: ' + url;
        document.getElementById('result').innerHTML = message;
      }

    </script>
  </head>

  <body>
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=onApiLoad"></script>
  </body>

</html>