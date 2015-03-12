<!--
    @license
    Copyright (c) 2014 The Polymer Project Authors. All rights reserved.
    This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
    The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
    The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
    Code distributed by Google as part of the polymer project is also
    subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
-->
<head>
  <title>core-animated-pages</title>

  <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/bower_components/webcomponentsjs/webcomponents.js"></script>
  <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/js/bower_components/core-animated-pages/core-animated-pages.html" rel="import">
  <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_syllabus.css">

</head>
<body>


  <polymer-element name="music-demo">
    <template>
<style>
    body {
      margin: 0;
      background: #f1f1f1;
    }

    div#event_count{
      margin-top:22px;
      margin-bottom:22px;
      color:#444;
      font-weight:200;
      display: inline-block;
      padding-left:7px;
      font-size:17px;
      font-family:"Open Sans", sans-serif;
    }

    span.day_text{
      font-family: "Open Sans", sans-serif;
      font-size: 51px;
      font-weight: 600;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      line-height: 56px;
    }

    span.month_text{
      font-family: "Open Sans", sans-serif;
      font-size: 33px;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      display: block;
      font-weight: 400;
      padding-top: 10px;
    }


   .img_arrows{
      display: inline-block;
      margin-right: 10px;
      width: 42px;
      height: 86px;
      background: rgba(18, 19, 20, 0.9);
      cursor: pointer;
      top: 152px;
      border-radius: 3px;
      -moz-box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.06) inset;
      -webkit-box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.06) inset;
      box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.06) inset;
      border: 1px solid #000;
      }

      .img_arrows:hover{
          background: rgba(18, 19, 20, 0.77);
      -moz-box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.11) inset;
      -webkit-box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.11) inset;
      box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.11) inset;         
      }
      .img_arrows:active{
          background: rgba(18, 19, 20, .96);
      -moz-box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.25) inset;
      -webkit-box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.25) inset;
      box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.25) inset;   
      }
      .img_rt{
      position: absolute;
      right: -20px;
      }
      .img_lt{
      position: absolute;
      left: -18px;
      }

      .img_arrows > em{
        background-image: url('../assets/small_icons.png');
        background-size: auto;
        display: block;
        width: 20px;
        height: 58px;
        position: relative;
        left: 12px;
        top: 15px;
      }

      .img_arrows.img_rt > em{  background-position: -54px -1534px;}
      .img_arrows.img_lt > em{  
        background-position: -104px -1534px;
        left: 10px;
      }
      .month{
        font-size: -webkit-xxx-large;
        color: white;
        margin-left: 20px;
      }
     
      .chip-container {
      margin-right: 15px;
      font-family: Avenir;
      font-weight: 400;
      color: #333;
      font-size: 16px;
      color: #333;
      padding-bottom: 6px;
      font-weight: 500;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      margin-bottom: 14px;
        position: absolute;
        text-align: center;
        width: 100%;
        max-height: 300px
      }

      .chip {
        float: left;
        width: 24%;
        display: inline-block;
        position: relative;
        border-radius: 3px;
        -moz-transition: .25s box-shadow;
        -webkit-transition: .25s box-shadow;
        transition: .25s box-shadow;
        margin: 4px;
        overflow: hidden;
        text-align: start;
        background-color: #fff;
        -moz-box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
        -webkit-box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
        box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
        cursor: pointer;
      }
      .chip:hover{
        -moz-box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.18);
        -webkit-box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.18);
        box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.18);        
      }
      .time {
        font-size: large;
        color: white;
        margin-left: 30px;
        margin-top: 20px;
      }
      .input_text{
        height: 50px;
        width:100%;
        border-radius: 10px;
      }
      .btn_update {
        height:29px;
        width:90%;
        border-radius:4px;
        border-style: ridge;
      }
      .time_card {
        font-size: large;
        color: white;
        margin-left: 30px;
        margin-top: 50px;
      }
      .chip-top {
        width: 200px;
        height: 200px;
      }

      .chip-bottom {
        padding: 8px;
        line-height: 1.5;
        height: 48px;
      }

      .chip-album-title {
        font-weight: bold;
        font-family: "Open sans", sans-serif;
        font-weight: 500;
        font-size: 15px;
        color: #222;
        height: 46px;
        overflow: hidden;
      }

      #details {
        padding: 200px 10% 0;
      }

      .card {
        height: 300px;
        border-radius: 3px;
        text-align: start;
        overflow: hidden;
        background: #fff;
        width: 100%;
        box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      }

      .card-left {
        width: 40%;
      }

      .card-right {
        padding: 24px;
      }

      .card-icon {
        border-radius: 50%;
        width: 60px;
        height: 60px;
        margin-right: 16px;
      }

      .card-album-title {
        font-size: larger;
      }
      .desc_loc_class {
        height: 33%;
        overflow-y: auto;
        width: 100%;
        overflow-x: hidden;
        word-wrap: break-word;
      }
      div.syllabus_tab_add_event_wrapper{
        display: inline-block;
        position: relative;
      }

      div.syllabus_tab_add_event_wrapper > div.add_event_button{
        background-image: url('../assets/small_icons.png');
        background-position: -3px -1542px;
        width: 29px;
        height: 24px;
        opacity: .5;
        position: relative;
        top: 6px;
        cursor: pointer;
      }

       div.syllabus_tab_add_event_wrapper > div.add_event_button:hover{
          opacity:1;
       }

      div.syllabus_tab_add_event_wrapper > div.add_event_button:hover ~ div.add_event_hint{
          opacity: 1;
      }

      div.add_event_hint{
      position: absolute;
      -moz-transition: all .05s ease-in-out;
      -webkit-transition: all .05s ease-in-out;
      transition: all .05s ease-in-out;
      display: block;
      opacity: 0;
      z-index: -1;
      pointer-events: none;
      z-index: 1;
      top: 26px;
      -webkit-transition-delay: .1s;
      left: 14px;
      -moz-transition-delay: .1s;
      transition-delay: .1s;
      }

      div.add_event_hint > div.wedge{
      position: absolute;
      width: 0;
      height: 0;
      border-top: 6px solid transparent;
      border-bottom: 6px solid transparent;
      border-right: 7px solid rgba(18, 19, 20, 0.89);
      left: 17px;
      top: -13px;
      }

      div.add_event_hint > div.box{
      width: 96px;
      font-size: 12.5px;
      font-style: italic;
      padding: 8px 8px;
      display: inline-block;
      text-align: center;
      position: absolute;
      border-radius: 3px;
      font-family: Avenir;
      left: 24px;
      color: #FFF;
      top: -22px;
      background: rgba(18, 19, 20, 0.89);
      }


    </style>
    <core-animated-pages selected="{{page}}" transitions="hero-transition" on-core-animated-pages-transition-end="{{complete}}">

  <section>
        
    <div id="event_count">{{count_text}}</div>
    <div class = "syllabus_tab_add_event_wrapper">
      <div class = "add_event_button">
      </div>
      <div class = "add_event_hint">
          <div class = "wedge">
          </div>
          <div class = "box">Add New Event</div>
      </div>
    </div>
    <div class="chip-container" id="chip_div" hero-p on-tap="{{transition}}">
      <template repeat="{{items as item}}" id="chip_template">
        <div class="chip_content">
          <div class="chip" hero-id="{{item.event_id}}" hero?="{{selectedAlbum === item }}">
            <div class="chip-top" style="background:{{item.color}};" hero-id="{{item.event_id}}" hero?="{{item.selectedAlbum === item}}">
              <div class="month">
                <span class = "month_text">{{item.month}}</span>
                <span class = "day_text">{{item.day}}</span>
              </div>
              <div class="time">
                <span>{{item.time}}</span>
              </div>
            </div>
            <div class="chip-bottom">
              <div class="chip-album-title">{{item.title}}</div>
              <div class="chip-artist"></div>
            </div>
          </div>
        </div>
      </template>
        
    </div>
    <span style="display:{{left_arrow}}" on-tap="{{clicked_previous}}" class="img_arrows img_lt" style="display:none;"/><em></em></span>
    <span style="display:{{right_arrow}}" on-tap="{{clicked_next}}" class="img_arrows img_rt"><em></em></span>
  </section>
  <section id="details" style="top: -201px;">

    <div class="card" layout horizontal hero-id="{{selectedAlbum.event_id}}" hero >
      <div class="card-left" on-tap="{{transition}}" style="background:{{selectedAlbum.color}};" hero-id="{{selectedAlbum.event_id}}-art" hero>
          <div class="month">
              <span>{{selectedAlbum.month}}</span>
              <br>
              <span>{{selectedAlbum.day}}</span>
            </div>
          <div class="time_card">
              <span>{{selectedAlbum.time}}</span>
          </div>
      </div>
      <div class="card-right" flex>
        <div layout horizontal center>
          <div>
            <div class="card-icon" style="background:{{selectedAlbum.color}};"></div>
          </div>
          <div flex>
            <div class="card-album-title">{{selectedAlbum.title}}</div>
          </div>
        </div>
        <hr style="opacity:0.6;">
        <div class="desc_loc_class">
          <br>
          <div id="event_description" style="width:100%" title="Click to edit">
                <div on-tap="{{showdescinput}}">
                   Description: <br>{{selectedAlbum.description}}
                </div>
                <template if="{{descinput}}">
                  <div id="event_description_input" style="width:100%">
                    <span style="display:none">{{selectedAlbum.event_id}}</span>
                    
                    <div style="width:75%;float:left;">
                      <textarea type="text" class="input_text" value="{{selectedAlbum.description}}"></textarea>
                    </div>
                    <div style="margin-bottom:5px;margin-top:5px; width:25%;float:right;">
                      <button class="btn_update" on-tap="{{change_description}}">Update</button>
                    </div>
                  </div>
                </template>
              </div>
              <br>
              <div id="event_location" style="width:100%" title="Click to edit">
                <div on-tap="{{showlocationinput}}" >
                  Location: <br>{{selectedAlbum.location}}
                </div>
                <template if="{{locationinput}}">
                  <div id="event_location_input" style="width:100%">
                    <span style="display:none">{{selectedAlbum.event_id}}</span>
                    <div style="width:75%;float:left;">
                      <textarea type="text" class="input_text" value="{{selectedAlbum.location}}"></textarea>
                    </div>
                    <div style="margin-bottom:5px;margin-top:5px; width:25%;float:right;">
                      <button class="btn_update" on-tap="{{change_location}}">Update</button>
                    </div>
                  </div>
                </template>
              </div>

        </div>
      </div>
    </div>

  </section>
    </core-animated-pages>
  </template>
  </polymer-element>
<music-demo></music-demo>
</body>
