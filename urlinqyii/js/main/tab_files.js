
$(document).ready(function(){
	$('.files_subtab').click(function(){
        var $tab = $(this);
        var panel_id = $tab.attr('data-panel_id');
        //Change active tab
        $('.files_subtab.active').removeClass('active');
        $tab.addClass('active');


        //Find the current active panel and remove its active class
        $('.files_sub_panel.active').removeClass('active');
        $('#files_sub_panel_' + panel_id).addClass('active');
    });
});