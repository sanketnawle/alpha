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

</head>
<body>


  <polymer-element name="music-demo">
    <template>
    <style>
    body {
      margin: 0;
      background: #f1f1f1;
    }
   .img_arrows{
        background-image: url('<?php echo Yii::app()->getBaseUrl(true); ?>/img/arrows.png');
        display: inline-block;
        margin-right: 10px;
        width: 25px;
        height: 50px;
        opacity: 0.6;
        background-position: -80px -19px;

      }
      .img_rt{
        float: right;
        position: absolute;
        top: 102px;
        right: -14px;
        background-position: -77px -17px;
      }
      .img_lt{
        float: left;
        position: absolute;
        top: 102px;
        left: -6px;
        background-position: -16px -16px;
      }
      .month{
        font-size: -webkit-xxx-large;
        color: white;
        margin-left: 20px;
      }
     
      .chip-container {
        border-bottom: 1px solid #ccc;
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
        margin: 4px;
        overflow: hidden;
        text-align: start;
        background-color: #fff;
        box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.16);
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
      }

      .chip-album-title {
        font-weight: bold;
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
    </style>
    <core-animated-pages selected="{{page}}" transitions="hero-transition" on-core-animated-pages-transition-end="{{complete}}">

  <section>
        
    <div id="event_count" style="color:#B7B2B2;margin:5px;">{{count_text}}</div>
    <div class="chip-container" id="chip_div" hero-p on-tap="{{transition}}">
      <template repeat="{{items as item}}" id="chip_template">
        <div class="chip_content">
          <div class="chip" hero-id="{{item.event_id}}" hero?="{{selectedAlbum === item }}">
            <div class="chip-top" style="background:{{item.color}};" hero-id="{{item.event_id}}" hero?="{{item.selectedAlbum === item}}">
              <div class="month">
                <span>{{item.month}}</span>
                <br>
                <span>{{item.day}}</span>
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
    <span style="display:{{left_arrow}}" on-tap="{{clicked_previous}}" class="img_arrows img_lt" style="display:none;"/></span>
        <span style="display:{{right_arrow}}" on-tap="{{clicked_next}}" class="img_arrows img_rt"></span>
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
                   Description: {{selectedAlbum.description}}
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
                  Location: {{selectedAlbum.location}}
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
