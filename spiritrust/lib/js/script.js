/*
 * *************************
 * SITE JS
 * REQUIRES: lib/js/jquery-1.12.2.min.js
 *           lib/js/jquery.easing.1.3.min.js
 * *************************
*/

jQuery(document).ready(function($) {
	/*
	 * *************************
	 * VARIABLES / COMMON FUNCTIONS
	 * *************************
	*/

	// VARS FOR GOOGLE MAPS
	var $maps = $('.gmaps');
	var maps = [];

	// YOUTUBE VIDEO PLAYER
	var $ytplayers = $('.ytplayer');

	// CREATE GLOBAL OBJECT
	window.SPIRI = {};

	/*
	 * *************************
	 * SET COOKIE
	 * *************************
	*/

	function setCookie(name,value,expiredays) {
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + expiredays);
		document.cookie = name + " = " + escape(value) + "; path=/" + ((expiredays==null) ? "" : "; expires = " + exdate.toGMTString());
	}

	/*
	 * *************************
	 * GET COOKIE
	 * *************************
	*/

	function getCookie(check_name) {
		var cookies = document.cookie.split( ';' );
		var tmpcookie = cookie_name = cookie_value = '';
		var cookie_found = false;

		for (var i = 0; i < cookies.length; i++ ) {
			tmpcookie = cookies[i].split( '=' );
			cookie_name = tmpcookie[0].replace(" ", "");

			if (cookie_name == check_name) {
				cookie_found = true;
				if (tmpcookie.length > 1) cookie_value = unescape(tmpcookie[1].replace(" ", ""));
			}
		}
		if (!cookie_found) {
			return '';
		} else {
			return cookie_value;
		}
	}

	/*
	 * *************************
	 * POPUP WINDOW
	 * *************************
	*/

	function popupCenter(url, title, w, h) {
		// FIX DUAL-SCREEN POSITION (MOST BROWSERS, FIREFOX)
		var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

		var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
		var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

		var left = Math.round(((width / 2) - (w / 2)) + dualScreenLeft);
		var top = Math.round(((height / 3) - (h / 3)) + dualScreenTop);

		var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

		// PUTS FOCUS ON POPUP WINDOW
		if (window.focus) {
			newWindow.focus();
		}
	};

	/*
	 * *************************
	 * FONT SIZE CHANGER
	 * *************************
	*/

	$('#font-size button').click(function (e) {
		$('#font-size button').removeClass('active');
		$(this).addClass('active');
		$('body').removeClass('body-small .body-medium body-large').addClass('body-' + $(this).attr('data-size'));

		// SET FONT SIZE COOKIE
		setCookie('spiritrust-font-size', $(this).attr('data-size'), 30);
	});

	// ON DOM READY, CHECK FOR COOKIE AND TRIGGER BUTTON CLICK TO UPDATE FONT SIZE (IF NOT MOBILE)
	if (getCookie('spiritrust-font-size') != '' && $('#navicon').css('display') == 'none') {
		$('#font-size button[data-size="' + getCookie('spiritrust-font-size') + '"]').trigger('click');
	}

	/*
	 * *************************
	 * WINDOW RESIZE (RUN WITHIN TIMEOUT)
	 * *************************
	*/

	$(window).bind('resize', function () {
		clearTimeout(this.id);
		this.id = setTimeout(function () {
			if ($(window).width() <= 980) {
				// RESET HOME HERO
				$('.hero-section').css({'left':'', 'z-index':''});
				$('.hero-photo').css('width','');
				$('.hero-content').css({'left':'', 'width':''});
			}
			$('.explore-hero.hide').trigger('click');

			// RESET SLIDESHOW
			if ($('.thumbs-list').length) {
				var $ss = $('.thumbs-list');

				$ss.each(function (idx, ele) {
					var $parent     = $(this).parent();
					var liWidth     = $(this).children('li').outerWidth(true);
					var liTotal     = $(this).children('li').length
					var listWidth   = liWidth * liTotal;
					var parentWidth = Number($parent.css('width').replace('px', ''));

					$(this).data({
						'idx': 1,
						'paneWidth'   : parentWidth,
						'itemsPerPane': Math.floor(parentWidth / liWidth),
						'paneTotal'   : Math.ceil((liWidth * liTotal) / parentWidth),
						'paneDiff'    : (Math.floor(parentWidth / liWidth) * (Math.ceil((liWidth * liTotal) / parentWidth))) - liTotal
					});

					var $slideshowWrapper = $ss.parents('.slideshow-wrapper');

					$slideshowWrapper.find('.prev-bottom a').addClass('inactive');
					if ($ss.data('paneTotal') > 1) {
						$slideshowWrapper.find('.next-bottom a').removeClass('inactive');
					} else {
						$slideshowWrapper.find('.next-bottom a').addClass('inactive');
					}
				});
				$ss.css('left', 0);
			}
		}, 100);
	});

	/*
	 * *************************
	 * MAIN NAVIGATION
	 * *************************
	*/

	$('#main-nav > li').hoverIntent(function() {
		if ($('#navicon').css('display') == 'none') {
			var $ddPhoto = $(this).find('.dropdown-photo');

			// LOAD IMAGE (IF DESKTOP AND IMAGE DOESN'T ALREADY EXIST)
			if (!$ddPhoto.children('img').length) {
				$ddPhoto.html('<img>').children('img').one('load').attr({
					'src': $ddPhoto.attr('data-src'),
					'alt': $ddPhoto.attr('data-alt')
				});
			}

			$(this).children('a').toggleClass('hover');
			$(this).children('.dropdown').slideDown(600, 'easeOutExpo');
			if ($(this).children('.dropdown').length) {
				$('#home-page-hero-wrapper, #page-hero-wrapper').toggleClass('dropdown-open');
			}
		}
	}, function() {
		if ($('#navicon').css('display') == 'none') {
			$(this).children('a').toggleClass('hover');
			$(this).children('.dropdown').slideUp(400, 'easeOutExpo');
			if ($(this).children('.dropdown').length) {
				$('#home-page-hero-wrapper, #page-hero-wrapper').toggleClass('dropdown-open');
			}
		}
	});

	/*
	 * *************************
	 * MAIN NAVIGATION (MOBILE)
	 * *************************
	*/

	$('#main-nav > li > a').click(function (e) {
		var $t = $(this);
		var $parent = $t.parent();

		if ($('#navicon').css('display') != 'none' && $parent.find('.dropdown').length) {
			if ($parent.hasClass('dropdown-mobile-open')) {
				$parent.children('.dropdown').slideUp(400, 'easeOutExpo', function () {
					$t.removeClass('mobile-active');
					$parent.removeClass('dropdown-mobile-open');
				});
			} else {
				$t.addClass('mobile-active');
				$parent.children('.dropdown').slideDown(600, 'easeOutExpo', function () {
					$parent.addClass('dropdown-mobile-open');
					$(this).css('display','');
				});
			}
			e.preventDefault();
		}
	});

	/*
	 * *************************
	 * NAVICON
	 * *************************
	*/

	$('#navicon').click(function (e) {
		if (!$(this).hasClass('animating')) {
			var $t = $(this);
			$t.addClass('animating');
			$t.toggleClass('open');

			// IF MOBILE ASIDE NAVIGATONI MENU IS OPENED, CLOSE IT
			if ($('#aside-nav-menu').hasClass('open')) {
				$('#aside-nav-menu').trigger('click');
			}

			$('#nav-wrapper').slideToggle(600, 'easeOutExpo', function () {
				if ($(this).css('display') == 'none') {
					$(this).css('display', '');
					$('#main-nav > li.dropdown-mobile-open > a').trigger('click');
				}
				$t.toggleClass('animating');
			});
		}
		e.preventDefault();
	});

	/*
	 * *************************
	 * ASIDE NAVIGATION MENU (MOBILE)
	 * *************************
	*/

	if ($('#aside-nav-menu').length) {
		$('#main-content').addClass('sticky-aside-nav-buffer');

		$('#aside-nav-menu').click(function (e) {
			var $t = $(this);

			$t.toggleClass('open');
			if ($t.hasClass('open')) {
				$t.children('.icon-angle-down').addClass('icon-angle-up').removeClass('icon-angle-down');
			} else {
				$t.children('.icon-angle-up').addClass('icon-angle-down').removeClass('icon-angle-up');
			}

			$('#aside-nav').slideToggle(600, 'easeOutExpo', function () {
				if ($(this).css('display') == 'none') {
					$(this).css('display', '');
				}
			});
			e.preventDefault();
		});
	}

	/*
	 * *************************
	 * HOME PAGE: SHOW HERO DETAILS
	 * *************************
	*/

	$('.explore-hero').click(function (e) {
		var $heroSection = $(this).parents('.hero-section');
		var heroWidth = 755;

		if ($(window).width() <= 1200) {
			heroWidth = 515;
		}

		if ($(this).hasClass('hide')) {
			$heroSection.find('.hide-hero-details').trigger('click');
		} else {
			$(this).addClass('hide').find('.txt').html('Hide <span class="icon icon-times-circle"></span>');

			$('.hero-section').css('z-index','1');
			$heroSection.css('z-index','2');

			$heroSection.stop().animate({ left: 0 }, 800, 'easeOutExpo');
			$heroSection.find('.hero-photo').stop().animate({ width: 450 }, 800, 'easeOutExpo');
			$heroSection.find('.hero-content').stop().animate({ left: 445, width: heroWidth }, 800, 'easeOutExpo');
		}
		e.preventDefault();
	});

	/*
	 * *************************
	 * HOME PAGE: HIDE HERO DETAILS
	 * *************************
	*/

	$('.hide-hero-details').click(function (e) {
		var $heroSection = $(this).parents('.hero-section');
		var heroIdx = ($heroSection.index()-1) * 100 / 4; // -1 is for the prev button element before the 4 divs
		var heroPhotoWidth = 300;
		var heroContentLeft = 295;

		if ($(window).width() <= 1200) {
			heroPhotoWidth = 240;
			heroContentLeft = 235;
		}

		$heroSection.find('.explore-hero').removeClass('hide').find('.txt').html('Explore <span class="icon icon-arrow-circle-right"></span>');

		$heroSection.stop().animate({ left: heroIdx + '%' }, 800, 'easeOutExpo');
		$heroSection.find('.hero-photo').stop().animate({ width: heroPhotoWidth }, 800, 'easeOutExpo');
		$heroSection.find('.hero-content').stop().animate({ left: heroContentLeft, width: 5 }, 800, 'easeOutExpo', function() {
			$heroSection.css({'left':'', 'z-index':''});
			$heroSection.find('.hero-photo').css('width','');
			$heroSection.find('.hero-content').css({'left':'', 'width':''});
		});

		e.preventDefault();
	});

	/*
	 * *************************
	 * HOME PAGE: HERO NAVIGATION (ON MOBILE)
	 * *************************
	*/

	$('.home-page-hero-nav > a').click(function (e) {
		var buttonType = $(this).attr('data-button');
		var current    = ($('.hero-section-active').length) ? $('.hero-section-active').index() : 1;
		var total      = $('.hero-section').length;
		var idx        = (current - 1 < 1) ? total : current - 1;

		if (buttonType == 'next') {
			idx = (current + 1 > total) ? 1 : current + 1;
		}
		$('.hero-section').removeClass('hero-section-active');
		$('.hero-section' + idx).addClass('hero-section-active');

		e.preventDefault();
	});

	/*
	 * *************************
	 * INTERIOR - LANDING PAGE (AND LANDING BANNER PAGE) HOVER
	 * *************************
	*/

	$('#landing-page-list li a, #landing-banner-page-list li a').hover(function() {
		if ($('#navicon').css('display') == 'none') {
			$(this).find('.overlay-wrapper').stop().animate( { top: 0 }, 600, 'easeOutExpo');
		}
	}, function() {
		if ($('#navicon').css('display') == 'none') {
			$(this).find('.overlay-wrapper').stop().animate( { top: '100%' }, 600, 'easeOutExpo');
		}
	});

	/*
	 * *************************
	 * INTERIOR - IMAGE/VIDEO SLIDESHOWS
	 * *************************
	*/

	if ($('.module-image-slideshow').length || $('.module-video-slideshow').length) {
		// SET .DATA() ATTRIBUTES FOR SLIDESHOWS
		$('.thumbs-list').each(function (idx, ele) {
			var $parent     = $(this).parent();
			var liWidth     = $(this).children('li').outerWidth(true);
			var liTotal     = $(this).children('li').length
			var listWidth   = liWidth * liTotal;
			var parentWidth = Number($parent.css('width').replace('px', ''));

			$(this).data({
				'idx': 1,
				'paneWidth'   : parentWidth,
				'itemsPerPane': Math.floor(parentWidth / liWidth),
				'paneTotal'   : Math.ceil((liWidth * liTotal) / parentWidth),
				'paneDiff'    : (Math.floor(parentWidth / liWidth) * (Math.ceil((liWidth * liTotal) / parentWidth))) - liTotal
			});
		});

		// IF WE DON'T HAVE MORE THAN ONE PANE, DISABLE NEXT BUTTON
		$('.slideshow-wrapper').each(function (idx, ele) {
			if (Number($(this).find('.thumbs-list').data('paneTotal')) <= 1) {
				$(this).find('.next-bottom a').addClass('inactive');
			}
		});

		// ANIMATE PLAYLIST
		function animateThumbsList(dir, $a) {
			// ADD ANIMATING CLASS TO PREVENT EXTRA CLICKS
			var $controlsParent = $a.parent().parent();
			var $ul = $controlsParent.find('.thumbs-list');
			var leftPos = (dir == 1) ? parseInt($ul.css('left')) - ($ul.children('li').outerWidth(true) * Number($ul.data('itemsPerPane'))) : parseInt($ul.css('left')) + ($ul.children('li').outerWidth(true) * Number($ul.data('itemsPerPane')));

			$ul.addClass('animating');

			if (Number($ul.data('idx')) == Number($ul.data('paneTotal')) && dir == 1) {
				// IF WE'RE ON THE LAST PANE AND IT ISN'T A "FULL PANE", ONLY ANIMATE TO THE LAST POSITION IN THAT PANE
				if (Number($ul.data('paneDiff')) > 0 && Number($ul.data('itemsPerPane')) > 1) {
					leftPos = leftPos + (Number($ul.data('paneDiff')) * $ul.children('li').outerWidth(true));
				}
			} else if ((Number($ul.data('idx'))+1) == Number($ul.data('paneTotal')) && dir == 0) {
				// IF WE'RE COMING BACK FROM THE LAST PANE AND THAT PANE WASN'T A "FULL PANE", ONLY ANIMATE THE PARTIAL PANE DISTANCE
				if (Number($ul.data('paneDiff')) > 0 && Number($ul.data('itemsPerPane')) > 1) {
					leftPos = leftPos - (Number($ul.data('paneDiff')) * $ul.children('li').outerWidth(true));
				}
			}
			$ul.stop().animate({ left: leftPos }, 600, 'easeInOutExpo', function () {
				if (Number($ul.data('idx')) == 1) {
					$controlsParent.find('.prev-bottom a').addClass('inactive');
					$controlsParent.find('.next-bottom a').removeClass('inactive');
				} else if (Number($ul.data('idx')) == Number($ul.data('paneTotal'))) {
					$controlsParent.find('.prev-bottom a').removeClass('inactive');
					$controlsParent.find('.next-bottom a').addClass('inactive');
				} else {
					$controlsParent.find('.prev-bottom a').removeClass('inactive');
					$controlsParent.find('.next-bottom a').removeClass('inactive');
				}
				$ul.removeClass('animating');
			});
		}

		// SLIDESHOW: PANE NAVIGATION
		$('.prev-bottom a, .next-bottom a').click(function (e) {
			var buttonType       = $(this).attr('data-button');
			var $thumbList       = $(this).parent().parent().find('.thumbs-list');
			var idx              = Number($thumbList.data('idx'));
			var eventActionText  = 'Previous Pane';
			var eventActionLabel = 'Pane #' + (idx - 1);

			if (!$(this).hasClass('inactive') && !$thumbList.hasClass('animating')) {
				if (buttonType == 'next') {
					// NEXT PANE
					eventActionText = 'Next Pane';
					eventActionLabel = 'Pane #' + (idx + 1);
					$thumbList.data('idx', idx + 1);
					animateThumbsList(1, $(this));
				} else {
					// PREV PANE
					$thumbList.data('idx', idx - 1);
					animateThumbsList(0, $(this));
				}

				// GA - TRACK EVENT
				ga('send', {
					hitType: 'event',
					eventCategory: 'Slideshow Navigation',
					eventAction: eventActionText,
					eventLabel: eventActionLabel
				});
			}
			e.preventDefault();
		});

		// IMAGE SLIDESHOW: PREV/NEXT BUTTONS
		$('.module-image-slideshow .prev-top a, .module-image-slideshow .next-top a').click(function (e) {
			var buttonType        = $(this).attr('data-button');
			var $slideshowWrapper = $(this).parents('.slideshow-wrapper');
			var liTotal           = $slideshowWrapper.find('.thumbs-list li').length;
			var liIndex           = $slideshowWrapper.find('.thumbs-list a.active').parent().index();
			var idx               = ((liIndex-1) < 0) ? liTotal-1 : liIndex - 1;
			var eventActionText   = 'Previous Image';

			if (buttonType == 'next') {
				// "NEXT" BUTTON CLICKED, UDPATE VARS (DEFAULTS TO "PREV" BUTTON)
				idx = ((liIndex+1) >= liTotal) ? 0 : liIndex + 1;
				eventActionText   = 'Next Image';
			}
			$slideshowWrapper.find('.thumbs-list > li:eq(' + idx + ') > a').trigger('click');

			// GA - TRACK EVENT
			ga('send', {
				hitType: 'event',
				eventCategory: 'Image Slideshow',
				eventAction: eventActionText,
				eventLabel: $slideshowWrapper.find('.thumbs-list > li:eq(' + idx + ') > a').prop('href')
			});
			e.preventDefault();
		});

		// IMAGE SLIDESHOW: PLAYLIST ITEM CLICK
		$('.images-list > li > a').click(function (e) {
			var $t = $(this);
			var $slideshowWrapper = $t.parents('.slideshow-wrapper');

			if (!$t.hasClass('active')) {
				$slideshowWrapper.find('.images-list > li > a').removeClass('active');
				$slideshowWrapper.find('.loader').show();

				/*
					LOAD PHOTO
					NOTE: It doesn't fire correctly in WebKit if the image src is set to the same src as before.
					This should not occur in production since all photos SHOULD be different.
				*/
				$slideshowWrapper.find('.slideshow-photo').one('load', function () {
					$t.addClass('active');
					$slideshowWrapper.find('.loader').hide();
					$slideshowWrapper.find('.current').text($t.parent().index()+1);
					$slideshowWrapper.find('.slideshow-caption').children('h3').text($t.children('img').attr('alt'));
					$slideshowWrapper.find('.slideshow-caption').children('p').text($t.children('span').text());
					$slideshowWrapper.find('.full-screen-photo').attr('href',$t.attr('href'));
				}).attr({ 'src': $t.attr('href') });
			}
			e.preventDefault();
		});

		// VIDEO SLIDESHOW: PREV/NEXT BUTTONS
		$('.module-video-slideshow .prev-top a, .module-video-slideshow .next-top a').click(function (e) {
			var buttonType        = $(this).attr('data-button');
			var $slideshowWrapper = $(this).parents('.slideshow-wrapper');
			var liTotal           = $slideshowWrapper.find('.thumbs-list li').length;
			var liIndex           = $slideshowWrapper.find('.thumbs-list a.active').parent().index();
			var idx               = ((liIndex-1) < 0) ? liTotal-1 : liIndex - 1;
			var eventActionText   = 'Previous Item';

			if (buttonType == 'next') {
				// "NEXT" BUTTON CLICKED, UDPATE VARS (DEFAULTS TO "PREV" BUTTON)
				idx = ((liIndex+1) >= liTotal) ? 0 : liIndex + 1;
				eventActionText   = 'Next Item';
			}

			// GA - TRACK EVENT
			ga('send', {
				hitType: 'event',
				eventCategory: 'Slideshow',
				eventAction: eventActionText,
				eventLabel: $slideshowWrapper.find('.thumbs-list > li:eq(' + idx + ') > a').prop('href')
			});
			e.preventDefault();

			var $a = $slideshowWrapper.find('.videos-list li:eq(' + idx + ') a');

			// RESET VIDEO STATUS
			$(this).parent().data({ status: '' })

			$slideshowWrapper.find('.loader').show();

			$slideshowWrapper.find('.thumbs-list > li > a').removeClass('active');

				$a.addClass('active');

				$slideshowWrapper.find('.slideshow-poster').one('load', function () {
					$slideshowWrapper.find('.loader').hide();
					$slideshowWrapper.find('.videos-module-poster > a').attr('href', $a.attr('href'));
				}).attr({ 'src': $a.attr('data-poster') });

			e.preventDefault();
		});

		// VIDEO SLIDESHOW: PLAYLIST ITEM CLICK
		$('.videos-list > li > a').click(function (e) {
			var $t = $(this);
			var $slideshowWrapper = $t.parents('.slideshow-wrapper');

			if (!$t.hasClass('active')) {
				$slideshowWrapper.find('.videos-list > li > a').removeClass('active');
				$t.addClass('active');

				// RESET VIDEO STATUS
				$slideshowWrapper.find('.video-wrapper').data({ status: '' })

				// UPDATE POSTER W/ NEW ATTRIBUTES
				$slideshowWrapper.find('.videos-module-poster a').attr('href', $t.attr('href'));
				$slideshowWrapper.find('.videos-module-poster img').attr('src', $t.attr('data-poster'));

				// TRIGGER POSTER CLICK
				$slideshowWrapper.find('.videos-module-poster a').trigger('click');
			}
			e.preventDefault();
		});

		// VIDEO SLIDESHOW: VIDEO POSTER CLICK
		$('.videos-module-poster > a').click(function (e) {
			if ($('#navicon').css('display') == 'none') {
				var idx = $(this).parent().parent().data('idx');
				if (typeof SPIRI.YTPLAYER.youtubeplayers == 'object') {
					if (typeof SPIRI.YTPLAYER.youtubeplayers[idx].loadVideoById == 'function') {
						// PAUSE ALL PLAYERS
						$.each(SPIRI.YTPLAYER.youtubeplayers, function (idx, ele) {
							if (typeof $(this)[0].pauseVideo == 'function') {
								$(this)[0].pauseVideo();
							}
						});

						SPIRI.YTPLAYER.youtubeplayers[idx].loadVideoById($(this).attr('href').split('?v=')[1]);
						$(this).parent().parent().find('.videos-module-mask').css('top',0);
						$(this).parent().fadeOut(300, function() {
							$(this).attr('style',''); // RESET display: none; FOR MOBILE
						});
					}
				}
				e.preventDefault();
			}
		});
	}

	/*
	 * *************************
	 * MODULE - EXPAND/COLLAPSE
	 * *************************
	*/

	$('.module-expand-collapse .ec-title a').click(function (e) {
		if (!$(this).hasClass('animating')) {
			var $t = $(this).toggleClass('open');
			var val = 'Expand';

			if ($t.hasClass('open')) {
				$t.attr('title','Hide Details').children('.icon-angle-down').addClass('icon-angle-up').removeClass('icon-angle-down');
			} else {
				$t.attr('title','Show Details').children('.icon-angle-up').addClass('icon-angle-down').removeClass('icon-angle-up');
				val = 'Collapse';
			}

			// GA - TRACK EVENT
			ga('send', {
				hitType: 'event',
				eventCategory: 'Expand/Collapse Module',
				eventAction: val,
				eventLabel: $(this).children('.txt').text()
			});

			$(this).addClass('animating');
			$(this).parent().next().slideToggle(400, 'easeOutExpo', function () {
				$t.toggleClass('animating');
			});
		}
		e.preventDefault();
	});

	/*
	 * *************************
	 * FILTER CAREER LISTING SEARCH RESULTS
	 * *************************
	*/

	if($('#search-filters').length) {
		//Checks to ensure that we're on the careers page.

		var locObj = {
			data:[]
		};

		if(locObj.data.length == 0) {
			//Load the javascript object to populate the search results distance filter.
			$.ajax({
				dataType: 'json',
				url: '/wp-content/themes/spiritrust/lib/inc/services.php'
			}).fail(function (data) {
				//fail
			}).done(function (data) {
				locObj.data = data;

				return locObj;
			});
		}

		var srtBy = '';
		$('input[name="sortby"]').change(function() {

			if($(this).val() == 'location') {
				//It's location.
				if(locObj.data.length == 0) {
					//for some reason the result set wasn't built.
					$.ajax({
						dataType: 'json',
						url: '/wp-content/themes/spiritrust/lib/inc/services.php'
					}).fail(function (data){
						//fail
					}).done(function (data){
						locObj.data = data;

						$('#zipcont').slideDown("fast");

						return locObj;
					});

				} else {
					//Location Results aren't 0
					$('#zipcont').slideDown("fast");
				}

			}else{
				//must be date.
				$('#zipcont').slideUp("fast",function() {
					$('#zipcode').val('');
				});
			}

		});

		$('#careerFilterForm').submit(function(event) {
			//If nothing is filled out prevent the form submission.

			//only need to worry about hooking into zip searches.
			if ($('#zipcode').val() > 0) {
				if (parseInt($('#zipcode').val().length) === 5 && $('#keyword').val().length === 0) {
					//5 digit zip code, run distance filter.

					//Geocode Zip - set 1 coords
					//URI https://maps.googleapis.com/maps/api/geocode/json?address=17101&sensor=false

					$.ajax({
						dataType: 'json',
						url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+$('#zipcode').val()+'&sensor=false'
					}).fail(function (data) {
						//fail
					}).done(function (data) {
						for( var i = 0; i < locObj.data.length; i++ ){
							//loop through location object and find your closest results.  sort object and display results.
							var p1 = new LatLon(locObj.data[i].geo.bounds.center.lat, locObj.data[i].geo.bounds.center.lng);
							var p2 = new LatLon(data.results[0].geometry.location.lat, data.results[0].geometry.location.lng);

							var d = p1.distanceTo(p2);

							var kmdist = (d/1000).toPrecision(4);
							var milesFrom = (kmdist * 0.621371).toPrecision(4);

							locObj.data[i].distanceRank = milesFrom;
						}
						locObj.data.sort(dynamicSort("distanceRank"));

						$('#post-content .post').addClass('hide-old');

						for (var i = 0; i < locObj.data.length; i++) {
							var str = locObj.data[i].jobType;
							str = str.replace(/(?:_| |\b)(\w)/g, function(str, p1) { return p1.toUpperCase()});

							$('#post-content').prepend(
								'<div class="post cf hide-loading">' +
								'<h2 class="title"><a href="' + locObj.data[i].url + '">'+ locObj.data[i].name +'</a></h2>' +
								'<p class="distance">Distance: '+ locObj.data[i].distanceRank +' mi' + '</p>' +
								'<p class="date">' + locObj.data[i].city +', '+ locObj.data[i].state + '<span class="positionType">' + str + '</span></p>' +
								'<p>'+ locObj.data[i].description +'</p>' +
								'<p class="cta">' +
								'<a href="'+ locObj.data[i].url + '" class="btn btn-green"><span class="bg"></span><span class="txt">Learn More<span class="icon icon-arrow-circle-right"></span></span></a>' +
								'</p>' +
								'</div>'
							);
						}

						$('#post-content .post.hide-old').fadeOut("fast", function() {
							$('#post-content .post.hide-loading').fadeIn("fast");
						});
					});

					//For now prevent anything from happening
					event.preventDefault();
				} else if (parseInt($('#zipcode').val().length) === 5 && $('#keyword').val().length > 0 ) {
					$('#careerFilterForm').submit();
				} else {
					//indicate error.
					$('#zipcode').css('outline','1px solid red');
					event.preventDefault();
				}
			}
		});

		/** Extend Number object with method to convert numeric degrees to radians */
		if (Number.prototype.toRadians === undefined) {
			Number.prototype.toRadians = function() { return this * Math.PI / 180; };
		}

		//SORT the distance results.
		function dynamicSort(property) {
			var sortOrder = 1;
			if(property[0] === "-") {
				sortOrder = -1;
				property = property.substr(1);
			}
			return function (a,b) {
				//reverse the positive and negative 1's, swapped because I was prepending in code above.
				var result = (a[property] < b[property]) ? 1 : (a[property] > b[property]) ? -1 : 0;
				return result * sortOrder;
			}
		}

		/**
		 * Creates a LatLon point on the earth's surface at the specified latitude / longitude.
		 *
		 * @constructor
		 * @param {number} lat - Latitude in degrees.
		 * @param {number} lon - Longitude in degrees.
		 *
		 * @example
		 *     var p1 = new LatLon(52.205, 0.119);
		 */
		function LatLon(lat, lon) {
			// allow instantiation without 'new'
			if (!(this instanceof LatLon)) return new LatLon(lat, lon);

			this.lat = Number(lat);
			this.lon = Number(lon);
		}

		/**
		 * Returns the distance from ‘this’ point to destination point (using haversine formula).
		 *
		 * @param   {LatLon} point - Latitude/longitude of destination point.
		 * @param   {number} [radius=6371e3] - (Mean) radius of earth (defaults to radius in metres).
		 * @returns {number} Distance between this point and destination point, in same units as radius.
		 *
		 * @example
		 *     var p1 = new LatLon(52.205, 0.119);
		 *     var p2 = new LatLon(48.857, 2.351);
		 *     var d = p1.distanceTo(p2); // 404.3 km
		 */
		LatLon.prototype.distanceTo = function(point, radius) {
			if (!(point instanceof LatLon)) throw new TypeError('point is not LatLon object');
			radius = (radius === undefined) ? 6371e3 : Number(radius);

			var R = radius;
			var φ1 = this.lat.toRadians(),  λ1 = this.lon.toRadians();
			var φ2 = point.lat.toRadians(), λ2 = point.lon.toRadians();
			var Δφ = φ2 - φ1;
			var Δλ = λ2 - λ1;

			var a = Math.sin(Δφ/2) * Math.sin(Δφ/2)
				  + Math.cos(φ1) * Math.cos(φ2)
				  * Math.sin(Δλ/2) * Math.sin(Δλ/2);
			var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
			var d = R * c;

			return d;
		};
	}

	/*
	 * *************************
	 * YOUTUBE VIDEO PLAYER
	 *   Requires: lib/js/jquery.simplemodal.js
	 * *************************
	*/

	if ($ytplayers.length || $("section a[data-behavior='modalize']").length) {
		// YOUTUBE VIDEO VIA MODAL
		$(document).on("click", "section a[data-behavior='modalize']", function (e) {
			// ONLY LOAD YOUTUBE VIDEO INTO MODAL IF '#navicon' IS NOT VISIBLE
			if ($('#navicon').css('display') == 'none') {
				var $a            = $(this);
				var target        = $a.attr('href').split('?v=')[1];
				var title         = ($a.data("title").length) ? $a.data("title") : '&nbsp';
				var $loader       = $('#simplemodal-loader');
				var $modalwrapper = $('<div id="simplemodal-wrapper"/>');
				var $modal        = $('<div class="modalcontent"/>');
				var $ytplayer     = $('<div id="ytplayer"/>');

				$modal.append('<h3>' + title + '</h3>');

				if(target.length) {
					$modal.append($ytplayer);
				} else {
					$modal.append('<p>Sorry, the video can not be viewed at this time</p>');
				}
				if (!$loader.length) {
					$('body').append($modalwrapper);
					$modalwrapper.append('<div id="simplemodal-loader"/>');
					$loader = $('#simplemodal-loader');
					$loader.hide();
				}
				$loader.fadeIn();

				$modal.modal({
					autoResize: true,
					autoPosition: true,
					containerId: 'youtube-video-modal',
					minWidth: '680',
					opacity: 90,
					overlayClose: true,
					appendTo: $modalwrapper,
					onOpen: function (dialog) {
						dialog.overlay.fadeIn(400, function () {
							$loader.fadeOut(325);
							dialog.data.show();
							dialog.container.fadeIn(400, function() {
								SPIRI.YTMODALPLAYER.init(target, title);
							});
						});
					},
					onClose: function (dialog) {
						dialog.data.fadeOut(200, function () {
							dialog.container.fadeOut(200, function () {
								dialog.overlay.fadeOut(200, function () {
									$.modal.close();
									$modalwrapper.remove();
								});
							});
						});
					}
				});
				e.preventDefault();
			}
		});

		//ADD YOUTUBE PLAYER STUFF TO SPIRI OBJECT
		window.SPIRI.YTPLAYER = {
			youtubeplayers: [],
			init: function () {
				// LOOP THROUGH ALL VIDEO PLAYERS
				$ytplayers.each(function (i) {
					var $ytplayer = $(this);
					var $vid = $ytplayer.parent().parent();
					var id ='ytplayer-' + i;
					var ytplayer;

					// REPLACE CONTAINER WITH YOUTUBE CONTAINER (W/ ID)
					$ytplayer.replaceWith('<div id="' + id + '"></div>');

					// SET INDEX, USED FOR CONTROLLING APPROPRIATE PLAYER WIHTIN SPIRI.YTPLAYER.youtubeplayers OBJECT
					$vid.data('idx',i);

					ytplayer = new YT.Player(
						id, {
							videoId: $vid.find('.videos-module-poster a').attr('href').split('?v=')[1],
							width: '100%',
							height: '100%',
							playerVars: { autoplay: 0, rel: 0, showinfo: 0 }
						}
					);
					ytplayer.addEventListener('onStateChange', function (e) {
						if (e.data == 1) {
							if ($vid.data('status') != 'started') {
								// GA - TRACK EVENT
								ga('send', {
									hitType: 'event',
									eventCategory: 'Video',
									eventAction: 'Play',
									eventLabel: $vid.parent().find('.videos-list li a.active').prop('href')
								});
								$vid.data({ status: 'started' })
							}
						} else if (e.data == 0) {
							// GA - TRACK EVENT
							ga('send', {
								hitType: 'event',
								eventCategory: 'Video',
								eventAction: 'End',
								eventLabel: $vid.parent().find('.videos-list li a.active').prop('href')
							});

							$vid.data({ status: 'ended' })
							$vid.find('.videos-module-mask').css('top','100%');
							$vid.find('.videos-module-poster').show(); // SHOW INTERIOR VIDEO PLAYLIST POSTER
						}
					});
					// ADD YOUTUBE PLAYER TO GLOBAL YTPLAYER ARRAY
					window.SPIRI.YTPLAYER.youtubeplayers.push(ytplayer);
				});
			}
		};

		window.SPIRI.YTMODALPLAYER = {
			init: function(target, title) {
				var $vid = $('#ytplayer');
				var ytplayer = new YT.Player('ytplayer', {
					videoId: target,
					width: '853',
					height: '480',
					playerVars: {
						'showinfo': 0,
						'autoplay': true,
						'rel': 0,
						'enablejsapi': 1
					}
				});
				ytplayer.addEventListener('onStateChange', function (e) {
					if (e.data == 1) {
						if ($vid.data('status') != 'started') {
							// GA - TRACK EVENT
							ga('send', {
								hitType: 'event',
								eventCategory: 'Video',
								eventAction: 'Play',
								eventLabel: 'https://www.youtube.com/watch?v=' + target
							});
							$vid.data({ status: 'started' })
						}
					} else if (e.data == 0) {
						// GA - TRACK EVENT
							ga('send', {
								hitType: 'event',
								eventCategory: 'Video',
								eventAction: 'End',
								eventLabel: 'https://www.youtube.com/watch?v=' + target
							});
							$vid.data({ status: 'ended' })

						// CLOSE MODAL
						$('.modalCloseImg').trigger('click');
					}
				});
			}
		};

		// LOAD GOOGLE YOUTUBE API
		$(window).load(function () {
			var script = document.createElement('script');
				script.src = 'https://www.youtube.com/iframe_api';
			document.body.appendChild(script);
		});

		// LOAD VIDEO PLAYERS WHEN YOUTUBE IS READY
		window.onYouTubePlayerAPIReady = function () {
			SPIRI.YTPLAYER.init();
		}
	}

	/*
	 * *************************
	 * GOOGLE MAPS
	 * *************************
	*/

	window.loadmaps = function() {
		var script;

		if (typeof google === 'object' && typeof google.maps === 'object') {
			setupmaps();
		} else {
			script = document.createElement('script');
			script.src = '//maps.googleapis.com/maps/api/js?key=' + $('body').attr('data-key') + '&v=3&callback=setupmaps';
			document.body.appendChild(script);
		}
	}

	window.setupmaps = function(scope) {
		var $parent = (scope === undefined) ? $('body') : $(scope);
		var mapOptions = {
			scrollwheel: false,
			zoom: 11,
			styles: [
				{
					"featureType":"administrative.province",
					"elementType":"all",
					"stylers":[
						{ "visibility":"on" }
					]
				},
				{
					"featureType":"administrative.province",
					"elementType":"labels",
					"stylers":[
						{ "visibility":"on" }
					]
				},
				{
					"featureType":"landscape",
					"elementType":"all",
					"stylers":[
						{ "saturation":"-100" },
						{ "lightness":"60" },
						{ "gamma":"1.00" }
					]
				},
				{
					"featureType":"landscape.man_made",
					"elementType":"geometry.fill",
					"stylers":[
						{ "visibility":"on" },
						{ "saturation":"0" },
						{ "lightness":"0" },
						{ "gamma":"1" }
					]
				},
				{
					"featureType":"landscape.man_made",
					"elementType":"geometry.stroke",
					"stylers":[
						{ "lightness":"0" },
						{ "weight":"1.48" }
					]
				},
				{
					"featureType":"landscape.man_made",
					"elementType":"labels.text.fill",
					"stylers":[
						{ "visibility":"on" }
					]
				},
				{
					"featureType":"poi",
					"elementType":"all",
					"stylers":[
						{ "visibility":"on" }
					]
				},
				{
					"featureType":"poi",
					"elementType":"geometry.fill",
					"stylers":[
						{ "visibility":"on" }
					]
				},
				{
					"featureType":"poi",
					"elementType":"labels.text",
					"stylers":[
						{ "visibility":"simplified" }
					]
				},
				{
					"featureType":"poi.business",
					"elementType":"geometry.fill",
					"stylers":[
						{ "visibility":"off" }
					]
				},
				{
					"featureType":"poi.government",
					"elementType":"geometry.fill",
					"stylers":[
						{ "visibility":"off" }
					]
				},
				{
					"featureType":"poi.medical",
					"elementType":"geometry.fill",
					"stylers":[
						{ "visibility":"simplified" }
					]
				},
				{
					"featureType":"poi.school",
					"elementType":"geometry.fill",
					"stylers":[
						{ "visibility":"off" }
					]
				},
				{
					"featureType":"poi.sports_complex",
					"elementType":"geometry.fill",
					"stylers":[
						{ "visibility":"off" }
					]
				},
				{
					"featureType":"road.highway",
					"elementType":"geometry.fill",
					"stylers":[
						{ "color":"#2a4f73" },
						{ "lightness":"40" }
					]
				},
				{
					"featureType":"road.highway",
					"elementType":"geometry.stroke",
					"stylers":[
						{ "visibility":"off" }
					]
				},
				{
					"featureType":"road.highway",
					"elementType":"labels.text.fill",
					"stylers":[
						{ "color":"#000000" }
					]
				},
				{
					"featureType":"road.highway",
					"elementType":"labels.text.stroke",
					"stylers":[
						{ "hue":"#ff0000" }
					]
				},
				{
					"featureType":"road.arterial",
					"elementType":"labels.text.fill",
					"stylers":[
						{ "color":"#2a4f73" },
						{ "saturation":"36" },
						{ "lightness":"-32" }
					]
				},
				{
					"featureType":"road.local",
					"elementType":"all",
					"stylers":[
						{ "saturation":-100 },
						{ "lightness":40 },
						{ "visibility":"on" }
					]
				},
				{
					"featureType":"transit",
					"elementType":"all",
					"stylers":[
						{ "saturation":-100 },
						{ "visibility":"simplified" }
					]
				},
				{
					"featureType":"water",
					"elementType":"all",
					"stylers":[
						{ "visibility":"on" },
						{ "lightness":30 }
					]
				}
			]
		};

		if ($parent.find('.map-wrapper').length) {
			$parent.find('.map-wrapper').each(function(i) {
				var map;
				var bounds = new google.maps.LatLngBounds();
				var $mapWrapper = $(this);
				var $map = $(this).find('.map-canvas');
				var id = 'map-canvas-' + i;
				var infoWindow = new google.maps.InfoWindow();
				var marker;

				// REPLACE MAP CANVAS WITH INTERACTIVE MAP W/ ID
				$map.replaceWith('<div id="' + id + '" class="map-canvas"></div>');

				map = new google.maps.Map(document.getElementById(id), mapOptions);

				// MULTIPLE MARKERS
				var markers = [];

				// INFO WINDOW CONTENT
				var infoWindowContent = [];
				var useLabels = $(this).find('.map-list').attr('data-use-label');

				// LOOP THROUGH LOCATIONS AND POPULATE markers[] and infoWindowContent[] ARRAYS
				$(this).find('.location').each(function(i, el) {
					var $t = $(this);
					var cta = $t.find('.cta').html();

					if (cta) {
						cta = '<p class="cta">' + cta + '</p>';
					} else {
						cta = '';
					}

					markers.push(
						[
							$t.find('.name').text(),
							$t.find('.lat').text(),
							$t.find('.lng').text(),
							$t.attr('data-label')
						]
					);
					infoWindowContent.push(
						[
							'<div class="info_content">' +
							'<h4>' + $t.find('.name').html() + '</h4>' +
							'<p>' + $t.find('.address').html() + '</p>' +
							cta +
							'</div>'
						]
					);
				});

				// LOOP THROUGH OUR ARRAY OF MARKERS & PLACE EACH ONE ON THE MAP
				for (var i = 0; i < markers.length; i++) {
					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(position);

					if (useLabels) {
						marker = new google.maps.Marker({
							position : position,
							map      : map,
							title    : markers[i][0],
							icon     : '/wp-content/themes/spiritrust/lib/img/map-icon-label.png',
							label    : {
								text: markers[i][3],
								color: 'white'
							}
						});
					} else {
						marker = new google.maps.Marker({
							position : position,
							map      : map,
							title    : markers[i][0],
							icon     : '/wp-content/themes/spiritrust/lib/img/map-icon.png'
						});
					}

					// ALLOW EACH MARKER TO HAVE AN INFO WINDOW
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infoWindow.setContent(infoWindowContent[i][0]);
							infoWindow.open(map, marker);
						}
					})(marker, i));
				}

				// AUTOMATICALLY CENTER THE MAP FITTING ALL MARKERS ON THE SCREEN
				map.fitBounds(bounds);
			});
		}
	}

	// LOAD GOOGLE MAPS API (IF .map-wrapper EXISTS)
	if ($('.map-wrapper').length) {
		loadmaps();
	}

	/*
	 * *************************
	 * SOCIAL SHARING BUTTONS
	 * *************************
	*/

	$('.social-links-list li a').bind('click', function(e) {
		var href = $(this).prop('href');

		if ($('#navicon').css('display') == 'none') {
			popupCenter(href, 'share' + $(this).prop('data-action'), 580, 470);

			// GA - TRACK SOCIAL EVENT
			ga('send', {
				hitType: 'social',
				socialNetwork: $(this).attr('data-network'),
				socialAction: $(this).attr('data-action'),
				socialTarget: href
			});

			e.preventDefault();
		}
	});

	/*
	 * *************************
	 * BIND GOOGLE TRACKING (EXTERNAL LINKS, MAILTO LINKS AND FILE DOWNLOADS USING CUSTOM NAMESPACE)
	 * *************************
	*/

	window.loadGoogleTrackingEvents = function(el) {
		var filetypes = /\.(pdf|doc*|xls*|ppt*)$/i;

		$(el).each(function() {
			var href = $(this).prop('href');
			var pageTracker = null;
			var linkerUrl = null;

			if (href && ( href.match(/^https?\:/i) ) && (!href.match(document.domain))) {
				// GOOGLE TRACK EXTERNAL EVENT
				$(this).unbind('click.spiri_ga').bind('click.spiri_ga', function (e) {
					ga('send', {
						hitType: 'event',
						eventCategory: 'External',
						eventAction: 'Click',
						eventLabel: href.replace(/^https?\:\/\//i, '')
					});
					if ($(this).attr('target') !== '_blank') {
						setTimeout('document.location = "' + href + '"', 100);
						e.preventDefault();
					}
				});
			} else if (href && href.match(/^mailto\:/i)) {
				// GOOGLE TRACK EMAIL EVENT
				$(this).unbind('click.spiri_ga').bind('click.spiri_ga', function () {
					ga('send', {
						hitType: 'event',
						eventCategory: 'Email',
						eventAction: 'Click',
						eventLabel: href.replace(/^mailto\:/i, '')
					});
				});
			} else if (href && href.match(filetypes)) {
				// GOOGLE TRACK DOWNLOAD EVENT
				$(this).unbind('click.spiri_ga').bind('click.spiri_ga', function (e) {
					var extension = (/[.]/.exec(href)) ? (/[^.]+$/.exec(href)) : undefined;

					ga('send', {
						hitType: 'event',
						eventCategory: 'Download',
						eventAction: 'Click-' + extension.toString().toUpperCase(),
						eventLabel: href
					});

					if ($(this).attr('target') == '_blank') {
						setTimeout("window.open('" + href + "')", 100);
					} else {
						setTimeout('document.location = "' + href + '"', 100);
					}
					e.preventDefault();
				});
			}
		});
	}

	// BIND TRACKING IF 'ga-exclude' CLASS IS NOT PRESENT
	//loadGoogleTrackingEvents('section a:not(.ga-exclude), #header a:not(.ga-exclude), #footer a:not(.ga-exclude)');
});
