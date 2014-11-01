$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide"
  });
});

jQuery(document).ready(function(){

    jQuery('a[href^="#"]').click(function(e) {

        jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top - 4}, 1000);

        return false;

        e.preventDefault();

    });

});

