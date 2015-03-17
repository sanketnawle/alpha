<head>
  <title>core-animated-pages</title>

  <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/bower_components/webcomponentsjs/webcomponents.js" rel="import"></script>
  <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/js/bower_components/core-animated-pages/core-animated-pages.html" rel="import">
  <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_syllabus.css" rel="import">

</head>
<body>


  <polymer-element name="music-demo">
    <template>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/class/syllabus_tab.css">
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
              <div class="chip-artist">{{item.origin_type}}</div>
            </div>
          </div>
        </div>
      </template>
        
    </div>
    <span style="display:{{left_arrow}}" on-tap="{{clicked_previous}}" class="img_arrows img_lt" style="display:none;"/><em></em></span>
    <span style="display:{{right_arrow}}" on-tap="{{clicked_next}}" class="img_arrows img_rt"><em></em></span>
  </section>
  <section id="details" style="top: -244px;height: 100%;width: 100%;left: -86px;">

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
            <div class="card-artist">{{selectedAlbum.origin_type}}</div>
          </div>
        </div>
        <hr style="opacity:0.6;">
        <div class="desc_loc_class scrollbar-container">
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
        <hr style="opacity:0.6;">

        <div class="materials_section">
          <br>
          <div style="width:100%">
              <div>
                 <button style="width:20%">Upload</button>
                 <span style="width:15%"></span>
                 <button style="width:65%">Import from Drive</button>
              </div>
            </div>
            <div class="desc_loc_class scrollbar-container" style="height:62px;">
              <template repeat="{{files as file}}">
                  <div style="width:100%;margin:5px;">
                      <div class="files_tab_sprites upload_sprite {{file.extension}}"></div>
                      <a class="filename" data-file_type="pdf" href="{{file.name}}" download="{{file.name}}">{{file.name}}</a>
                  </div>
                  <br>
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
