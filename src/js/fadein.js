/*$(window).on('load scroll', function (){

  var box = $('.js-fadeIn');
  var animated = 'js-fadeIn--animated';
  box.each(function(){
  var scrollPos = $(window).scrollTop();
  var boxOffset = $(this).offset().top;
  var wh = $(window).height();
  
  if(scrollPos > boxOffset - wh + 300 ){
    $(this).addClass(animated);

    $(this).remove(".js-fadeIn--bg-animated");
  }
  });
  
});
*/

$(window).on('load scroll', function (){
 
  let $scroll = $(window).scrollTop();
  
  let box = $('.js-fadeIn');
  let animated = 'js-fadeIn--animated';
  box.each(function(){
  let scrollPos = $(window).scrollTop();
  let boxOffset = $(this).offset().top;
  let wh = $(window).height();
  
  let offset = $(this).data("offset");
  if (offset === undefined) {
  offset = 100;
  }
  let delay = $(this).data("delay");
  if (delay === undefined) {
  delay = 0;
  }
  if ( scrollPos >= boxOffset - wh + parseInt(offset) ) {
  $(this).css("transition-delay", (delay * 0.1 + "s"));
  $(this).addClass(animated);
  }
  
  });
});