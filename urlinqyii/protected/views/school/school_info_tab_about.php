<?php
/*
echo '
    <div class = "about-tab-about about-tab-block">
        <div class = "tab-block-header">
            <div class = "block-head-left">
                About
            </div>
            <div class = "block-head-right">
                <a class = "edit-about">
                    Edit
                    <i class = "edit-icon">

                    </i>
                </a>
            </div>
        </div>
        <div class = "tab-block-content">
            Receive a potato-salad themed haiku written by me, your name carved into a potato that will be used in the potato salad, a signed jar of mayonnaise, the potato salad recipe, hang out in the kitchen with me while I make the potato salad, choose a potato-salad-appropriate ingredient to add to the potato salad, receive a bite of the potato salad, a photo of me making the potato salad, a "thank you" posted to our website and I will say your name out loud while making the potato salad.
        </div>
    </div>
';
*/

echo '
    <div class="col span_1_of_3">
        <div class="school_header">
            ABOUT
        </div>
        <div class="school_info">
            <h3 class="school_name">
                NEW YORK UNIVERSITY
            </h3>';

          echo $school->school_description;

  echo'          <div class="school_links">
                <h3 class="school_links_header">
                    Links
                </h3>

            </div>

        </div>

    </div>
';
?>