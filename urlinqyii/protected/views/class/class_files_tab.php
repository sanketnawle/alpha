<script>
    $(document).ready(function () {
        $.urlParam = function (sParam) {

            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) {
                    return sParameterName[1];
                }
            }

        }
        var class_id = $.urlParam('class_id');


        $(document).delegate(".searchFiles", "keyup", function (e) {
            var curstring = $(this).val().toLowerCase().trim();
            if (curstring.length >= 2) {
                $(".file").each(function () {
                    var tagstring_obj = $(this).find(".search_unit");
                    var tagstring = tagstring_obj.text().toLowerCase().trim();

                    if (tagstring.indexOf(curstring) >= 0) {
                        $(this).removeClass("hidden_result");
                    } else {
                        $(this).addClass("hidden_result");
                    }


                    /*control the text prompt of the div*/
                    $(".files-type-content").each(function (index) {
                        var l = $(this).find(".file").not('.hidden_result').length;
                        if (l == 0) {
                            $(this).prev(".blockwrapper").addClass("hidden_result");
                        } else {
                            $(this).prev(".blockwrapper").removeClass("hidden_result");
                        }
                    });
                    /*control the text prompt of the div end*/


                });

            } else {
                $(".hidden_result").removeClass("hidden_result");
            }

        }); 

        function reloadPage() {
            $.ajax({
                type: "POST",
                url: "class_files_list.php",
                data: {class_id: class_id},
                success: function (res) {
                    $(".class-file-list").html(res);
                    $(".tab3 .badge").html($("div.files-type-content div.file").length);
                    bindDeleteButton();
                },
                error: function (html) {
                    alert(html);
                    alert("b");
                }
            });

        }

        function uplaodFile(formData) {
            $.ajax({
                type: "POST",
                url: "php/class_file_upload.php",
                xhr: function () {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Check if upload property exists
                        myXhr.upload.addEventListener('progress', progressHandlingFunction, false);
                    }
                    return myXhr;
                },

                data: formData,
                contentType: false,
                processData: false,
                success: reloadPage,
                error: function (html) {
                    alert(html);
                    alert("a");
                }
            });
        }

        function handleFiles(files) {
            for(var l = 0; l < files.length; ++l) {
                console.log(files[l]);
                var formData = new FormData();
                formData.append("class_id", class_id);
                formData.append("file", files[l]);
                uplaodFile(formData);
            }
        }

        $(document).delegate(".upload_file_at_course", "change", function () {
            var $ref = $(this);
            var files =  $(this).prop("files");
            handleFiles(files);
        });


        $(document).delegate(".sortByDropdown", "change", function () {

            var filelist = [];
            if ($(this).val() == "recent-rank") {
                filelist = [];
                $(".file").each(function (index) {
                    filelist.push($(this).clone());
                });
                //alert(filelist[2].attr("id"));

                filelist.sort(function (x, y) {
                    return Date.parse(y.find(".file-cont").attr("id").replace(/-/g, '/')) - Date.parse(x.find(".file-cont").attr("id").replace(/-/g, '/'));
                });

                //alert(filelist[2].attr("id"));

                $.each(filelist, function (index) {
                    $(".file_sortbox").append(filelist[index]);
                });

                $(".hidden_result").removeClass("hidden_result");
                $(".searchFiles").val("");

                $(".blockwrapper").hide();
                $(".files-type-content").hide();
                $(".file_sortbox").show();
            } else {

                filelist = [];
                $(".blockwrapper").show();
                $(".files-type-content").show();
                $(".file_sortbox").hide();

                $(".hidden_result").removeClass("hidden_result");
                $(".searchFiles").val("");
                $(".file_sortbox").empty();

            }


        });


        /*progress function for ajax*/
        function progressHandlingFunction(e) {
            if (e.lengthComputable) {
                $('progress').attr({value: e.loaded, max: e.total});
            }
        }

        function stopDoing(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        var collection = $();

        $('body').on('dragover drop', function(e) { e.preventDefault();  });
        $(document).on('dragenter dragleave draginit dragstart dragover dragend drag drop', stopDoing);

        $(document).on("dragenter", function(e) {
            stopDoing(e);
            if(collection. length === 0) {
                $(".midsec").append($("<div class='drag-drop-zone' />").on("drop", function(e){
                    stopDoing(e);
                    console.log(e.originalEvent.dataTransfer.files);
                    handleFiles(e.originalEvent.dataTransfer.files);
                    $(".drag-drop-zone").remove();
                    $(".drag-in-file").removeAttr("style").html("or Drag in Your Files");
                    return false;
                }));
                $(".drag-in-file").css({"color":"rgba(0, 0, 0, 0.3)"}).html("Drop Your Files Here");
            }
            collection = collection.add(e.target)
        }).on("dragleave drop", function(e) {
            stopDoing(e);
            collection = collection.not(e.target); 
            if(collection.length === 0) {
                $(".drag-drop-zone").remove();
                $(".drag-in-file").removeAttr("style").html("or Drag in Your Files");
            }
            return false;
        })

        function bindDeleteButton() {        
            $("div.files-type-content div.file div.delete").click(function() {
                console.log($(this));
                var file_id = $(this).closest(".file").attr("id");
                $.ajax({
                    url: "php/file_ops.php", 
                    data: { "file_id" : file_id }, 
                    type: "post",
                    success: reloadPage
                });
            })
        }

        bindDeleteButton();

    });
</script>


<div class='files-tab-content'>
    <div class='files-search-top'>
        <input name='sb-files' type='hidden' />
        <div class='sortwrapper'>
            <label for='sort' class='sortByLabel'>Sort By</label> <select class='sortByDropdown' name='sort' id='sort'>
              <option value='filetype-rank'>File Type</option>
              <option value='recent-rank'>Recent Uploads</option>
            </select>
        </div>
        <div class='filetxt_wrapper'>
            <input type='text' class='inputText searchFiles' name='Search Files' placeholder='Search the files uploaded to this class...' />
        </div>
        <form>
            <div class='invite-users upload-files'>Upload A New File</div>
            <input class='upload_file_at_course' type='file' name='file' multiple>
            <div class="drag-in-file">or Drag in Your Files</div>
        </form>
    </div>
<div class='file_sortbox'></div>

<div class='class-file-list'>
    <?php
    echo $this->renderPartial('class_files_list',array('class'=>$class,'user'=>$user, 'files'=>$files));
    ?>

</div>