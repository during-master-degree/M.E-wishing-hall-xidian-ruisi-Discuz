<!-- To Top -->
var Application = {
  init: function() {
    var touch = Modernizr.touch,
        clickEvent = (touch) ? "touchend" : "click";
    $('.totop').on(clickEvent, Application.scrollTo);
    
    if (touch) $('.totop').on("click", function(e){ e.preventDefault(); });
  },
  scrollTo: function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 1000);
  }
};

$(function(){
  Application.init();
});


<!-- Nav -->
$(document).ready(function() {
  $('.nav, .service').onePageNav({
    begin: function() {
	  console.log('start')
    },
    end: function() {
	  console.log('stop')
    }
  });
  
});

<!-- FlexSlider -->
 $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });