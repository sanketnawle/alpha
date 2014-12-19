 <?php 
 session_start();
require_once("../dbconnection.php");
include_once ("../../includes/common_functions.php");
if(isset($_GET['univ_id'])){
                $university=$_GET['univ_id'];
             }else{
             $university=$_SESSION['univ_id'];}
             $user_id=$_SESSION['user_id'];
 echo '<div class = "syllabus-tab-content">
              <div class="group-events">';
                                $query=mysqli_query($con,"SELECT title,description,groups.group_name,
                                                                       start_time,end_time,start_date,end_date 
                                                                       FROM group_event JOIN groups 
                                                                       ON groups.group_id=group_event.group_id
                                                                       WHERE groups.univ_id=$university");
                                        while($row=mysqli_fetch_array($query)){?>
                                             <b><h2><?php  echo $row['group_name'];?></h2></b><br>
                                          <b><h3><?php  echo $row['title'];?></h3></b><br>
                                            <?php echo $row['start_date']." ".$row['start_time'];?><br>
                                            <?php echo $row['end_date']." ".$row['start_time'];?><br>
                                            <p><?php echo $row['description'];?></p><br>
                                            <?php
                                        }
                                                  
                          echo '</div>
            </div>';?>
                                           