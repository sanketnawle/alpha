<?php

include('popup.html');

$echo_string = '
<div class = "planner">
  <div class = "pl_head">
    <div class = "pl_head_wrap">
      <div class = "floatL">
        <div class = "text1">My Planner
        <div class="planner_dropdown"></div>
<div class="pl_options" style="display: none;">
   <div class = "pl_option">View my full planner</div>
    <hr class="post_options_hr"></hr>
          <div class = "pl_option">View my monthly calendar</div>
    <hr class="post_options_hr"></hr>
          <div class = "pl_option">Hide all upcoming</div>
</div>
        
        </div>
        <!--<i class="fa fa-caret-down"></i>
        
        <div class = "pl_options">
          <div class = "pl_option">View my full planner</div>
          <div class = "pl_option">View my monthly calendar</div>
          <div class = "pl_option">Hide all upcoming</div>
        </div>-->
        


      </div>
    </div>
  </div>
  <div class = "add_upcoming">
    <textarea placeholder = "+ Add new Event" class = "pl_add" id="event_name" name="event_name"></textarea>
    <div class = "pl_addevnt">
      <div class = "evnt_inps">
                                                        When<input class = "set_date" name="event_date" id="event_date" readonly />

                                                        <input id="set_time_24hr"  class = "set_time" name="event_time"></input>
        <div class = "calLayer">
          <section id = "mounth" class="mounth">
            <header class="minical-header">
              <h1 class="minical-h1">JANUARY 2013</h1>

              <nav role="padigation">
                <span class="m-prev"></span>
                <span class="m-next"></span>
              </nav>
            </header>

            <article>
              <div class="days">
                <b>SU</b>
                <b>MO</b>
                <b>TU</b>
                <b>WE</b>
                <b>TH</b>
                <b>FR</b>
                <b>SA</b>
              </div>
              <div class="dates">
                <span id="calcell_su_0" class="calcell disable cl_0"></span>
                <span id="calcell_mo_1" class="calcell disable cl_1"></span>
                <span id="calcell_tu_2" class="calcell disable cl_2"></span>
                <span id="calcell_we_3" class="calcell disable cl_3"></span>
                <span id="calcell_th_4" class="calcell disable cl_4"></span>
                <span id="calcell_fr_5" class="calcell disable cl_5"></span>
                <span id="calcell_sa_6" class="calcell disable cl_6"></span>
                <span id="calcell_su_7" class="calcell disable cl_7"></span>
                <span id="calcell_mo_8" class="calcell disable cl_8"></span>
                <span id="calcell_tu_9" class="calcell disable cl_9"></span>
                <span id="calcell_we_10" class="calcell disable cl_10"></span>
                <span id="calcell_th_11" class="calcell disable cl_11"></span>
                <span id="calcell_fr_12" class="calcell disable cl_12"></span>
                <span id="calcell_sa_13" class="calcell disable cl_13"></span>
                <span id="calcell_su_14" class="calcell disable cl_14"></span>
                <span id="calcell_mo_15" class="calcell disable cl_15"></span>
                <span id="calcell_tu_16" class="calcell disable cl_16"></span>
                <span id="calcell_we_17" class="calcell disable cl_17"></span>
                <span id="calcell_th_18" class="calcell disable cl_18"></span>
                <span id="calcell_fr_19" class="calcell disable cl_19"></span>
                <span id="calcell_sa_20" class="calcell disable cl_20"></span>
                <span id="calcell_su_21" class="calcell disable cl_21"></span>
                <span id="calcell_mo_22" class="calcell disable cl_22"></span>
                <span id="calcell_tu_23" class="calcell disable cl_23"></span>
                <span id="calcell_we_24" class="calcell disable cl_24"></span>
                <span id="calcell_th_25" class="calcell disable cl_25"></span>
                <span id="calcell_fr_26" class="calcell disable cl_26"></span>
                <span id="calcell_sa_27" class="calcell disable cl_27"></span>
                <span id="calcell_su_28" class="calcell disable cl_28"></span>
                <span id="calcell_mo_29" class="calcell disable cl_29"></span>
                <span id="calcell_tu_30" class="calcell disable cl_30"></span>
                <span id="calcell_we_31" class="calcell disable cl_31"></span>
                <span id="calcell_th_32" class="calcell disable cl_32"></span>
                <span id="calcell_fr_33" class="disable calcell cl_33"></span>
                <span id="calcell_sa_34" class="disable calcell cl_34"></span>
                <span id="calcell_su_35" class="disable calcell cl_35"></span>
                <span id="calcell_mo_36" class="disable calcell cl_36"></span>
                <span id="calcell_tu_37" class="disable calcell cl_37"></span>
                <span id="calcell_we_38" class="disable calcell cl_38"></span>
                <span id="calcell_th_39" class="disable calcell cl_39"></span>
                <span id="calcell_fr_40" class="disable calcell cl_40"></span>
                <span id="calcell_sa_41" class="disable calcell cl_41"></span>
              </div>
            </article>
          </section>
        </div>
      </div>
      <div class = "evnt_create">
        <a class = "btn_canc">Cancel</a>
        <input id="add_event" class = "btn_addvent" type = "submit" value="Add"/>
      </div>
    </div>
  </div>
  <div id="result" class = "upcomingEvnt-wrapper">
  </div>
</div>';

echo $echo_string;
?>
    