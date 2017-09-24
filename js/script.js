/********************************************************
 *
 * Custom Javascript code for Enkel Bootstrap theme
 * Written by Themelize.me (http://themelize.me)
 *
 *******************************************************/
$(document).ready(function() {
  
  // Bootstrap tooltip
  // ----------------------------------------------------------------
  // invoke by adding _tooltip to a tags (this makes it validate)
  $('body').tooltip({
    selector: "a[class*=_tooltip]"
  });
    
  // Bootstrap popover
  // ----------------------------------------------------------------
  // invoke by adding _popover to a tags (this makes it validate)
  $('body').popover({
    selector: "a[class*=_popover]",
    trigger: "hover"
  });

  // colour switch
  // ----------------------------------------------------------------
  $('.colour-switcher a').click(function() {
    var c = $(this).attr('href').replace('#','');
    var cacheBuster = 4 * Math.floor(Math.random() * 6);
    $('.colour-switcher a').removeClass('active');
    $('.colour-switcher a.'+ c).addClass('active');
    $('#colour-scheme').attr('href','css/colour-'+ c +'.css?x='+ cacheBuster);
  });
  
  //flexslider
  // ----------------------------------------------------------------
  $('.flexslider').each(function() {
    var sliderSettings =  {
      animation: $(this).attr('data-transition'),
      selector: ".slides > .slide",
      controlNav: true,
      smoothHeight: true,
      animationLoop: true,
    };
    
    var sliderNav = $(this).attr('data-slidernav');
    if (sliderNav !== 'auto') {
      sliderSettings = $.extend({}, sliderSettings, {
        manualControls: sliderNav +' li a',
        controlsContainer: '.flexslider-wrapper'
      });
    }
    
    $(this).flexslider(sliderSettings);
  });

  // jQuery Isotope Plugin
  // ----------------------------------------------------------------
  var $filters = $('#quicksand-categories');
  var $holder = $('ul#quicksand');
  
  if ($holder.length > 0) {
    $holder.isotope(
    {
      animationOptions:
      {
        animationEngine: 'best-available',
        duration: 750,
        easing: 'linear',
        queue: false
      }
    });
    
    // If imagesLoaded avaliable use it
    if (jQuery().imagesLoaded) {
      $holder.imagesLoaded( function() {
        $holder.isotope('layout');
      });
    }
    
    $('body').addClass('has-isotope');
    
    $filters.find('li a').click(function()
    {
      $filters.find('li').removeClass('active');
      var $filterType = $(this).attr('href');
      $filterType = $filterType.substr(1);
      $(this).parent().addClass('active');
      var selector = 'li[data-type=' + $filterType + ']';
  
       if ($filterType === 'all') {
        selector = 'li';
      }

      $holder.isotope({filter: selector});
      return false;
    });
  }
  
  

});
$(function(){
    $('.button-checkbox').each(function(){
		var $widget = $(this),
			$button = $widget.find('button'),
			$checkbox = $widget.find('input:checkbox'),
			color = $button.data('color'),
			settings = {
					on: {
						icon: 'glyphicon glyphicon-check'
					},
					off: {
						icon: 'glyphicon glyphicon-unchecked'
					}
			};

		$button.on('click', function () {
			$checkbox.prop('checked', !$checkbox.is(':checked'));
			$checkbox.triggerHandler('change');
			updateDisplay();
		});

		$checkbox.on('change', function () {
			updateDisplay();
		});

		function updateDisplay() {
			var isChecked = $checkbox.is(':checked');
			// Set the button's state
			$button.data('state', (isChecked) ? "on" : "off");

			// Set the button's icon
			$button.find('.state-icon')
				.removeClass()
				.addClass('state-icon ' + settings[$button.data('state')].icon);

			// Update the button's color
			if (isChecked) {
				$button
					.removeClass('btn-default')
					.addClass('btn-' + color + ' active');
			}
			else
			{
				$button
					.removeClass('btn-' + color + ' active')
					.addClass('btn-default');
			}
		}
		function init() {
			updateDisplay();
			// Inject the icon if applicable
			if ($button.find('.state-icon').length == 0) {
				$button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
			}
		}
		init();
	});
});