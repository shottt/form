$((function(){

  let height = 0;
  
  $(window).on("scroll", function(){

    height = $(this).scrollTop();

    if ( height > $(".js-target-scroll").height()) {
      $(".js-head-scroll").addClass("js-bg-mask");

    } else {
      $(".js-head-scroll").removeClass("js-bg-mask");
      
    }
  });
}));