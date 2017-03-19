<!-- To Top -->
var jq = jQuery.noConflict();
var Application = {
  init: function() {
    var touch = Modernizr.touch,
        clickEvent = (touch) ? "touchend" : "click";
    jq('.totop').on(clickEvent, Application.scrollTo);
    
    if (touch) jq('.totop').on("click", function(e){ e.preventDefault(); });
  },
  scrollTo: function(e) {
    e.preventDefault();
    jq('html, body').animate({
      scrollTop: 0
    }, 1000);
  }
};

jq(function(){
  Application.init();
});


<!-- Nav -->
jq(document).ready(function() {
  jq('.nav, .service').onePageNav({
    begin: function() {
	  console.log('start')
    },
    end: function() {
	  console.log('stop')
    }
  });
  
});

<!-- FlexSlider -->
 jq(function(){
      SyntaxHighlighter.all();
    });
    jq(window).load(function(){
      jq('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          jq('body').removeClass('loading');
        }
      });
    });