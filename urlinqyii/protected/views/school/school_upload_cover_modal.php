<?php

echo '
    <div class = "modal_coverPhoto_body modal_body">
        <div class = "modal_coverPhoto_container">
            <div class = "modal_loading">
                <img class = "modal_animation" src = "">
            </div>
            <div class = "modal_content">
                <div class = "modal_header">
                    <span class = "floatL white">
                        Submit Cover Photo
                    </span>
                    <div class = "floatR cancelBtn close school_modal_close">
                    </div>
                </div>
                <div class = "modal_main">
                    <form>
                        <label for = "cover_name" class = "label_left">
                            Cover Photo Name
                        </label>
                        <input class = "inputBig inputPhotoName" id = "cover_name" placeholder = "Enter a name for this photo...">
                        <input class="cover_photo_upload" name="img" type="file" style="display:none;">

                        <div class = "uploadedPhotoFrame_display" style="background-size:cover;"></div>
                        <div class = "uploadedPhotoFrame">

                            <div class = "noPhotoText">
                                No photo uploaded
                            </div>
                            <div class = "photoicon">
                            </div>

                            <button class = "uploadPhotoBtn">
                                Upload Photo
                            </button>
                        </div>
                        <div class = "btmleft">

                            <button type=  "button" class = "cancelBtn grayBtn">
                                Cancel
                            </button>
                            <button type=  "button" class = "blueBtn pt_upload_button">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
';
?>