
<!-- header -->
<div id="featured_slider">
	<script type="text/javascript" src="scripts/jquery.flexslider-min.js"></script>
	<script type="text/javascript" charset="utf-8">
			  $(window).load(function() {
				$('.flexslider').flexslider({
				  animation: "fade",				//String: Select your animation type, "fade" or "slide"
				  controlsContainer: ".flex-container",
				  slideshow: true,					//Boolean: Animate slider automatically
				  slideshowSpeed: 3000,				//Integer: Set the speed of the slideshow cycling, in milliseconds
				  animationDuration: 1200,			//Integer: Set the speed of animations, in milliseconds
				  directionNav: false,				//Boolean: Create navigation for previous/next navigation? (true/false)
				  controlNav: true,					//Boolean: Create navigation for paging control of each clide? Note: Leave true for	
				  mousewheel: true,					//Boolean: Allow slider navigating via mousewheel				  
				  start: function(slider) {
					$('.total-slides').text(slider.count);
				  },
				  after: function(slider) {
					$('.current-slide').text(slider.currentSlide);
				  }
				});
			  });
			</script>
	<div class="slider_wrapper">
		<div class="flexslider">
			<ul class="slides">
				<!--	 <li>
								<img src="images/slider-1.png" />
							 <div class="flex-caption">
									<div class="flex-title">Flex Title goes here</div>
									Captions and cupcakes. Winning combination.
								</div>  
							</li> -->
				<li
					style="width: 100%; float: left; margin-right: -100%; display: none;">
					<img src="images/slide-img1.jpg">
				</li>
				<li
					style="width: 100%; float: left; margin-right: -100%; display: none;">
					<img src="images/slide-img2.jpg">
				</li>
				<li
					style="width: 100%; float: left; margin-right: -100%; display: list-item;">
					<img src="images/slide-img3.jpg">
				</li>
				<li
					style="width: 100%; float: left; margin-right: -100%; display: none;">
					<img src="images/slide-img4.jpg">
				</li>

			</ul>
			<ol class="flex-control-nav">
				<li><a class="">1</a></li>
				<li><a class="">2</a></li>
				<li><a class="active">3</a></li>
				<li><a class="">4</a></li>
			</ol>
		</div>
	</div>
	<!-- .slider_wrapper -->
</div>
