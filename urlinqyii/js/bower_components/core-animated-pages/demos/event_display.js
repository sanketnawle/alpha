  $(document).ready(function(){
     $.ajax({
               url: "music.html",
               type: "GET",
               success: function(response) {
                if(response){
                  $("#events_dp").html(response);
                   var it=[
                    { artist: 'Tycho', album: 'Fragments', color: '#f4db33' },
                    { artist: 'Tycho', album: 'Past Prologue', color: '#972ff8' },
                    { artist: 'Tycho', album: 'Spectre', color: '#7dd6fe' },
                    { artist: 'Tycho', album: 'Awake', color: '#dc3c84' },
                  ];
                   show_items(it);
                }
               },
               error: function(jqXHR, textStatus, errorMessage) {
                   console.log(errorMessage); // Optional
               }
        });
  });
  var show_items = function(it){
    console.log("calling");

    Polymer('music-demo', {

      page: 0,

      items:it,

      selectedAlbum: null,

      transition: function(e) {
        if (this.page === 0 && e.target.templateInstance.model.item) {
          this.selectedAlbum = e.target.templateInstance.model.item;
          this.page = 1;
        } else {
          this.page = 0;
        }
      }
    });
    }
$(document).on("click", "#rightclick", function(event){
     $.ajax({
               url: "music.html",
               type: "GET",
               success: function(response) {
                if(response){
                  $("#events_dp").replaceWith('<div id="events_dp">'+response+'</div>');
                   var it=[
                    { artist: 'Tycho2', album: 'Fragments', color: '#f4db33' },
                    { artist: 'Tycho2', album: 'Past Prologue', color: '#972ff8' },
                    { artist: 'Tycho2', album: 'Spectre', color: '#7dd6fe' },
                    { artist: 'Tycho2', album: 'Awake', color: '#dc3c84' }
                  ];
                   show_items(it);
                }
               },
               error: function(jqXHR, textStatus, errorMessage) {
                   console.log(errorMessage); // Optional
               }
        });
});
