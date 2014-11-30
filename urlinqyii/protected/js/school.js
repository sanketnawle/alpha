$(document).ready(function () {

    $('.tabFeed').on('click', function () {
        $('.departments-tab-content').hide();
        $('.members-tab-content').hide();
        $('.span_1_of_3').show();
        $('.span_2_of_3').show();
        $('.span_3_of_3').show();
        $('.clubs-tab-content').hide();
    });
    $('.tabDepartments').on('click', function () {
        $('.span_1_of_3').hide();
        $('.span_2_of_3').hide();
        $('.span_3_of_3').hide();
        $('.members-tab-content').hide();
        $('.departments-tab-content').show();
        $('.clubs-tab-content').hide();

    });
    $('.tabclubs').on('click', function () {
        $('.span_1_of_3').hide();
        $('.span_2_of_3').hide();
        $('.span_3_of_3').hide();
        $('.members-tab-content').hide();
        $('.departments-tab-content').hide();
        $('.clubs-tab-content').show();
    });
    $('.members-tab').on('click', function () {
        $('.span_1_of_3').hide();
        $('.span_2_of_3').hide();
        $('.span_3_of_3').hide();
        $('.departments-tab-content').hide();
        $('.members-tab-content').show();
        $('.clubs-tab-content').hide();
    });

});

