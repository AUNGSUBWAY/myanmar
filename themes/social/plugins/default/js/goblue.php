//<script>
$(document).ready(function() {
	$('body').find('.topbar').prepend('<a class="topbar-home-mobile visible-sm visible-xs" href="'+Ossn.site_url+'"><i class="fa fa-home"></i></a>');
    $(document).on('click', '#sidebar-toggle', function() {
        var $toggle = $(this).attr('data-toggle');
        if ($toggle == 0) {
            $(this).attr('data-toggle', 1);
            $('.sidebar').addClass('sidebar-open');
            $('.ossn-page-container').addClass('sidebar-open-page-container');
            $('.topbar .right-side').addClass('right-side-space');
            $('.topbar .right-side').addClass('sidebar-hide-contents-xs');
            $('.ossn-inner-page').addClass('sidebar-hide-contents-xs');
        }
        if ($toggle == 1) {
            $(this).attr('data-toggle', 0);
            $('.sidebar').removeClass('sidebar-open');
            $('.ossn-page-container').removeClass('sidebar-open-page-container');
            $('.topbar .right-side').removeClass('right-side-space');
            $('.topbar .right-side').removeClass('sidebar-hide-contents-xs');
            $('.ossn-inner-page').removeClass('sidebar-hide-contents-xs');

            $('.topbar .right-side').addClass('right-side-nospace');
            $('.sidebar').addClass('sidebar-close');
            $('.ossn-page-container').addClass('sidebar-close-page-container');

        }
        var document_height = $(document).height();
        $(".sidebar").height(document_height);
    });
    var $chatsidebar = $('.ossn-chat-windows-long .inner');
    if ($chatsidebar.length) {
        $chatsidebar.css('height', $(window).height() - 45);
    }
    $(document).scroll(function() {
        if ($chatsidebar.length) {
            if ($(document).scrollTop() >= 50) {
                $chatsidebar.addClass('ossnchat-scroll-top');
                $chatsidebar.css('height', $(window).height());
            } else if ($(document).scrollTop() == 0) {
                $chatsidebar.removeClass('ossnchat-scroll-top');
                $chatsidebar.css('height', $(window).height() - 45);
            }
        }
    });
    var isMobile = function() {
        var envValues = ["xs", "sm", "md", "lg"];

        var $el = $('<div>');
        $el.appendTo($('body'));

        for (var i = envValues.length - 1; i >= 0; i--) {
            var envVal = envValues[i];

            $el.addClass('hidden-' + envVal);
            if ($el.is(':hidden')) {
                $el.remove();
                return envValues[i]
            }
        }
    };
	var moveSidebar = function(){
		var dtype = isMobile();
		if(dtype == 'xs' || dtype == 'sm'){
			//$('.sidebar-cont').appendTo('.ossn-layout-newsfeed');	
			$('.sidebar-menu .show').removeClass('show').addClass('out');
		} else {
			//$('.sidebar-cont').prependTo('.ossn-layout-newsfeed');	
			//$('.sidebar-menu .in').addClass('in');
			//$('.sidebar-menu .collapsed').removeClass('collapsed');
		}
	};
    $(window).resize(function() {
      	moveSidebar();
    });
	moveSidebar();
});
$(window).on('load resize', function () {
	if (document.querySelector("#draggable")) {
		if (($('.ossn-group-cover').height() + $('.profile-cover').height()) < 481) {
			// we're on mobile and have a group cover image
			const desktop_cover_width  = 1040;
			const desktop_cover_height = 200;
			var mobile_cover_height  = $('.ossn-group-cover').height() + $('.profile-cover').height();
			var real_image_width  = document.querySelector("#draggable").naturalWidth;
			var real_image_height = document.querySelector("#draggable").naturalHeight;
			// 1. how many mobile heights would we need to hold the image?
			var mobile_height_factor = real_image_height / mobile_cover_height;
			// 2. how many pixels wide would be the scaled mobile image in comparison to fix desktop_cover_width?
			var mobile_pixel_width = desktop_cover_width / mobile_height_factor;
			// 3. how often would these pixels fit into the current coverwidth?
			var current_cover_width = $('.ossn-group-cover').width() + $('.profile-cover').width();
			var mobile_width_factor = current_cover_width / mobile_pixel_width;
			// 4. how many pixels do we get with the current mobile cover height?
			var mobile_pixel_height = mobile_width_factor * mobile_cover_height;
			// setting the new height already here allows us to retrieve the new scaled image width calculated by the browser
			$('#draggable').css('height', mobile_pixel_height);
			mobile_pixel_width = parseInt($('#draggable').css('width'));
			
			// 5. calculate the height-scaling factor for dragging - get maximum possible scroll top position
			var desktop_scroll_top_max = real_image_height - desktop_cover_height;
			var mobile_scroll_top_max  = mobile_pixel_height - mobile_cover_height;
			var height_scaling_factor  = desktop_scroll_top_max / mobile_scroll_top_max;
			// 6. calculate the width-scaling factor for dragging - get maximum possible scroll left position
			var desktop_scroll_left_max = real_image_width - desktop_cover_width;
			var mobile_scroll_left_max  = mobile_pixel_width - current_cover_width;
			var width_scaling_factor  = desktop_scroll_left_max / mobile_scroll_left_max;
			// 7. retrieve the saved dragging positions and scale accordingly
			var cover_top    = parseInt($('#draggable').data('top'));
			var cover_left   = parseInt($('#draggable').data('left'));
			var mobile_pixel_top  = cover_top / height_scaling_factor;
			var mobile_pixel_left = cover_left / width_scaling_factor;
			$('#draggable').css('top', mobile_pixel_top);
			$('#draggable').css('left', mobile_pixel_left);
		}
	// don't display cover images before final scale and position is known
	$('#draggable').fadeIn();
	}
});
