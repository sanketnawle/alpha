<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/5/14
 * Time: 2:58 PM
 */
echo "
<div class='feed-tab-content'>";

echo "<div class='group_fbar_wrap'>";
include_once('status_bar.php');
echo "</div>";

echo "<div class='group_feed_wrap'>";
include_once('feeds.php');
echo "</div>";

echo "
    <div class='feed-tab-rightsec'>
        <div class='group-about'>
            <div class='box-header'>
                <span class='bh-t1'>
                    RECENT UPLOAD
                </span>
                <span class='midline-dot'>
                    &#183;
                </span>
                <a style='font-weight:600;' class='bh-t2 small_upload'>
                    Upload a file
                </a>
                <form>
                    <input class='file_small_upload_input' type='file' name='file'>
                </form>
            </div>
            <div class='box-content content-file'>
                <a class='file-download'>
                    <div class='file-icon'>
                    </div>
                    <div class='file-name'>
                        Who is Ross Kopelman?
                    </div>
                </a>

                <div class='file-created'>
                    <a class='file-creator'>Jacob Lazarus</a> <span> uploaded July 8th</span>
                </div>
            </div>
            <div class='box-header'>
                                            <span class='bh-t1'>
                                                ABOUT
                                            </span>

            </div>
            <div class='box-content content-about'>Urlinq should strive for an 'intimate' connection with customers'
                feelings. 'We will truly understand their needs better than any other company,' Lazarus wrote.
            </div>
            <div class='box-header'>
                <a class='bh-t2 small_invite_email'>
                    Invite email list
                </a>
            </div>
            <div class='box-content content-invite'>
                <form rel='' method='post'>
                    <input type='hidden' autocomplete='off'>
                    <i class='plusIcon'></i>

                    <div class='invite-input-wrap'>
                        <div class='innerWrap'>
                            <input type='text' class='inputText inviteInput' name='Invite form'
                                   placeholder='Invite people to join this course'>

                            <div class='search-icon' title='Search people'>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
";

?>