(function($) {
	var $document = $(document);
	var $window = $(window);
	var $body = $('body');

	function stringGen(len) {
		var text = '';
		var charset = 'abcdefghijklmnopqrstuvwxyz0123456789';
		for (var i = 0; i < len; i++)
			text += charset.charAt(Math.floor(Math.random() * charset.length));
		return text;
	}

	function BodyResizer() {
		$(document.body).width(window.innerWidth).height(window.innerHeight);
	}

	document.addEventListener( 'wpcf7invalid', function( event ) {
		$('.wpcf7-response-output').removeClass('wpcf7-response-output--spam wpcf7-response-output--failed wpcf7-response-output--success');
		$('.wpcf7-response-output').addClass('wpcf7-response-output--invalid');
	}, false);
	document.addEventListener( 'wpcf7spam', function( event ) {
		$('.wpcf7-response-output').removeClass('wpcf7-response-output--invalid wpcf7-response-output--failed wpcf7-response-output--success');
		$('.wpcf7-response-output').addClass('wpcf7-response-output--spam');
	}, false);
	document.addEventListener( 'wpcf7mailfailed', function( event ) {
		$('.wpcf7-response-output').removeClass('wpcf7-response-output--spam wpcf7-response-output--invalid wpcf7-response-output--success');
		$('.wpcf7-response-output').addClass('wpcf7-response-output--failed');
	}, false);
	document.addEventListener( 'wpcf7mailsent', function( event ) {
		$('.wpcf7-response-output').removeClass('wpcf7-response-output--spam wpcf7-response-output--failed wpcf7-response-output--invalid');
		$('.wpcf7-response-output').addClass('wpcf7-response-output--success');
	}, false);

  
	$document.ready(function(e) {
		BodyResizer();

		var links = [];

		function createLinks(index) {
			index++;

			return {
				name: '.button-' + index,
				classHover: '.highlight-' + index,
				textHover: '.text-' + index,
				slide: '.slide__item--slide' + index,
				highlightStick: '.highlight__stick-' + index,
				content: '.content-' + index
			};
		}

		$('.slide__nav-item').each(function(index) {
			links[index] = createLinks(index);
		});
	
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

		$('.slide__nav-button').on('click', function(e) {
			e.preventDefault();
		});
	
		function scrollDown(link){
			if($(".slide__item:last-child").hasClass("slide__item--active")){
				return false;
			} else{
				$(".highlight__stick.highlight--active").parentsUntil(".slide__nav-list","li").next().find('.slide__nav-button').click();
			}
		}
	
		function scrollUp(link){
			if($(".slide__item:first-child").hasClass("slide__item--active")){
				return false;
			} else{
				$(".highlight__stick.highlight--active").parentsUntil(".slide__nav-list","li").prev().find('.slide__nav-button').click();	
			}
		}
	
		// for Chrome, Safari, IE
	
		$(".slide__container").bind('mousewheel', function(e){
			if (!scrolled) {
				scrolled = true;

				if(e.originalEvent.wheelDelta < 0) {
				   scrollDown();
				} else {
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
					var data = event.originalEvent.touches ? event.originalEvent.touches[ 0 ] : event,
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
						
						var data = event.originalEvent.touches ? event.originalEvent.touches[ 0 ] : event;
						stop = {
							time: (new Date).getTime(),
							coords: [ data.pageX, data.pageY ]
						};
	
						// prevent scrolling
						if (Math.abs(start.coords[1] - stop.coords[1]) > 10) {
							event.preventDefault();
						}
					}

					$this.bind(touchMoveEvent, moveHandler).one(touchStopEvent, function(event) {
					$this.unbind(touchMoveEvent, moveHandler);
						if (start && stop) {
							if (stop.time - start.time < 1000 &&
								Math.abs(start.coords[1] - stop.coords[1]) > 30 &&
								Math.abs(start.coords[0] - stop.coords[0]) < 75) {
								start.origin.trigger("swipeupdown").trigger(start.coords[1] > stop.coords[1] ? "swipeup" : "swipedown");
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
			event.preventDefault();
		}, false);
	});

	$document.on('click', function(e) {

	});

	$window.on('load', function() {
		$('#status').fadeOut();
		$('#preloader').delay(350).fadeOut('slow');
	});

	$window.on('scroll', function() {

	});

	$window.resize(function() {
		BodyResizer();
	});

	$(window).scroll(function(){

	});
})(jQuery);