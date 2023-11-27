$(document).ready(function() {
    $('body').on('click', '.ossn-wall-container-menu-videosgroup', function(){
					$url = window.location.href;
					$url = $url.replace(Ossn.site_url, '');
					$url = $url.replace('group/', '');
					Ossn.redirect('video/add/group/'+$url);																  
	});		
    $('body').on('click', '.ossn-wall-container-menu-videos', function(){
					Ossn.redirect('video/add');																  
	});		    
});    