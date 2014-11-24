$(document).ready(function () {
    $(document).delegate(".block-head-right", "click", function () {
        $(this).closest(".about-tab-about").find(".about_edit").show();
        $(this).closest(".about-tab-about").find(".tab-block-content").hide();
    });

    $(document).delegate(".about_edit_cancel", "click", function () {
        $(this).closest(".about-tab-about").find(".about_edit").hide();
        $(this).closest(".about-tab-about").find(".tab-block-content").show();
    });

    $(document).delegate(".about_edit_done", "click", function () {
        $(this).closest(".about-tab-about").find(".about_edit").hide();
        $(this).closest(".about-tab-about").find(".tab-block-content").show();

        /*last step to go*/
        $(this).closest(".about-tab-about").find(".about_edit").val("");
    });

    $(document).delegate(".group-tab", "click", function () {

        $(".about-tab-about").find(".about_edit").hide();
        $(".about-tab-about").find(".tab-block-content").show();
    });

});