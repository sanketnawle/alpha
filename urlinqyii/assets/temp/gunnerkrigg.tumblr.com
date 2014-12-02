<!DOCTYPE html>
<script>var __pbpa = true;</script><script>var translated_warning_string = 'Warning: Never enter your Tumblr password unless \u201chttps://www.tumblr.com/login\u201d\x0ais the address in your web browser.\x0a\x0aYou should also see a green \u201cTumblr, Inc.\u201d identification in the address bar.\x0a\x0aSpammers and other bad guys use fake forms to steal passwords.\x0a\x0aTumblr will never ask you to log in from a user\u2019s blog.\x0a\x0aAre you absolutely sure you want to continue?';</script><script type="text/javascript" language="javascript" src="http://assets.tumblr.com/assets/scripts/pre_tumblelog.js?_v=0fe6931f685c5a29060675a836044a62"></script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!--
     Theme: The Minimalist v1.
     Design: The Minimalist (http://minimalist.co)
-->

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# blog: http://ogp.me/ns/blog#">
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
     <title>Gunnerkrigg and All Else</title>	
     <meta name="description" content="www.gunnerkrigg.com" />
     <meta name="if:Show description" content="1" />	
     <meta name="if:Show search" content="1" />
     <meta name="text:Twitter name" content="" />
     <meta name="text:Disqus Shortname" content="" />
     <meta name="text:Google Analytics ID" content="" />	
     <link rel="shortcut icon" href="http://38.media.tumblr.com/avatar_d1e2244293b5_128.png" />
     <link rel="alternate" type="application/rss+xml" title="Gunnerkrigg and All Else" href="http://gunnerkrigg.tumblr.com/rss" />

<!-- Styles -->

<link rel="stylesheet" href="http://static.tumblr.com/f1whv92/Mp9l6ewcg/reset.css" />
<style type="text/css">

/*----- GENERAL -----*/

     header, footer, section, article, nav, aside {
        display: block;
     }

     body {
        background: #ffffff;
        color: #222;
        font: 12px/20px Georgia, "Times New Roman", Times, serif;
        padding-top: 25px;
        text-align: center;
        width:500px;
        margin: 0 auto;
     }

     h1, h2, h3, hQ {
        font-family: Cufon;
     }

     h1 {
        font-size: 50px;
        line-height: 50px;
     }

     h2 {
        font-size: 31px;
        line-height: 37px; 
     }

     h3 {
        font-size: 21px;
        line-height: 27px; 
     }

     a:link, a:visited {
        color: #222222;
        font-weight: bold;
        text-decoration: none;
     }
     
     a:hover, a:active {
        text-decoration: underline;
     }

     hr{
        border:0 #ccc solid;
        border-top-width:1px;
        clear:both;
        height:0;
     }

     ol{list-style:decimal}

     ul{list-style:disc}

     li{margin-left:30px}

     p,dl,hr,h1,h2,h3,h4,h5,h6,ol,ul,pre,table,address,fieldset{margin-bottom:15px}

     #main {
        padding: 0px;
     }

/*----- MASTHEAD -----*/

     .noMeta > div {
        padding: 0px;
     }

     #masthead {
        margin-bottom: 0px;
     }

     #masthead h1 {
        margin-bottom: 0;
     }

     #masthead h1 a:link, #masthead h1 a:visited {
        text-transform: Uppercase;
        color: #222;
        text-decoration: none;
     }

     #masthead h1 a:active {
        outline: 0;
     }

     #masthead p {
        font-family: Georgia, serif;
        font-size: 20px;
        color: #fff;
        margin-bottom: 0;
     }

     #masthead a:link, #masthead a:visited {
        color: #fff;
     }

     #siteDescription{
        font-size: 13px;
        color: #222;
        text-transform: Uppercase;
        border-top: 1px solid #222;
        margin-top: 20px;
        margin-bottom: -5px;
        padding: 10px 0 0 0;
        font-family: Cufon;
     }

/*----- SEARCH FORM -----*/

     #frmSearch {
        padding-top: 20px; 
        display: none;
     }

     #txtSearch {
        background: url(http://static.tumblr.com/bpryy0m/6lRl6gmys/search.jpg) left no-repeat;
        width: 225px;
        padding: 2px 0 0 20px;
        font: 12px/12px Georgia, "Times New Roman", Times, serif;
        color: #222;
        border: 0px;
     }

/*----- MAIN HEADER NAV STRIP -----*/

     #mainNav {
        border-top: 1px solid #222;
        border-bottom: 2px solid #222;
        margin-top: 20px;
        padding: 13px 0 14px 0;
        font-family: Cufon;
     }

     #mainNav ul {
        list-style: none;
        margin: 0;
        padding: 0;
     }

     #mainNav li {
        margin: 5px;
        display: inline;
        padding: 0;
     }

     #mainNav a:link, #mainNav a:visited {
        padding: 0;
        font-size: 14px;
        line-height: 14px;
        margin: 0 2px;
        text-decoration: none;
        color: #222;
        text-transform: Uppercase;
     }

     #mainNav a:hover, #mainNav a:active {
        outline: none;
        text-decoration: none;
        border-bottom: 1px solid #222;
     }

     #mainNav a.active {
        text-decoration: none;
        border-bottom: 1px solid #222;
     }

/*----- ARTICLE META INFO -----*/

     #designline {
        margin-top: 50px;
     }

     h5{
        position: relative;
        top: -35px;
        margin-bottom: 0px;
        font-family: Georgia, serif;
        font-size: 10px;
        color: #bca474;
        text-decoration: none;
        text-transform: Uppercase;
        font-weight: bold;
        border-bottom: 1px solid #bca474;
        background: #fff;
     }

     h5 a:link, .line a:visited{
        font-family: Georgia, serif;
        font-size: 10px;
        color: #bca474;
        text-decoration: none;
        text-transform: Uppercase;
        font-weight: bold;
     }

     h5 a:hover{
        text-decoration: underline;
     }

     h5 abbr{
        display: inline-block;
        position: relative;
        margin: 0 auto;
        padding: 0 8px;
        background: #fff;
        top: 10px;
     }

     h5.postDate a{
        color: #bca474;
     }

/*----- ARTICLE -----*/

     article {
        background: #fff;
        margin-bottom: 20px;
        text-align: left;
       position: relative;
      }

     article img {
        border: none;
        margin-bottom: 15px;
        max-width: 500px;
        position: center;
     }

     article p img {
        margin: 0;
     }
     article > div {
        padding: 0px;
        overflow: hidden;
     }
     article .searchPage {
        margin: 35px 0 0 0;
     }

     .searchPageText {
        margin: 0 0 30px 0;
     }

     article .meta a:link, article .meta a:visited {
        text-decoration: none;
     }

     article .meta a:hover, article .meta a:active {
        text-decoration: underline;
     }

     article h2 {
        text-align: center;
        color: #222222;
     }

     article h2 a:link, article h2 a:visited {
        text-transform: Uppercase;
        color: #222;
        text-decoration: none;
     }

     article h2 a:hover, article h2 a:active {
        text-decoration: none;
        border-bottom: 1px solid #222;
     }

     blockquote {
        border-left: 2px solid #bca474;
        margin-left: 0;
        padding-left: 1em;
     }

     #quoteSource{
        margin: 0 auto;
        text-align: left;
     }

     #quoteText h2 {
        text-align: left;
        color: #222222;
     }

     article .chat {
        list-style: none;
        padding: 0;
        margin: 0;
     }

     article .chat li {
        margin: 0 0 2px;
        padding: 2px 0 2px 0;
     }

     .photoCaption {
        text-align: center;
     }

/*----- AUDIO PLAYER -----*/

     .audio {
        height: 28px;
        width: 26px;
        overflow: hidden;
        margin: auto;
        padding-top: 7px;
     }

     .audioc {
        background-image:url('http://static.tumblr.com/f1whv92/9iCl6bfgp/audiocircle.png');
        background-repeat: no-repeat; 
        height: 41px;
        width: 41px;
     }

     .audioCaption {
        margin-top: 1px;
     }

     .audioleft {
        width: 41px;
        float: left;
      }

     .audioright {
        width: 444px;
        float: right;
      }

     .audioContainer {
        margin-top: 5px;
     }

     .audioClear {
        clear:both;
     }

/*----- ARTICLE NOTES -----*/

     .notes {
        border-top: 1px solid #bca474;
        list-style: none;
        padding: 20px 0 5px 0;
        margin: 30px 0 0 0;
     }
     .notes li {
        margin: 0;
     }

     .notes .avatar {
        margin: 0 5px 0 0;
        position: relative;
        top: 5px;
     }

     .notes blockquote {
        margin: 10px 0 0 35px;
        padding-left: 10px;
        border-left: 2px solid #222222;
     }

     .media {
        width: 500px;
        margin-bottom: 20px;
     }

/*----- PAGE NAVIGATION -----*/

     #pageNav {
        margin-top: 20px;
        border-top: 1px solid #222;
     }

     #pageNav ul {
        list-style: none;
        padding: 10px 15px;
        margin: 10px 0;
     }

     #pageNav li {
        margin: 0;
        display: inline;
     }

     #pageNav a:link, #pageNav a:visited {
        font: 11px Georgia, "Times New Roman", Times, serif;
        padding: 0;
        margin: 0 2px;
        background: #34hdf5;
        color: #222;
        text-decoration: none;
     }

     #pageNav a:hover, #pageNav a:active, #pageNav a.active:link, #pageNav a.active:visited {
        text-decoration: underline;
     }

     #pageNavOlder:after {
        content: " »";
        font-size: 10px;
     }

     #pageNavNewer:before {
        content: "« ";
     }

/*----- FOOTER META -----*/

     #sitemeta {
        border-top: 2px solid #222;
        color: #222;
        padding: 20px 0 32px 0;
        font-family: Georgia, "Times New Roman", Times, serif;
        font-size: 11px;
     }

     #sitemeta p {
        margin: 0;
     }

     #sitemeta a:link, #sitemeta a:visited {
        color: #222;
        font-weight: bold;
     }


</style>

<!-- Scripts -->

<!--[if IE]>
     <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
     <script src="http://static.tumblr.com/oawavkn/JPAlyq9zp/cufon-yui.js" type="text/javascript"></script>
     <script src="http://static.tumblr.com/f1whv92/fgIl65bo1/cufon_300.font.js" type="text/javascript"></script>

     <script type="text/javascript">
        Cufon.replace('h1',{ fontFamily: "Cufon" });
        Cufon.replace('h2',{ fontFamily: "Cufon" });
        Cufon.replace('h3',{ fontFamily: "Cufon" });
        Cufon.replace('#mainNav',{ fontFamily: "Cufon" });
        Cufon.replace('#siteDescription',{ fontFamily: "Cufon" });
     </script>

<script>
     $(function() {
        var search = $("#txtSearch").val();
        var placeholder = "Search...";
        var fadeToOpacity = 0.4;
        $("#txtSearch").fadeTo("normal", fadeToOpacity);
        if (search == "") {
     $("#txtSearch").val(placeholder);
     }
     $("#txtSearch").blur(function() {
        search = $("#txtSearch").val();
        if (!(search != "" && search != placeholder)) {
        $("#txtSearch").val(placeholder);
     }
     $("#txtSearch").fadeTo("normal", fadeToOpacity);
     });
     $("#txtSearch").focus(function() {
        search = $("#txtSearch").val();
        if (search == placeholder) {
        $("#txtSearch").val("");
     }
     $("#txtSearch").fadeTo("normal", 1);
     });
     $("#btnSearch").click(function() {
     $("#frmSearch").slideToggle("normal");
     $(this).toggleClass("active");
 //  $("#txtSearch").focus();
     });
     });
</script>

<link rel="alternate" href="android-app://com.tumblr/tumblr/x-callback-url/blog?blogName=gunnerkrigg" />
<script src="http://assets.tumblr.com/assets/scripts/tumblelog.js?_v=c78ef57bd25c48e7f24a984e7ef6ceba"></script>
<meta http-equiv="x-dns-prefetch-control" content="off"/>

<!-- BEGIN TUMBLR FACEBOOK OPENGRAPH TAGS --><!-- If you'd like to specify your own Open Graph tags, define the og:url and og:title tags in your theme's HTML. --><!-- Read more: http://ogp.me/ --><meta property="fb:app_id" content="48119224995" /><meta property="og:title" content="Gunnerkrigg and All Else" /><meta property="og:url" content="http://gunnerkrigg.tumblr.com/?og=1" /><meta property="og:description" content="www.gunnerkrigg.com" /><meta property="og:type" content="tumblr-feed:tumblelog" /><meta property="og:image" content="http://38.media.tumblr.com/avatar_d1e2244293b5_128.png" /><meta property="al:ios:url" content="tumblr://x-callback-url/blog?blogName=gunnerkrigg" /><meta property="al:ios:app_name" content="Tumblr" /><meta property="al:ios:app_store_id" content="305343404" /><meta property="al:android:url" content="tumblr://x-callback-url/blog?blogName=gunnerkrigg" /><meta property="al:android:app_name" content="Tumblr" /><meta property="al:android:package" content="com.tumblr" /><!-- END TUMBLR FACEBOOK OPENGRAPH TAGS -->


<!-- TWITTER TAGS --><meta charset="utf-8"><meta name="twitter:site" content="tumblr" /><meta name="twitter:card" content="summary" /><meta name="twitter:title" content="gunnerkrigg" /><meta name="twitter:description" content="www.gunnerkrigg.com" /><meta name="twitter:app:name:iphone" content="Tumblr" /><meta name="twitter:app:name:ipad" content="Tumblr" /><meta name="twitter:app:name:googleplay" content="Tumblr" /><meta name="twitter:app:id:iphone" content="305343404" /><meta name="twitter:app:id:ipad" content="305343404" /><meta name="twitter:app:id:googleplay" content="com.tumblr" /><meta name="twitter:app:url:iphone" content="tumblr://x-callback-url/blog?blogName=gunnerkrigg&amp;referrer=twitter-cards" /><meta name="twitter:app:url:ipad" content="tumblr://x-callback-url/blog?blogName=gunnerkrigg&amp;referrer=twitter-cards" /><meta name="twitter:app:url:googleplay" content="tumblr://x-callback-url/blog?blogName=gunnerkrigg&amp;referrer=twitter-cards" />

</head>
<body>

     <header id="masthead" class="clearfix">
        <div id="thehead">          
              <h1 class="cufon"><a href="/">Gunnerkrigg and All Else</a></h1>
              <form action="/search" method="get" id="frmSearch">
              <input type="text" id="txtSearch" name="q" value="" />
              </form>    

     
        <div id="siteDescription">www.gunnerkrigg.com</div>
     

           <nav id="mainNav">        
              
              
                               
              <li><a href="/archive">Archive</a></li>
              <li><a href="/random">Random</a></li>
              <li><a href="http://gunnerkrigg.tumblr.com/rss">RSS</a></li>
              <li><a href="javascript:;" id="btnSearch">Search</a></li>
              
           </nav>         
        </div>
     </header>

     <section id="main" class="clearfix">
     <div class="layout">           
     
      
           


     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/102448416192/chapter-16">12th Nov 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/102448416192/chapter-16#notes">75 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/d5agOAjjJsc?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 16</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/101925786652/chapter-15">6th Nov 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/101925786652/chapter-15#notes">63 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/zRAI9RrOL4c?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 15</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/101425552127/chapter-14">31st Oct 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/101425552127/chapter-14#notes">63 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/yJMW-dn7qD0?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 14</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/100662439747/chapter-13">22nd Oct 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/100662439747/chapter-13#notes">81 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/MA6RdGS8YRo?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 13</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/99643988857/chapter-12">10th Oct 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/99643988857/chapter-12#notes">73 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/gMsc0Aqapvk?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 12</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/98959142057/chapter-11">2nd Oct 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/98959142057/chapter-11#notes">87 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/GXeILNEigjc?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 11</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/98633526607">28th Sep 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/98633526607#notes">3,749 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
              <a href="http://gunnerkrigg.tumblr.com/image/98633526607"><img src="http://41.media.tumblr.com/4683b1eac29e707f5516a7f94f9734bd/tumblr_ncm6pcz6991qhu04go1_500.jpg" alt="" /></a>
              
           
          
           
          
           

                  
          
          

          
         
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/98272237527/chapter-10">23rd Sep 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/98272237527/chapter-10#notes">86 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/MliJpVzKEsw?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 10</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/97653652072/chapter-9">16th Sep 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/97653652072/chapter-9#notes">84 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/RfpVdfLXydI?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 9</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>

     <div id="designline">
        <h5 class="postDate">
           <abbr><a href="http://gunnerkrigg.tumblr.com/post/97170382677/chapter-8">10th Sep 2014</a> | <a href="http://gunnerkrigg.tumblr.com/post/97170382677/chapter-8#notes">75 notes</a>
           </abbr>
        </h5>
     </div>

     <article>
        <div>
           
          
           
          
           
          
           

                  
          
          

          
         
          
             <div class="media"><iframe width="500" height="281" src="https://www.youtube.com/embed/Lp-YIsNiOCQ?feature=oembed" frameborder="0" allowfullscreen></iframe></div>
             <div><p>Chapter 8</p></div> 
          
          
          
          
          
 
                    
            
          
          
          
 
        </div>
     </article>


     
      
     
        <nav id="pageNav">
           <ul class="clearfix">
              
             
             <li><a href="" class="active">1</a></li>
             
             
             
             <li><a href="/page/2">2</a></li>
             
             
             <li><a href="/page/3">3</a></li>
             
             
             <li><a href="/page/4">4</a></li>
             
             
             <li><a href="/page/5">5</a></li>
             
             <li><a href="/page/2" id="pageNavOlder">Older</a></li> 
           </ul>
        </nav>
      
      
     
     
     </div><!-- END layout -->
     </section>

     <footer id="sitemeta">
        <div class="clearfix">
           <div class="thefooter">
              <p><a href="http://www.tumblr.com/theme/12051">The Minimalist Theme</a> designed by <a href="http://minimalist.co">The Minimalist</a> | Powered by <a href="http://tumblr.com">Tumblr</a></p>
           </div>
        </div>
     </footer>

     

<!-- BEGIN TUMBLR CODE --><iframe scrolling="no" width="1" height="1" frameborder="0" style="background-color:transparent; overflow:hidden; position:absolute; top:0; left:0; z-index:9999;" id="ga_target"></iframe><script type="text/javascript">
    (function(){
        var analytics_frame = document.getElementById('ga_target');
        var analytics_iframe_loaded;
        var user_logged_in;
        var blog_is_nsfw = 'No';
        var addthis_enabled = false;

        var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
        var eventer = window[eventMethod];
        var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
        eventer(messageEvent,function(e) {
            var message = (e.data && e.data.split) ? e.data.split(';') : '';
            switch (message[0]) {
                case 'analytics_iframe_loaded':
                    analytics_iframe_loaded = true;
                    postCSMessage();
                    postGAMessage();
                    postATMessage();
                    break;
                case 'user_logged_in':
                    user_logged_in = message[1];
                    postGAMessage();
                    postATMessage();
                    break;
            }
        }, false);

        analytics_frame.src = "https://secure.assets.tumblr.com/analytics.html?a57a7a4b4579d695d8e64bdfee554a5e#http://gunnerkrigg.tumblr.com";
        function postGAMessage() {
            if (analytics_iframe_loaded && user_logged_in) {
                var is_ajax = false;
                analytics_frame.contentWindow.postMessage(['tick_google_analytics', is_ajax, user_logged_in, blog_is_nsfw, '/?route=%2F'].join(';'), analytics_frame.src.split('/analytics.html')[0]);
            }
        }
        function postCSMessage() {
            COMSCORE = true;
            analytics_frame.contentWindow.postMessage('enable_comscore;' + window.location, analytics_frame.src.split('/analytics.html')[0]);
        }
        function postATMessage() {
            if (addthis_enabled && analytics_iframe_loaded) {
                analytics_frame.contentWindow.postMessage('enable_addthis', analytics_frame.src.split('/analytics.html')[0]);
            }
        }
    })();
</script><script type="text/javascript">!function(s){s.src='https://www.tumblr.com/impixu?T=1417068994&J=eyJ0eXBlIjoidXJsIiwidXJsIjoiaHR0cDpcL1wvZ3VubmVya3JpZ2cudHVtYmxyLmNvbVwvIiwicmVxdHlwZSI6MCwicm91dGUiOiJcLyJ9&U=FEHJMKNIDN&K=3ef708cbdc069bdfda78eda5b9bdfb7e93b6e422b0ed0a90787a464e0312c962&R='.replace(/&R=[^&$]*/,'').concat('&R='+escape(document.referrer)).slice(0,2000).replace(/%.?.?$/,'');}(new Image());</script><noscript><img style="position:absolute;z-index:-3334;top:0px;left:0px;visibility:hidden;" src="https://www.tumblr.com/impixu?T=1417068994&J=eyJ0eXBlIjoidXJsIiwidXJsIjoiaHR0cDpcL1wvZ3VubmVya3JpZ2cudHVtYmxyLmNvbVwvIiwicmVxdHlwZSI6MCwicm91dGUiOiJcLyIsIm5vc2NyaXB0IjoxfQ==&U=FEHJMKNIDN&K=58e8f527f9ad3d273c2f5741166e7705b44df0e6a3e8b7a6aed72a109d6f46c7&R="></noscript><script>
        (function (w,d) {
            'use strict';
            var l = function(el, type, listener, useCapture) {
                el.addEventListener ?
                el.addEventListener(type, listener, !!useCapture) :
                el.attachEvent && el.attachEvent('on' + type, listener, !!useCapture);
            };
            var a = function () {
                                if (d.getElementById('tumblr-cdx')) {
                    return;
                }
                var s = d.createElement('script');
                var el = d.getElementsByTagName('script')[0];
                s.async = true;
                s.src = 'http://assets.tumblr.com/assets/scripts/vendor/cedexis/cedexis.radar.min.js?_v=1360de60c9b05c6a55bd6a6e510e1699';
                s.type = 'text/javascript';
                s.id = 'tumblr-cdx';
                d.body.appendChild(s);
            };
            l(w,'load',a);
        }(window, document));
</script><script type="text/javascript">!function(s){s.src='https://www.tumblr.com/impixu?T=1417068994&J=eyJ0eXBlIjoicG9zdCIsInVybCI6Imh0dHA6XC9cL2d1bm5lcmtyaWdnLnR1bWJsci5jb21cLyIsInJlcXR5cGUiOjAsInJvdXRlIjoiXC8iLCJwb3N0cyI6W3sicG9zdGlkIjoiMTAyNDQ4NDE2MTkyIiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6IjEwMTkyNTc4NjY1MiIsImJsb2dpZCI6IjE0MDI0NDI5Iiwic291cmNlIjozM30seyJwb3N0aWQiOiIxMDE0MjU1NTIxMjciLCJibG9naWQiOiIxNDAyNDQyOSIsInNvdXJjZSI6MzN9LHsicG9zdGlkIjoiMTAwNjYyNDM5NzQ3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk5NjQzOTg4ODU3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk4OTU5MTQyMDU3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk4NjMzNTI2NjA3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk4MjcyMjM3NTI3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk3NjUzNjUyMDcyIiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk3MTcwMzgyNjc3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfV19&U=LPEPKLIAIG&K=beb0e24808ce08ee33e5000ac8887ffc38fba18988a187009f7ae84995d06d79&R='.replace(/&R=[^&$]*/,'').concat('&R='+escape(document.referrer)).slice(0,2000).replace(/%.?.?$/,'');}(new Image());</script><noscript><img style="position:absolute;z-index:-3334;top:0px;left:0px;visibility:hidden;" src="https://www.tumblr.com/impixu?T=1417068994&J=eyJ0eXBlIjoicG9zdCIsInVybCI6Imh0dHA6XC9cL2d1bm5lcmtyaWdnLnR1bWJsci5jb21cLyIsInJlcXR5cGUiOjAsInJvdXRlIjoiXC8iLCJwb3N0cyI6W3sicG9zdGlkIjoiMTAyNDQ4NDE2MTkyIiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6IjEwMTkyNTc4NjY1MiIsImJsb2dpZCI6IjE0MDI0NDI5Iiwic291cmNlIjozM30seyJwb3N0aWQiOiIxMDE0MjU1NTIxMjciLCJibG9naWQiOiIxNDAyNDQyOSIsInNvdXJjZSI6MzN9LHsicG9zdGlkIjoiMTAwNjYyNDM5NzQ3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk5NjQzOTg4ODU3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk4OTU5MTQyMDU3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk4NjMzNTI2NjA3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk4MjcyMjM3NTI3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk3NjUzNjUyMDcyIiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfSx7InBvc3RpZCI6Ijk3MTcwMzgyNjc3IiwiYmxvZ2lkIjoiMTQwMjQ0MjkiLCJzb3VyY2UiOjMzfV0sIm5vc2NyaXB0IjoxfQ==&U=LPEPKLIAIG&K=24ce3e412ac4a40dc1b921d822aeca78e90cb80210a26c7fcc16e4f966e7b642&R="></noscript><script>
                (function() {
                    var s = document.createElement('script');
                    var el = document.getElementsByTagName('script')[0];
                                            s.src = ('https:' == document.location.protocol ? 'https://s' : 'http://l') + '.yimg.com/ss/rapid-3.18.1.js';
                                        s.onload = function(){
                        var YAHOO = window.YAHOO;
                        if (YAHOO) {
                            var keys = {
                                pd:'/',
                                _li:0,
                                b_id:14024429,
                                i_rad:0,
                                i_strm:0
                            };
                            var conf = {
                                                                spaceid:1197716038,
                                client_only:1,
                                yql_enabled:false,
                                keys:keys,
                                nol:1
                            };
                            YAHOO.rapid = new YAHOO.i13n.Rapid(conf);
                        }
                    };
                    el.parentNode.insertBefore(s, el);
                })();
            </script><script>
        (function (w,d) {
            'use strict';
            var l = function(el, type, listener, useCapture) {
                el.addEventListener ?
                el.addEventListener(type, listener, !!useCapture) :
                el.attachEvent && el.attachEvent('on' + type, listener, !!useCapture);
            };
            var a = function () {
                                if (d.getElementById('tumblr-cdx')) {
                    return;
                }
                var s = d.createElement('script');
                var el = d.getElementsByTagName('script')[0];
                s.async = true;
                s.src = 'http://assets.tumblr.com/assets/scripts/vendor/cedexis/cedexis.radar.min.js?_v=1360de60c9b05c6a55bd6a6e510e1699';
                s.type = 'text/javascript';
                s.id = 'tumblr-cdx';
                d.body.appendChild(s);
            };
            l(w,'load',a);
        }(window, document));
</script><iframe id="tumblr_controls" class="tumblr_controls" width="1" height="1" frameborder="0" scrolling="no" src="https://secure.assets.tumblr.com/assets/html/iframe/o.html?_v=fcf4abb1678c045656fdf3cc23b62713#src=http%3A%2F%2Fgunnerkrigg.tumblr.com%2F&amp;lang=en_US&amp;name=gunnerkrigg&amp;avatar=http%3A%2F%2F33.media.tumblr.com%2Favatar_d1e2244293b5_64.png&amp;title=Gunnerkrigg+and+All+Else&amp;url=http%3A%2F%2Fgunnerkrigg.tumblr.com%2F&amp;page_slide=no_slide"></iframe><div id="teaser_iframe_container" style="display:none;"><iframe scrolling="no" frameborder="0" src="https://www.tumblr.com/assets/html/iframe/teaser.html?_v=9eb77f034c39fdbdf755c448cd096be2#src=http%3A%2F%2Fgunnerkrigg.tumblr.com%2F&amp;lang=en_US&amp;name=gunnerkrigg&amp;avatar=http%3A%2F%2F33.media.tumblr.com%2Favatar_d1e2244293b5_64.png&amp;title=Gunnerkrigg+and+All+Else&amp;url=http%3A%2F%2Fgunnerkrigg.tumblr.com%2F&amp;page_slide=no_slide" id="teaser_iframe" width="1" height="1"></iframe></div><script type="text/javascript">
    (function(Tumblr){
        var follow_iframe_initialized = false;
        if (Tumblr.FollowTeaser && Tumblr.PostMessageListener) {
            // Don't do anything until the first initialize event
            Tumblr.PostMessageListener.initialize(function(message, origin) {
                if (follow_iframe_initialized || message.length < 2) return;

                if (message[0] === 'follow_iframe' && message[1] === 'enable') {
                    Tumblr.FollowTeaser.current_page = 1;
                    Tumblr.FollowTeaser.infer_infinite_scroll = true;
                    Tumblr.FollowTeaser.create_from_tumblr_controls("http:\/\/assets.tumblr.com\/assets\/html\/iframe\/follow.html?_v=24d9786c2cc9f3f3a7bd1830c7027b5e");
                    Tumblr.FollowTeaser.scroll_listener(true);
                    follow_iframe_initialized = true;
                }
            });
        }
    })(this.Tumblr || (this.Tumblr = {}));
</script><!--[if IE]><script type="text/javascript">document.getElementById('tumblr_controls').allowTransparency=true;</script><![endif]--><!-- END TUMBLR CODE -->

</body>
</html>