<html>


    <div id='feeds'>
        <?php

            foreach ($posts as $feed){
                echo '<div id="' . $feed->post_id . '">' . $feed->text_msg . '</div>';
            }



        ?>


    </div>
</html>
