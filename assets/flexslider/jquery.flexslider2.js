/*
 * jQuery flexslider2 v2.6.0
 * Copyright 2012 WooThemes
 * Contributing Author: Tyler Smith
 */
;
(function ($) {

  var focused = true;

  //flexslider2: Object Instance
  $.flexslider2 = function(el, options) {
    var slider2 = $(el);

    // making variables public
    slider2.vars = $.extend({}, $.flexslider2.defaults, options);

    var namespace = slider2.vars.namespace,
        msGesture = window.navigator && window.navigator.msPointerEnabled && window.MSGesture,
        touch = (( "ontouchstart" in window ) || msGesture || window.DocumentTouch && document instanceof DocumentTouch) && slider2.vars.touch,
        // depricating this idea, as devices are being released with both of these events
        eventType = "click touchend MSPointerUp keyup",
        watchedEvent = "",
        watchedEventClearTimer,
        vertical = slider2.vars.direction === "vertical",
        reverse = slider2.vars.reverse,
        carousel = (slider2.vars.itemWidth > 0),
        fade = slider2.vars.animation === "fade",
        asNav = slider2.vars.asNavFor !== "",
        methods = {};

    // Store a reference to the slider2 object
    $.data(el, "flexslider", slider2);

    // Private slider2 methods
    methods = {
      init: function() {
        slider2.animating = false;
        // Get current slide and make sure it is a number
        slider2.currentSlide = parseInt( ( slider2.vars.startAt ? slider2.vars.startAt : 0), 10 );
        if ( isNaN( slider2.currentSlide ) ) { slider2.currentSlide = 0; }
        slider2.animatingTo = slider2.currentSlide;
        slider2.atEnd = (slider2.currentSlide === 0 || slider2.currentSlide === slider2.last);
        slider2.containerSelector = slider2.vars.selector.substr(0,slider2.vars.selector.search(' '));
        slider2.slides = $(slider2.vars.selector, slider2);
        slider2.container = $(slider2.containerSelector, slider2);
        slider2.count = slider2.slides.length;
        // SYNC:
        slider2.syncExists = $(slider2.vars.sync).length > 0;
        // SLIDE:
        if (slider2.vars.animation === "slide") { slider2.vars.animation = "swing"; }
        slider2.prop = (vertical) ? "top" : "marginLeft";
        slider2.args = {};
        // SLIDESHOW:
        slider2.manualPause = false;
        slider2.stopped = false;
        //PAUSE WHEN INVISIBLE
        slider2.started = false;
        slider2.startTimeout = null;
        // TOUCH/USECSS:
        slider2.transitions = !slider2.vars.video && !fade && slider2.vars.useCSS && (function() {
          var obj = document.createElement('div'),
              props = ['perspectiveProperty', 'WebkitPerspective', 'MozPerspective', 'OPerspective', 'msPerspective'];
          for (var i in props) {
            if ( obj.style[ props[i] ] !== undefined ) {
              slider2.pfx = props[i].replace('Perspective','').toLowerCase();
              slider2.prop = "-" + slider2.pfx + "-transform";
              return true;
            }
          }
          return false;
        }());
        slider2.ensureAnimationEnd = '';
        // CONTROLSCONTAINER:
        if (slider2.vars.controlsContainer !== "") slider2.controlsContainer = $(slider2.vars.controlsContainer).length > 0 && $(slider2.vars.controlsContainer);
        // MANUAL:
        if (slider2.vars.manualControls !== "") slider2.manualControls = $(slider2.vars.manualControls).length > 0 && $(slider2.vars.manualControls);

        // CUSTOM DIRECTION NAV:
        if (slider2.vars.customDirectionNav !== "") slider2.customDirectionNav = $(slider2.vars.customDirectionNav).length === 2 && $(slider2.vars.customDirectionNav);

        // RANDOMIZE:
        if (slider2.vars.randomize) {
          slider2.slides.sort(function() { return (Math.round(Math.random())-0.5); });
          slider2.container.empty().append(slider2.slides);
        }

        slider2.doMath();

        // INIT
        slider2.setup("init");

        // CONTROLNAV:
        if (slider2.vars.controlNav) { methods.controlNav.setup(); }

        // DIRECTIONNAV:
        if (slider2.vars.directionNav) { methods.directionNav.setup(); }

        // KEYBOARD:
        if (slider2.vars.keyboard && ($(slider2.containerSelector).length === 1 || slider2.vars.multipleKeyboard)) {
          $(document).bind('keyup', function(event) {
            var keycode = event.keyCode;
            if (!slider2.animating && (keycode === 39 || keycode === 37)) {
              var target = (keycode === 39) ? slider2.getTarget('next') :
                           (keycode === 37) ? slider2.getTarget('prev') : false;
              slider2.flexAnimate(target, slider2.vars.pauseOnAction);
            }
          });
        }
        // MOUSEWHEEL:
        if (slider2.vars.mousewheel) {
          slider2.bind('mousewheel', function(event, delta, deltaX, deltaY) {
            event.preventDefault();
            var target = (delta < 0) ? slider2.getTarget('next') : slider2.getTarget('prev');
            slider2.flexAnimate(target, slider2.vars.pauseOnAction);
          });
        }

        // PAUSEPLAY
        if (slider2.vars.pausePlay) { methods.pausePlay.setup(); }

        //PAUSE WHEN INVISIBLE
        if (slider2.vars.slideshow && slider2.vars.pauseInvisible) { methods.pauseInvisible.init(); }

        // SLIDSESHOW
        if (slider2.vars.slideshow) {
          if (slider2.vars.pauseOnHover) {
            slider2.hover(function() {
              if (!slider2.manualPlay && !slider2.manualPause) { slider2.pause(); }
            }, function() {
              if (!slider2.manualPause && !slider2.manualPlay && !slider2.stopped) { slider2.play(); }
            });
          }
          // initialize animation
          //If we're visible, or we don't use PageVisibility API
          if(!slider2.vars.pauseInvisible || !methods.pauseInvisible.isHidden()) {
            (slider2.vars.initDelay > 0) ? slider2.startTimeout = setTimeout(slider2.play, slider2.vars.initDelay) : slider2.play();
          }
        }

        // ASNAV:
        if (asNav) { methods.asNav.setup(); }

        // TOUCH
        if (touch && slider2.vars.touch) { methods.touch(); }

        // FADE&&SMOOTHHEIGHT || SLIDE:
        if (!fade || (fade && slider2.vars.smoothHeight)) { $(window).bind("resize orientationchange focus", methods.resize); }

        slider2.find("img").attr("draggable", "false");

        // API: start() Callback
        setTimeout(function(){
          slider2.vars.start(slider2);
        }, 200);
      },
      asNav: {
        setup: function() {
          slider2.asNav = true;
          slider2.animatingTo = Math.floor(slider2.currentSlide/slider2.move);
          slider2.currentItem = slider2.currentSlide;
          slider2.slides.removeClass(namespace + "active-slide").eq(slider2.currentItem).addClass(namespace + "active-slide");
          if(!msGesture){
              slider2.slides.on(eventType, function(e){
                e.preventDefault();
                var $slide = $(this),
                    target = $slide.index();
                var posFromLeft = $slide.offset().left - $(slider2).scrollLeft(); // Find position of slide relative to left of slider2 container
                if( posFromLeft <= 0 && $slide.hasClass( namespace + 'active-slide' ) ) {
                  slider2.flexAnimate(slider2.getTarget("prev"), true);
                } else if (!$(slider2.vars.asNavFor).data('flexslider2').animating && !$slide.hasClass(namespace + "active-slide")) {
                  slider2.direction = (slider2.currentItem < target) ? "next" : "prev";
                  slider2.flexAnimate(target, slider2.vars.pauseOnAction, false, true, true);
                }
              });
          }else{
              el._slider = slider2;
              slider2.slides.each(function (){
                  var that = this;
                  that._gesture = new MSGesture();
                  that._gesture.target = that;
                  that.addEventListener("MSPointerDown", function (e){
                      e.preventDefault();
                      if(e.currentTarget._gesture) {
                        e.currentTarget._gesture.addPointer(e.pointerId);
                      }
                  }, false);
                  that.addEventListener("MSGestureTap", function (e){
                      e.preventDefault();
                      var $slide = $(this),
                          target = $slide.index();
                      if (!$(slider2.vars.asNavFor).data('flexslider2').animating && !$slide.hasClass('active')) {
                          slider2.direction = (slider2.currentItem < target) ? "next" : "prev";
                          slider2.flexAnimate(target, slider2.vars.pauseOnAction, false, true, true);
                      }
                  });
              });
          }
        }
      },
      controlNav: {
        setup: function() {
          if (!slider2.manualControls) {
            methods.controlNav.setupPaging();
          } else { // MANUALCONTROLS:
            methods.controlNav.setupManual();
          }
        },
        setupPaging: function() {
          var type = (slider2.vars.controlNav === "thumbnails") ? 'control-thumbs' : 'control-paging',
              j = 1,
              item,
              slide;

          slider2.controlNavScaffold = $('<ol class="'+ namespace + 'control-nav ' + namespace + type + '"></ol>');

          if (slider2.pagingCount > 1) {
            for (var i = 0; i < slider2.pagingCount; i++) {
              slide = slider2.slides.eq(i);
              if ( undefined === slide.attr( 'data-thumb-alt' ) ) { slide.attr( 'data-thumb-alt', '' ); }
              altText = ( '' !== slide.attr( 'data-thumb-alt' ) ) ? altText = ' alt="' + slide.attr( 'data-thumb-alt' ) + '"' : '';
              item = (slider2.vars.controlNav === "thumbnails") ? '<img src="' + slide.attr( 'data-thumb' ) + '"' + altText + '/>' : '<a href="#">' + j + '</a>';
              if ( 'thumbnails' === slider2.vars.controlNav && true === slider2.vars.thumbCaptions ) {
                var captn = slide.attr( 'data-thumbcaption' );
                if ( '' !== captn && undefined !== captn ) { item += '<span class="' + namespace + 'caption">' + captn + '</span>'; }
              }
              slider2.controlNavScaffold.append('<li>' + item + '</li>');
              j++;
            }
          }

          // CONTROLSCONTAINER:
          (slider2.controlsContainer) ? $(slider2.controlsContainer).append(slider2.controlNavScaffold) : slider2.append(slider2.controlNavScaffold);
          methods.controlNav.set();

          methods.controlNav.active();

          slider2.controlNavScaffold.delegate('a, img', eventType, function(event) {
            event.preventDefault();

            if (watchedEvent === "" || watchedEvent === event.type) {
              var $this = $(this),
                  target = slider2.controlNav.index($this);

              if (!$this.hasClass(namespace + 'active')) {
                slider2.direction = (target > slider2.currentSlide) ? "next" : "prev";
                slider2.flexAnimate(target, slider2.vars.pauseOnAction);
              }
            }

            // setup flags to prevent event duplication
            if (watchedEvent === "") {
              watchedEvent = event.type;
            }
            methods.setToClearWatchedEvent();

          });
        },
        setupManual: function() {
          slider2.controlNav = slider2.manualControls;
          methods.controlNav.active();

          slider2.controlNav.bind(eventType, function(event) {
            event.preventDefault();

            if (watchedEvent === "" || watchedEvent === event.type) {
              var $this = $(this),
                  target = slider2.controlNav.index($this);

              if (!$this.hasClass(namespace + 'active')) {
                (target > slider2.currentSlide) ? slider2.direction = "next" : slider2.direction = "prev";
                slider2.flexAnimate(target, slider2.vars.pauseOnAction);
              }
            }

            // setup flags to prevent event duplication
            if (watchedEvent === "") {
              watchedEvent = event.type;
            }
            methods.setToClearWatchedEvent();
          });
        },
        set: function() {
          var selector = (slider2.vars.controlNav === "thumbnails") ? 'img' : 'a';
          slider2.controlNav = $('.' + namespace + 'control-nav li ' + selector, (slider2.controlsContainer) ? slider2.controlsContainer : slider2);
        },
        active: function() {
          slider2.controlNav.removeClass(namespace + "active").eq(slider2.animatingTo).addClass(namespace + "active");
        },
        update: function(action, pos) {
          if (slider2.pagingCount > 1 && action === "add") {
            slider2.controlNavScaffold.append($('<li><a href="#">' + slider2.count + '</a></li>'));
          } else if (slider2.pagingCount === 1) {
            slider2.controlNavScaffold.find('li').remove();
          } else {
            slider2.controlNav.eq(pos).closest('li').remove();
          }
          methods.controlNav.set();
          (slider2.pagingCount > 1 && slider2.pagingCount !== slider2.controlNav.length) ? slider2.update(pos, action) : methods.controlNav.active();
        }
      },
      directionNav: {
        setup: function() {
          var directionNavScaffold = $('<ul class="' + namespace + 'direction-nav"><li class="' + namespace + 'nav-prev"><a class="' + namespace + 'prev" href="#">' + slider2.vars.prevText + '</a></li><li class="' + namespace + 'nav-next"><a class="' + namespace + 'next" href="#">' + slider2.vars.nextText + '</a></li></ul>');

          // CUSTOM DIRECTION NAV:
          if (slider2.customDirectionNav) {
            slider2.directionNav = slider2.customDirectionNav;
          // CONTROLSCONTAINER:
          } else if (slider2.controlsContainer) {
            $(slider2.controlsContainer).append(directionNavScaffold);
            slider2.directionNav = $('.' + namespace + 'direction-nav li a', slider2.controlsContainer);
          } else {
            slider2.append(directionNavScaffold);
            slider2.directionNav = $('.' + namespace + 'direction-nav li a', slider2);
          }

          methods.directionNav.update();

          slider2.directionNav.bind(eventType, function(event) {
            event.preventDefault();
            var target;

            if (watchedEvent === "" || watchedEvent === event.type) {
              target = ($(this).hasClass(namespace + 'next')) ? slider2.getTarget('next') : slider2.getTarget('prev');
              slider2.flexAnimate(target, slider2.vars.pauseOnAction);
            }

            // setup flags to prevent event duplication
            if (watchedEvent === "") {
              watchedEvent = event.type;
            }
            methods.setToClearWatchedEvent();
          });
        },
        update: function() {
          var disabledClass = namespace + 'disabled';
          if (slider2.pagingCount === 1) {
            slider2.directionNav.addClass(disabledClass).attr('tabindex', '-1');
          } else if (!slider2.vars.animationLoop) {
            if (slider2.animatingTo === 0) {
              slider2.directionNav.removeClass(disabledClass).filter('.' + namespace + "prev").addClass(disabledClass).attr('tabindex', '-1');
            } else if (slider2.animatingTo === slider2.last) {
              slider2.directionNav.removeClass(disabledClass).filter('.' + namespace + "next").addClass(disabledClass).attr('tabindex', '-1');
            } else {
              slider2.directionNav.removeClass(disabledClass).removeAttr('tabindex');
            }
          } else {
            slider2.directionNav.removeClass(disabledClass).removeAttr('tabindex');
          }
        }
      },
      pausePlay: {
        setup: function() {
          var pausePlayScaffold = $('<div class="' + namespace + 'pauseplay"><a href="#"></a></div>');

          // CONTROLSCONTAINER:
          if (slider2.controlsContainer) {
            slider2.controlsContainer.append(pausePlayScaffold);
            slider2.pausePlay = $('.' + namespace + 'pauseplay a', slider2.controlsContainer);
          } else {
            slider2.append(pausePlayScaffold);
            slider2.pausePlay = $('.' + namespace + 'pauseplay a', slider2);
          }

          methods.pausePlay.update((slider2.vars.slideshow) ? namespace + 'pause' : namespace + 'play');

          slider2.pausePlay.bind(eventType, function(event) {
            event.preventDefault();

            if (watchedEvent === "" || watchedEvent === event.type) {
              if ($(this).hasClass(namespace + 'pause')) {
                slider2.manualPause = true;
                slider2.manualPlay = false;
                slider2.pause();
              } else {
                slider2.manualPause = false;
                slider2.manualPlay = true;
                slider2.play();
              }
            }

            // setup flags to prevent event duplication
            if (watchedEvent === "") {
              watchedEvent = event.type;
            }
            methods.setToClearWatchedEvent();
          });
        },
        update: function(state) {
          (state === "play") ? slider2.pausePlay.removeClass(namespace + 'pause').addClass(namespace + 'play').html(slider2.vars.playText) : slider2.pausePlay.removeClass(namespace + 'play').addClass(namespace + 'pause').html(slider2.vars.pauseText);
        }
      },
      touch: function() {
        var startX,
          startY,
          offset,
          cwidth,
          dx,
          startT,
          onTouchStart,
          onTouchMove,
          onTouchEnd,
          scrolling = false,
          localX = 0,
          localY = 0,
          accDx = 0;

        if(!msGesture){
            onTouchStart = function(e) {
              if (slider2.animating) {
                e.preventDefault();
              } else if ( ( window.navigator.msPointerEnabled ) || e.touches.length === 1 ) {
                slider2.pause();
                // CAROUSEL:
                cwidth = (vertical) ? slider2.h : slider2. w;
                startT = Number(new Date());
                // CAROUSEL:

                // Local vars for X and Y points.
                localX = e.touches[0].pageX;
                localY = e.touches[0].pageY;

                offset = (carousel && reverse && slider2.animatingTo === slider2.last) ? 0 :
                         (carousel && reverse) ? slider2.limit - (((slider2.itemW + slider2.vars.itemMargin) * slider2.move) * slider2.animatingTo) :
                         (carousel && slider2.currentSlide === slider2.last) ? slider2.limit :
                         (carousel) ? ((slider2.itemW + slider2.vars.itemMargin) * slider2.move) * slider2.currentSlide :
                         (reverse) ? (slider2.last - slider2.currentSlide + slider2.cloneOffset) * cwidth : (slider2.currentSlide + slider2.cloneOffset) * cwidth;
                startX = (vertical) ? localY : localX;
                startY = (vertical) ? localX : localY;

                el.addEventListener('touchmove', onTouchMove, false);
                el.addEventListener('touchend', onTouchEnd, false);
              }
            };

            onTouchMove = function(e) {
              // Local vars for X and Y points.

              localX = e.touches[0].pageX;
              localY = e.touches[0].pageY;

              dx = (vertical) ? startX - localY : startX - localX;
              scrolling = (vertical) ? (Math.abs(dx) < Math.abs(localX - startY)) : (Math.abs(dx) < Math.abs(localY - startY));

              var fxms = 500;

              if ( ! scrolling || Number( new Date() ) - startT > fxms ) {
                e.preventDefault();
                if (!fade && slider2.transitions) {
                  if (!slider2.vars.animationLoop) {
                    dx = dx/((slider2.currentSlide === 0 && dx < 0 || slider2.currentSlide === slider2.last && dx > 0) ? (Math.abs(dx)/cwidth+2) : 1);
                  }
                  slider2.setProps(offset + dx, "setTouch");
                }
              }
            };

            onTouchEnd = function(e) {
              // finish the touch by undoing the touch session
              el.removeEventListener('touchmove', onTouchMove, false);

              if (slider2.animatingTo === slider2.currentSlide && !scrolling && !(dx === null)) {
                var updateDx = (reverse) ? -dx : dx,
                    target = (updateDx > 0) ? slider2.getTarget('next') : slider2.getTarget('prev');

                if (slider2.canAdvance(target) && (Number(new Date()) - startT < 550 && Math.abs(updateDx) > 50 || Math.abs(updateDx) > cwidth/2)) {
                  slider2.flexAnimate(target, slider2.vars.pauseOnAction);
                } else {
                  if (!fade) { slider2.flexAnimate(slider2.currentSlide, slider2.vars.pauseOnAction, true); }
                }
              }
              el.removeEventListener('touchend', onTouchEnd, false);

              startX = null;
              startY = null;
              dx = null;
              offset = null;
            };

            el.addEventListener('touchstart', onTouchStart, false);
        }else{
            el.style.msTouchAction = "none";
            el._gesture = new MSGesture();
            el._gesture.target = el;
            el.addEventListener("MSPointerDown", onMSPointerDown, false);
            el._slider = slider2;
            el.addEventListener("MSGestureChange", onMSGestureChange, false);
            el.addEventListener("MSGestureEnd", onMSGestureEnd, false);

            function onMSPointerDown(e){
                e.stopPropagation();
                if (slider2.animating) {
                    e.preventDefault();
                }else{
                    slider2.pause();
                    el._gesture.addPointer(e.pointerId);
                    accDx = 0;
                    cwidth = (vertical) ? slider2.h : slider2. w;
                    startT = Number(new Date());
                    // CAROUSEL:

                    offset = (carousel && reverse && slider2.animatingTo === slider2.last) ? 0 :
                        (carousel && reverse) ? slider2.limit - (((slider2.itemW + slider2.vars.itemMargin) * slider2.move) * slider2.animatingTo) :
                            (carousel && slider2.currentSlide === slider2.last) ? slider2.limit :
                                (carousel) ? ((slider2.itemW + slider2.vars.itemMargin) * slider2.move) * slider2.currentSlide :
                                    (reverse) ? (slider2.last - slider2.currentSlide + slider2.cloneOffset) * cwidth : (slider2.currentSlide + slider2.cloneOffset) * cwidth;
                }
            }

            function onMSGestureChange(e) {
                e.stopPropagation();
                var slider2 = e.target._slider;
                if(!slider2){
                    return;
                }
                var transX = -e.translationX,
                    transY = -e.translationY;

                //Accumulate translations.
                accDx = accDx + ((vertical) ? transY : transX);
                dx = accDx;
                scrolling = (vertical) ? (Math.abs(accDx) < Math.abs(-transX)) : (Math.abs(accDx) < Math.abs(-transY));

                if(e.detail === e.MSGESTURE_FLAG_INERTIA){
                    setImmediate(function (){
                        el._gesture.stop();
                    });

                    return;
                }

                if (!scrolling || Number(new Date()) - startT > 500) {
                    e.preventDefault();
                    if (!fade && slider2.transitions) {
                        if (!slider2.vars.animationLoop) {
                            dx = accDx / ((slider2.currentSlide === 0 && accDx < 0 || slider2.currentSlide === slider2.last && accDx > 0) ? (Math.abs(accDx) / cwidth + 2) : 1);
                        }
                        slider2.setProps(offset + dx, "setTouch");
                    }
                }
            }

            function onMSGestureEnd(e) {
                e.stopPropagation();
                var slider2 = e.target._slider;
                if(!slider2){
                    return;
                }
                if (slider2.animatingTo === slider2.currentSlide && !scrolling && !(dx === null)) {
                    var updateDx = (reverse) ? -dx : dx,
                        target = (updateDx > 0) ? slider2.getTarget('next') : slider2.getTarget('prev');

                    if (slider2.canAdvance(target) && (Number(new Date()) - startT < 550 && Math.abs(updateDx) > 50 || Math.abs(updateDx) > cwidth/2)) {
                        slider2.flexAnimate(target, slider2.vars.pauseOnAction);
                    } else {
                        if (!fade) { slider2.flexAnimate(slider2.currentSlide, slider2.vars.pauseOnAction, true); }
                    }
                }

                startX = null;
                startY = null;
                dx = null;
                offset = null;
                accDx = 0;
            }
        }
      },
      resize: function() {
        if (!slider2.animating && slider2.is(':visible')) {
          if (!carousel) { slider2.doMath(); }

          if (fade) {
            // SMOOTH HEIGHT:
            methods.smoothHeight();
          } else if (carousel) { //CAROUSEL:
            slider2.slides.width(slider2.computedW);
            slider2.update(slider2.pagingCount);
            slider2.setProps();
          }
          else if (vertical) { //VERTICAL:
            slider2.viewport.height(slider2.h);
            slider2.setProps(slider2.h, "setTotal");
          } else {
            // SMOOTH HEIGHT:
            if (slider2.vars.smoothHeight) { methods.smoothHeight(); }
            slider2.newSlides.width(slider2.computedW);
            slider2.setProps(slider2.computedW, "setTotal");
          }
        }
      },
      smoothHeight: function(dur) {
        if (!vertical || fade) {
          var $obj = (fade) ? slider2 : slider2.viewport;
          (dur) ? $obj.animate({"height": slider2.slides.eq(slider2.animatingTo).height()}, dur) : $obj.height(slider2.slides.eq(slider2.animatingTo).height());
        }
      },
      sync: function(action) {
        var $obj = $(slider2.vars.sync).data("flexslider2"),
            target = slider2.animatingTo;

        switch (action) {
          case "animate": $obj.flexAnimate(target, slider2.vars.pauseOnAction, false, true); break;
          case "play": if (!$obj.playing && !$obj.asNav) { $obj.play(); } break;
          case "pause": $obj.pause(); break;
        }
      },
      uniqueID: function($clone) {
        // Append _clone to current level and children elements with id attributes
        $clone.filter( '[id]' ).add($clone.find( '[id]' )).each(function() {
          var $this = $(this);
          $this.attr( 'id', $this.attr( 'id' ) + '_clone' );
        });
        return $clone;
      },
      pauseInvisible: {
        visProp: null,
        init: function() {
          var visProp = methods.pauseInvisible.getHiddenProp();
          if (visProp) {
            var evtname = visProp.replace(/[H|h]idden/,'') + 'visibilitychange';
            document.addEventListener(evtname, function() {
              if (methods.pauseInvisible.isHidden()) {
                if(slider2.startTimeout) {
                  clearTimeout(slider2.startTimeout); //If clock is ticking, stop timer and prevent from starting while invisible
                } else {
                  slider2.pause(); //Or just pause
                }
              }
              else {
                if(slider2.started) {
                  slider2.play(); //Initiated before, just play
                } else {
                  if (slider2.vars.initDelay > 0) {
                    setTimeout(slider2.play, slider2.vars.initDelay);
                  } else {
                    slider2.play(); //Didn't init before: simply init or wait for it
                  }
                }
              }
            });
          }
        },
        isHidden: function() {
          var prop = methods.pauseInvisible.getHiddenProp();
          if (!prop) {
            return false;
          }
          return document[prop];
        },
        getHiddenProp: function() {
          var prefixes = ['webkit','moz','ms','o'];
          // if 'hidden' is natively supported just return it
          if ('hidden' in document) {
            return 'hidden';
          }
          // otherwise loop over all the known prefixes until we find one
          for ( var i = 0; i < prefixes.length; i++ ) {
              if ((prefixes[i] + 'Hidden') in document) {
                return prefixes[i] + 'Hidden';
              }
          }
          // otherwise it's not supported
          return null;
        }
      },
      setToClearWatchedEvent: function() {
        clearTimeout(watchedEventClearTimer);
        watchedEventClearTimer = setTimeout(function() {
          watchedEvent = "";
        }, 3000);
      }
    };

    // public methods
    slider2.flexAnimate = function(target, pause, override, withSync, fromNav) {
      if (!slider2.vars.animationLoop && target !== slider2.currentSlide) {
        slider2.direction = (target > slider2.currentSlide) ? "next" : "prev";
      }

      if (asNav && slider2.pagingCount === 1) slider2.direction = (slider2.currentItem < target) ? "next" : "prev";

      if (!slider2.animating && (slider2.canAdvance(target, fromNav) || override) && slider2.is(":visible")) {
        if (asNav && withSync) {
          var master = $(slider2.vars.asNavFor).data('flexslider2');
          slider2.atEnd = target === 0 || target === slider2.count - 1;
          master.flexAnimate(target, true, false, true, fromNav);
          slider2.direction = (slider2.currentItem < target) ? "next" : "prev";
          master.direction = slider2.direction;

          if (Math.ceil((target + 1)/slider2.visible) - 1 !== slider2.currentSlide && target !== 0) {
            slider2.currentItem = target;
            slider2.slides.removeClass(namespace + "active-slide").eq(target).addClass(namespace + "active-slide");
            target = Math.floor(target/slider2.visible);
          } else {
            slider2.currentItem = target;
            slider2.slides.removeClass(namespace + "active-slide").eq(target).addClass(namespace + "active-slide");
            return false;
          }
        }

        slider2.animating = true;
        slider2.animatingTo = target;

        // SLIDESHOW:
        if (pause) { slider2.pause(); }

        // API: before() animation Callback
        slider2.vars.before(slider2);

        // SYNC:
        if (slider2.syncExists && !fromNav) { methods.sync("animate"); }

        // CONTROLNAV
        if (slider2.vars.controlNav) { methods.controlNav.active(); }

        // !CAROUSEL:
        // CANDIDATE: slide active class (for add/remove slide)
        if (!carousel) { slider2.slides.removeClass(namespace + 'active-slide').eq(target).addClass(namespace + 'active-slide'); }

        // INFINITE LOOP:
        // CANDIDATE: atEnd
        slider2.atEnd = target === 0 || target === slider2.last;

        // DIRECTIONNAV:
        if (slider2.vars.directionNav) { methods.directionNav.update(); }

        if (target === slider2.last) {
          // API: end() of cycle Callback
          slider2.vars.end(slider2);
          // SLIDESHOW && !INFINITE LOOP:
          if (!slider2.vars.animationLoop) { slider2.pause(); }
        }

        // SLIDE:
        if (!fade) {
          var dimension = (vertical) ? slider2.slides.filter(':first').height() : slider2.computedW,
              margin, slideString, calcNext;

          // INFINITE LOOP / REVERSE:
          if (carousel) {
            margin = slider2.vars.itemMargin;
            calcNext = ((slider2.itemW + margin) * slider2.move) * slider2.animatingTo;
            slideString = (calcNext > slider2.limit && slider2.visible !== 1) ? slider2.limit : calcNext;
          } else if (slider2.currentSlide === 0 && target === slider2.count - 1 && slider2.vars.animationLoop && slider2.direction !== "next") {
            slideString = (reverse) ? (slider2.count + slider2.cloneOffset) * dimension : 0;
          } else if (slider2.currentSlide === slider2.last && target === 0 && slider2.vars.animationLoop && slider2.direction !== "prev") {
            slideString = (reverse) ? 0 : (slider2.count + 1) * dimension;
          } else {
            slideString = (reverse) ? ((slider2.count - 1) - target + slider2.cloneOffset) * dimension : (target + slider2.cloneOffset) * dimension;
          }
          slider2.setProps(slideString, "", slider2.vars.animationSpeed);
          if (slider2.transitions) {
            if (!slider2.vars.animationLoop || !slider2.atEnd) {
              slider2.animating = false;
              slider2.currentSlide = slider2.animatingTo;
            }

            // Unbind previous transitionEnd events and re-bind new transitionEnd event
            slider2.container.unbind("webkitTransitionEnd transitionend");
            slider2.container.bind("webkitTransitionEnd transitionend", function() {
              clearTimeout(slider2.ensureAnimationEnd);
              slider2.wrapup(dimension);
            });

            // Insurance for the ever-so-fickle transitionEnd event
            clearTimeout(slider2.ensureAnimationEnd);
            slider2.ensureAnimationEnd = setTimeout(function() {
              slider2.wrapup(dimension);
            }, slider2.vars.animationSpeed + 100);

          } else {
            slider2.container.animate(slider2.args, slider2.vars.animationSpeed, slider2.vars.easing, function(){
              slider2.wrapup(dimension);
            });
          }
        } else { // FADE:
          if (!touch) {
            //slider2.slides.eq(slider2.currentSlide).fadeOut(slider2.vars.animationSpeed, slider2.vars.easing);
            //slider2.slides.eq(target).fadeIn(slider2.vars.animationSpeed, slider2.vars.easing, slider2.wrapup);

            slider2.slides.eq(slider2.currentSlide).css({"zIndex": 1}).animate({"opacity": 0}, slider2.vars.animationSpeed, slider2.vars.easing);
            slider2.slides.eq(target).css({"zIndex": 2}).animate({"opacity": 1}, slider2.vars.animationSpeed, slider2.vars.easing, slider2.wrapup);

          } else {
            slider2.slides.eq(slider2.currentSlide).css({ "opacity": 0, "zIndex": 1 });
            slider2.slides.eq(target).css({ "opacity": 1, "zIndex": 2 });
            slider2.wrapup(dimension);
          }
        }
        // SMOOTH HEIGHT:
        if (slider2.vars.smoothHeight) { methods.smoothHeight(slider2.vars.animationSpeed); }
      }
    };
    slider2.wrapup = function(dimension) {
      // SLIDE:
      if (!fade && !carousel) {
        if (slider2.currentSlide === 0 && slider2.animatingTo === slider2.last && slider2.vars.animationLoop) {
          slider2.setProps(dimension, "jumpEnd");
        } else if (slider2.currentSlide === slider2.last && slider2.animatingTo === 0 && slider2.vars.animationLoop) {
          slider2.setProps(dimension, "jumpStart");
        }
      }
      slider2.animating = false;
      slider2.currentSlide = slider2.animatingTo;
      // API: after() animation Callback
      slider2.vars.after(slider2);
    };

    // SLIDESHOW:
    slider2.animateSlides = function() {
      if (!slider2.animating && focused ) { slider2.flexAnimate(slider2.getTarget("next")); }
    };
    // SLIDESHOW:
    slider2.pause = function() {
      clearInterval(slider2.animatedSlides);
      slider2.animatedSlides = null;
      slider2.playing = false;
      // PAUSEPLAY:
      if (slider2.vars.pausePlay) { methods.pausePlay.update("play"); }
      // SYNC:
      if (slider2.syncExists) { methods.sync("pause"); }
    };
    // SLIDESHOW:
    slider2.play = function() {
      if (slider2.playing) { clearInterval(slider2.animatedSlides); }
      slider2.animatedSlides = slider2.animatedSlides || setInterval(slider2.animateSlides, slider2.vars.slideshowSpeed);
      slider2.started = slider2.playing = true;
      // PAUSEPLAY:
      if (slider2.vars.pausePlay) { methods.pausePlay.update("pause"); }
      // SYNC:
      if (slider2.syncExists) { methods.sync("play"); }
    };
    // STOP:
    slider2.stop = function () {
      slider2.pause();
      slider2.stopped = true;
    };
    slider2.canAdvance = function(target, fromNav) {
      // ASNAV:
      var last = (asNav) ? slider2.pagingCount - 1 : slider2.last;
      return (fromNav) ? true :
             (asNav && slider2.currentItem === slider2.count - 1 && target === 0 && slider2.direction === "prev") ? true :
             (asNav && slider2.currentItem === 0 && target === slider2.pagingCount - 1 && slider2.direction !== "next") ? false :
             (target === slider2.currentSlide && !asNav) ? false :
             (slider2.vars.animationLoop) ? true :
             (slider2.atEnd && slider2.currentSlide === 0 && target === last && slider2.direction !== "next") ? false :
             (slider2.atEnd && slider2.currentSlide === last && target === 0 && slider2.direction === "next") ? false :
             true;
    };
    slider2.getTarget = function(dir) {
      slider2.direction = dir;
      if (dir === "next") {
        return (slider2.currentSlide === slider2.last) ? 0 : slider2.currentSlide + 1;
      } else {
        return (slider2.currentSlide === 0) ? slider2.last : slider2.currentSlide - 1;
      }
    };

    // SLIDE:
    slider2.setProps = function(pos, special, dur) {
      var target = (function() {
        var posCheck = (pos) ? pos : ((slider2.itemW + slider2.vars.itemMargin) * slider2.move) * slider2.animatingTo,
            posCalc = (function() {
              if (carousel) {
                return (special === "setTouch") ? pos :
                       (reverse && slider2.animatingTo === slider2.last) ? 0 :
                       (reverse) ? slider2.limit - (((slider2.itemW + slider2.vars.itemMargin) * slider2.move) * slider2.animatingTo) :
                       (slider2.animatingTo === slider2.last) ? slider2.limit : posCheck;
              } else {
                switch (special) {
                  case "setTotal": return (reverse) ? ((slider2.count - 1) - slider2.currentSlide + slider2.cloneOffset) * pos : (slider2.currentSlide + slider2.cloneOffset) * pos;
                  case "setTouch": return (reverse) ? pos : pos;
                  case "jumpEnd": return (reverse) ? pos : slider2.count * pos;
                  case "jumpStart": return (reverse) ? slider2.count * pos : pos;
                  default: return pos;
                }
              }
            }());

            return (posCalc * -1) + "px";
          }());

      if (slider2.transitions) {
        target = (vertical) ? "translate3d(0," + target + ",0)" : "translate3d(" + target + ",0,0)";
        dur = (dur !== undefined) ? (dur/1000) + "s" : "0s";
        slider2.container.css("-" + slider2.pfx + "-transition-duration", dur);
         slider2.container.css("transition-duration", dur);
      }

      slider2.args[slider2.prop] = target;
      if (slider2.transitions || dur === undefined) { slider2.container.css(slider2.args); }

      slider2.container.css('transform',target);
    };

    slider2.setup = function(type) {
      // SLIDE:
      if (!fade) {
        var sliderOffset, arr;

        if (type === "init") {
          slider2.viewport = $('<div class="' + namespace + 'viewport"></div>').css({"overflow": "hidden", "position": "relative"}).appendTo(slider2).append(slider2.container);
          // INFINITE LOOP:
          slider2.cloneCount = 0;
          slider2.cloneOffset = 0;
          // REVERSE:
          if (reverse) {
            arr = $.makeArray(slider2.slides).reverse();
            slider2.slides = $(arr);
            slider2.container.empty().append(slider2.slides);
          }
        }
        // INFINITE LOOP && !CAROUSEL:
        if (slider2.vars.animationLoop && !carousel) {
          slider2.cloneCount = 2;
          slider2.cloneOffset = 1;
          // clear out old clones
          if (type !== "init") { slider2.container.find('.clone').remove(); }
          slider2.container.append(methods.uniqueID(slider2.slides.first().clone().addClass('clone')).attr('aria-hidden', 'true'))
                          .prepend(methods.uniqueID(slider2.slides.last().clone().addClass('clone')).attr('aria-hidden', 'true'));
        }
        slider2.newSlides = $(slider2.vars.selector, slider2);

        sliderOffset = (reverse) ? slider2.count - 1 - slider2.currentSlide + slider2.cloneOffset : slider2.currentSlide + slider2.cloneOffset;
        // VERTICAL:
        if (vertical && !carousel) {
          slider2.container.height((slider2.count + slider2.cloneCount) * 200 + "%").css("position", "absolute").width("100%");
          setTimeout(function(){
            slider2.newSlides.css({"display": "block"});
            slider2.doMath();
            slider2.viewport.height(slider2.h);
            slider2.setProps(sliderOffset * slider2.h, "init");
          }, (type === "init") ? 100 : 0);
        } else {
          slider2.container.width((slider2.count + slider2.cloneCount) * 200 + "%");
          slider2.setProps(sliderOffset * slider2.computedW, "init");
          setTimeout(function(){
            slider2.doMath();
            slider2.newSlides.css({"width": slider2.computedW, "marginRight" : slider2.computedM, "float": "left", "display": "block"});
            // SMOOTH HEIGHT:
            if (slider2.vars.smoothHeight) { methods.smoothHeight(); }
          }, (type === "init") ? 100 : 0);
        }
      } else { // FADE:
        slider2.slides.css({"width": "100%", "float": "left", "marginRight": "-100%", "position": "relative"});
        if (type === "init") {
          if (!touch) {
            //slider2.slides.eq(slider2.currentSlide).fadeIn(slider2.vars.animationSpeed, slider2.vars.easing);
            if (slider2.vars.fadeFirstSlide == false) {
              slider2.slides.css({ "opacity": 0, "display": "block", "zIndex": 1 }).eq(slider2.currentSlide).css({"zIndex": 2}).css({"opacity": 1});
            } else {
              slider2.slides.css({ "opacity": 0, "display": "block", "zIndex": 1 }).eq(slider2.currentSlide).css({"zIndex": 2}).animate({"opacity": 1},slider2.vars.animationSpeed,slider2.vars.easing);
            }
          } else {
            slider2.slides.css({ "opacity": 0, "display": "block", "webkitTransition": "opacity " + slider2.vars.animationSpeed / 1000 + "s ease", "zIndex": 1 }).eq(slider2.currentSlide).css({ "opacity": 1, "zIndex": 2});
          }
        }
        // SMOOTH HEIGHT:
        if (slider2.vars.smoothHeight) { methods.smoothHeight(); }
      }
      // !CAROUSEL:
      // CANDIDATE: active slide
      if (!carousel) { slider2.slides.removeClass(namespace + "active-slide").eq(slider2.currentSlide).addClass(namespace + "active-slide"); }

      //flexslider2: init() Callback
      slider2.vars.init(slider2);
    };

    slider2.doMath = function() {
      var slide = slider2.slides.first(),
          slideMargin = slider2.vars.itemMargin,
          minItems = slider2.vars.minItems,
          maxItems = slider2.vars.maxItems;

      slider2.w = (slider2.viewport===undefined) ? slider2.width() : slider2.viewport.width();
      slider2.h = slide.height();
      slider2.boxPadding = slide.outerWidth() - slide.width();

      // CAROUSEL:
      if (carousel) {
        slider2.itemT = slider2.vars.itemWidth + slideMargin;
        slider2.itemM = slideMargin;
        slider2.minW = (minItems) ? minItems * slider2.itemT : slider2.w;
        slider2.maxW = (maxItems) ? (maxItems * slider2.itemT) - slideMargin : slider2.w;
        slider2.itemW = (slider2.minW > slider2.w) ? (slider2.w - (slideMargin * (minItems - 1)))/minItems :
                       (slider2.maxW < slider2.w) ? (slider2.w - (slideMargin * (maxItems - 1)))/maxItems :
                       (slider2.vars.itemWidth > slider2.w) ? slider2.w : slider2.vars.itemWidth;

        slider2.visible = Math.floor(slider2.w/(slider2.itemW));
        slider2.move = (slider2.vars.move > 0 && slider2.vars.move < slider2.visible ) ? slider2.vars.move : slider2.visible;
        slider2.pagingCount = Math.ceil(((slider2.count - slider2.visible)/slider2.move) + 1);
        slider2.last =  slider2.pagingCount - 1;
        slider2.limit = (slider2.pagingCount === 1) ? 0 :
                       (slider2.vars.itemWidth > slider2.w) ? (slider2.itemW * (slider2.count - 1)) + (slideMargin * (slider2.count - 1)) : ((slider2.itemW + slideMargin) * slider2.count) - slider2.w - slideMargin;
      } else {
        slider2.itemW = slider2.w;
        slider2.itemM = slideMargin;
        slider2.pagingCount = slider2.count;
        slider2.last = slider2.count - 1;
      }
      slider2.computedW = slider2.itemW - slider2.boxPadding;
      slider2.computedM = slider2.itemM;
    };

    slider2.update = function(pos, action) {
      slider2.doMath();

      // update currentSlide and slider2.animatingTo if necessary
      if (!carousel) {
        if (pos < slider2.currentSlide) {
          slider2.currentSlide += 1;
        } else if (pos <= slider2.currentSlide && pos !== 0) {
          slider2.currentSlide -= 1;
        }
        slider2.animatingTo = slider2.currentSlide;
      }

      // update controlNav
      if (slider2.vars.controlNav && !slider2.manualControls) {
        if ((action === "add" && !carousel) || slider2.pagingCount > slider2.controlNav.length) {
          methods.controlNav.update("add");
        } else if ((action === "remove" && !carousel) || slider2.pagingCount < slider2.controlNav.length) {
          if (carousel && slider2.currentSlide > slider2.last) {
            slider2.currentSlide -= 1;
            slider2.animatingTo -= 1;
          }
          methods.controlNav.update("remove", slider2.last);
        }
      }
      // update directionNav
      if (slider2.vars.directionNav) { methods.directionNav.update(); }

    };

    slider2.addSlide = function(obj, pos) {
      var $obj = $(obj);

      slider2.count += 1;
      slider2.last = slider2.count - 1;

      // append new slide
      if (vertical && reverse) {
        (pos !== undefined) ? slider2.slides.eq(slider2.count - pos).after($obj) : slider2.container.prepend($obj);
      } else {
        (pos !== undefined) ? slider2.slides.eq(pos).before($obj) : slider2.container.append($obj);
      }

      // update currentSlide, animatingTo, controlNav, and directionNav
      slider2.update(pos, "add");

      // update slider2.slides
      slider2.slides = $(slider2.vars.selector + ':not(.clone)', slider2);
      // re-setup the slider2 to accomdate new slide
      slider2.setup();

      //flexslider2: added() Callback
      slider2.vars.added(slider2);
    };
    slider2.removeSlide = function(obj) {
      var pos = (isNaN(obj)) ? slider2.slides.index($(obj)) : obj;

      // update count
      slider2.count -= 1;
      slider2.last = slider2.count - 1;

      // remove slide
      if (isNaN(obj)) {
        $(obj, slider2.slides).remove();
      } else {
        (vertical && reverse) ? slider2.slides.eq(slider2.last).remove() : slider2.slides.eq(obj).remove();
      }

      // update currentSlide, animatingTo, controlNav, and directionNav
      slider2.doMath();
      slider2.update(pos, "remove");

      // update slider2.slides
      slider2.slides = $(slider2.vars.selector + ':not(.clone)', slider2);
      // re-setup the slider2 to accomdate new slide
      slider2.setup();

      // flexslider2: removed() Callback
      slider2.vars.removed(slider2);
    };

    //flexslider2: Initialize
    methods.init();
  };

  // Ensure the slider2 isn't focussed if the window loses focus.
  $( window ).blur( function ( e ) {
    focused = false;
  }).focus( function ( e ) {
    focused = true;
  });

  //flexslider2: Default Settings
  $.flexslider2.defaults = {
    namespace: "flex-",             //{NEW} String: Prefix string attached to the class of every element generated by the plugin
    selector: ".slides > li",       //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
    animation: "fade",              //String: Select your animation type, "fade" or "slide"
    easing: "swing",                //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
    direction: "horizontal",        //String: Select the sliding direction, "horizontal" or "vertical"
    reverse: false,                 //{NEW} Boolean: Reverse the animation direction
    animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
    smoothHeight: false,            //{NEW} Boolean: Allow height of the slider2 to animate smoothly in horizontal mode
    startAt: 0,                     //Integer: The slide that the slider2 should start on. Array notation (0 = first slide)
    slideshow: true,                //Boolean: Animate slider2 automatically
    slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
    animationSpeed: 600,            //Integer: Set the speed of animations, in milliseconds
    initDelay: 0,                   //{NEW} Integer: Set an initialization delay, in milliseconds
    randomize: false,               //Boolean: Randomize slide order
    fadeFirstSlide: true,           //Boolean: Fade in the first slide when animation type is "fade"
    thumbCaptions: false,           //Boolean: Whether or not to put captions on thumbnails when using the "thumbnails" controlNav.

    // Usability features
    pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
    pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider2, then resume when no longer hovering
    pauseInvisible: true,   		//{NEW} Boolean: Pause the slideshow when tab is invisible, resume when visible. Provides better UX, lower CPU usage.
    useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available
    touch: true,                    //{NEW} Boolean: Allow touch swipe navigation of the slider2 on touch-enabled devices
    video: false,                   //{NEW} Boolean: If using video in the slider2, will prevent CSS3 3D Transforms to avoid graphical glitches

    // Primary Controls
    controlNav: true,               //Boolean: Create navigation for paging control of each slide? Note: Leave true for manualControls usage
    directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
    prevText: "Previous",           //String: Set the text for the "previous" directionNav item
    nextText: "Next",               //String: Set the text for the "next" directionNav item

    // Secondary Navigation
    keyboard: true,                 //Boolean: Allow slider2 navigating via keyboard left/right keys
    multipleKeyboard: false,        //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider2 present.
    mousewheel: false,              //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider2 navigating via mousewheel
    pausePlay: false,               //Boolean: Create pause/play dynamic element
    pauseText: "Pause",             //String: Set the text for the "pause" pausePlay item
    playText: "Play",               //String: Set the text for the "play" pausePlay item

    // Special properties
    controlsContainer: "",          //{UPDATED} jQuery Object/Selector: Declare which container the navigation elements should be appended too. Default container is the flexslider2 element. Example use would be $(".flexslider2-container"). Property is ignored if given element is not found.
    manualControls: "",             //{UPDATED} jQuery Object/Selector: Declare custom control navigation. Examples would be $(".flex-control-nav li") or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
    customDirectionNav: "",         //{NEW} jQuery Object/Selector: Custom prev / next button. Must be two jQuery elements. In order to make the events work they have to have the classes "prev" and "next" (plus namespace)
    sync: "",                       //{NEW} Selector: Mirror the actions performed on this slider2 with another slider2. Use with care.
    asNavFor: "",                   //{NEW} Selector: Internal property exposed for turning the slider2 into a thumbnail navigation for another slider2

    // Carousel Options
    itemWidth: 0,                   //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
    itemMargin: 0,                  //{NEW} Integer: Margin between carousel items.
    minItems: 1,                    //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
    maxItems: 0,                    //{NEW} Integer: Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
    move: 0,                        //{NEW} Integer: Number of carousel items that should move on animation. If 0, slider2 will move all visible items.
    allowOneSlide: true,           //{NEW} Boolean: Whether or not to allow a slider2 comprised of a single slide

    // Callback API
    start: function(){},            //Callback: function(slider2) - Fires when the slider2 loads the first slide
    before: function(){},           //Callback: function(slider2) - Fires asynchronously with each slider2 animation
    after: function(){},            //Callback: function(slider2) - Fires after each slider2 animation completes
    end: function(){},              //Callback: function(slider2) - Fires when the slider2 reaches the last slide (asynchronous)
    added: function(){},            //{NEW} Callback: function(slider2) - Fires after a slide is added
    removed: function(){},           //{NEW} Callback: function(slider2) - Fires after a slide is removed
    init: function() {}             //{NEW} Callback: function(slider2) - Fires after the slider2 is initially setup
  };

  //flexslider2: Plugin Function
  $.fn.flexslider2 = function(options) {
    if (options === undefined) { options = {}; }

    if (typeof options === "object") {
      return this.each(function() {
        var $this = $(this),
            selector = (options.selector) ? options.selector : ".slides > li",
            $slides = $this.find(selector);

      if ( ( $slides.length === 1 && options.allowOneSlide === true ) || $slides.length === 0 ) {
          $slides.fadeIn(400);
          if (options.start) { options.start($this); }
        } else if ($this.data('flexslider2') === undefined) {
          new $.flexslider2(this, options);
        }
      });
    } else {
      // Helper strings to quickly perform functions on the slider2
      var $slider2 = $(this).data('flexslider2');
      switch (options) {
        case "play": $slider2.play(); break;
        case "pause": $slider2.pause(); break;
        case "stop": $slider2.stop(); break;
        case "next": $slider2.flexAnimate($slider2.getTarget("next"), true); break;
        case "prev":
        case "previous": $slider2.flexAnimate($slider2.getTarget("prev"), true); break;
        default: if (typeof options === "number") { $slider2.flexAnimate(options, true); }
      }
    }
  };
})(jQuery);
