(function(){

	let links = [
		{name: ".button-1", classHover: ".highlight-1", textHover: ".text-1", slide:".slide__item--slide1", highlightStick: ".highlight__stick-1", content: ".content-1"},
		{name: ".button-2", classHover: ".highlight-2", textHover: ".text-2", slide:".slide__item--slide2", highlightStick: ".highlight__stick-2", content: ".content-2"},
		{name: ".button-3", classHover: ".highlight-3", textHover: ".text-3", slide:".slide__item--slide3", highlightStick: ".highlight__stick-3", content: ".content-3"},
		{name: ".button-4", classHover: ".highlight-4", textHover: ".text-4", slide:".slide__item--slide4", highlightStick: ".highlight__stick-4", content: ".content-4"},
		{name: ".button-5", classHover: ".highlight-5", textHover: ".text-5", slide:".slide__item--slide5", highlightStick: ".highlight__stick-5", content: ".content-5"},
		{name: ".button-6", classHover: ".highlight-6", textHover: ".text-6", slide:".slide__item--slide6", highlightStick: ".highlight__stick-6", content: ".content-6"},
		{name: ".button-7", classHover: ".highlight-7", textHover: ".text-7", slide:".slide__item--slide7", highlightStick: ".highlight__stick-7", content: ".content-7"},
		{name: ".button-8", classHover: ".highlight-8", textHover: ".text-8", slide:".slide__item--slide8", highlightStick: ".highlight__stick-8", content: ".content-8"},
		{name: ".button-9", classHover: ".highlight-9", textHover: ".text-9", slide:".slide__item--slide9", highlightStick: ".highlight__stick-9", content: ".content-9"}
	]

	for (var i = 0 ; i < links.length; i++) {
		navAnimate(links[i]);
	}

	function navAnimate(link){
		$(link.name).on({
			mouseenter: function(){
				$(link.classHover).addClass("highlight--active");
				$(link.textHover).addClass("slide__nav-text--active");
			},
			mouseleave: function(){
				$(link.classHover).removeClass("highlight--active");
				$(link.textHover).removeClass("slide__nav-text--active");
			},
			click: function (){
				$(".slide__item").removeClass("slide__item--active");
				$(link.slide).addClass("slide__item--active");

				$(".slide__content").addClass("slide__content--down");
				$(link.content).removeClass("slide__content--down");

				$(".highlight__stick").removeClass("highlight--active");
				$(link.highlightStick).addClass("highlight--active");
			}
		});
	}

	var scrolled = false,
	scrollTimeout;

	function scrollDown(link){
		if($(".slide__item:last-child").hasClass("slide__item--active")){
			console.log("lastslide");
			return false;
		}
		else{
			$(".highlight__stick.highlight--active").parentsUntil(".slide__nav-list","li").next().find('.slide__nav-button').click();
		}
	}

	function scrollUp(link){
		if($(".slide__item:first-child").hasClass("slide__item--active")){
			console.log("firstslide");
			return false;
		}
		else{
			$(".highlight__stick.highlight--active").parentsUntil(".slide__nav-list","li").prev().find('.slide__nav-button').click();
		}
	}

	// for Chrome, Safari, IE

	$(".slide__container").bind('mousewheel', function(e){
			if (!scrolled) {
					scrolled = true;
					if(e.originalEvent.wheelDelta < 0) {
						console.log("down");
						scrollDown();
					} else {
						console.log("up");
						scrollUp();
					}
			}
			clearTimeout(scrollTimeout);
		scrollTimeout = setTimeout(function(){
					scrolled = false;
		}, 300);
	});

	// for Firefox

	$(".slide__container").bind('DOMMouseScroll', function(e){
			if (!scrolled) {
					scrolled = true;
					if(e.originalEvent.detail < 0) {
							console.log("up");
						scrollUp();
					} else {
						console.log("down");
						scrollDown();
					}
			}
			clearTimeout(scrollTimeout);
		scrollTimeout = setTimeout(function(){
					scrolled = false;
		}, 300);
	});

	$(".logo__text").click(function(){
		$(".slide__item").removeClass("slide__item--active");
		$(".highlight__stick").removeClass("highlight--active");
			$(".slide__content").addClass("slide__content--down");

		$(".slide__item--slide1").addClass("slide__item--active");
		$(".highlight__stick-1").addClass("highlight--active");
			$(".content-1").removeClass("slide__content--down");
	});

		$(".slide__nav").hover(function(){
				$(".slide__nav-inner").addClass("slide__nav--active");
				}, function(){
				$(".slide__nav-inner").removeClass("slide__nav--active");
		});


		// mobile swipe

		var supportTouch = $.support.touch,
						scrollEvent = "touchmove scroll",
						touchStartEvent = supportTouch ? "touchstart" : "mousedown",
						touchStopEvent = supportTouch ? "touchend" : "mouseup",
						touchMoveEvent = supportTouch ? "touchmove" : "mousemove";
		$.event.special.swipeupdown = {
				setup: function() {
						var thisObject = this;
						var $this = $(thisObject);
						$this.bind(touchStartEvent, function(event) {
								var data = event.originalEvent.touches ?
												event.originalEvent.touches[ 0 ] :
												event,
												start = {
														time: (new Date).getTime(),
														coords: [ data.pageX, data.pageY ],
														origin: $(event.target)
												},
												stop;

								function moveHandler(event) {
										if (!start) {
												return;
										}
										var data = event.originalEvent.touches ?
														event.originalEvent.touches[ 0 ] :
														event;
										stop = {
												time: (new Date).getTime(),
												coords: [ data.pageX, data.pageY ]
										};

										// prevent scrolling
										if (Math.abs(start.coords[1] - stop.coords[1]) > 10) {
												event.preventDefault();
										}
								}
								$this
												.bind(touchMoveEvent, moveHandler)
												.one(touchStopEvent, function(event) {
										$this.unbind(touchMoveEvent, moveHandler);
										if (start && stop) {
												if (stop.time - start.time < 1000 &&
																Math.abs(start.coords[1] - stop.coords[1]) > 30 &&
																Math.abs(start.coords[0] - stop.coords[0]) < 75) {
														start.origin
																		.trigger("swipeupdown")
																		.trigger(start.coords[1] > stop.coords[1] ? "swipeup" : "swipedown");
												}
										}
										start = stop = undefined;
								});
						});
				}
		};
		$.each({
				swipedown: "swipeupdown",
				swipeup: "swipeupdown"
		}, function(event, sourceEvent){
				$.event.special[event] = {
						setup: function(){
								$(this).bind(sourceEvent, $.noop);
						}
				};
		});

	$('.slide__container').on('swipedown',function(){
				scrollUp();
	});
	$('.slide__container').on('swipeup',function(){
				scrollDown();
	});

	document.body.addEventListener('touchmove', function(event) {
		console.log(event.source);
			//if (event.source == document.body)
				event.preventDefault();
		}, false);

		window.onresize = function() {
			$(document.body).width(window.innerWidth).height(window.innerHeight);
		}

		$(function() {
			window.onresize();
		});

})(jQuery)