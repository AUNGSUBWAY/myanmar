//<script>
Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
    	$('body').on('click', '.ossn-wall-container-menu-events', function(){
					Ossn.redirect('event/add');																  
		});        
		if ($('#event-location-input').length) {
 	        //Location autocomplete not working over https #1043
            //Change to places js
            var placesAutocomplete = places({
                container: document.querySelector('#event-location-input')
            });
        }
     	$('body').on('click', '.event-relation', function(){
        		$guid = $(this).attr('data-guid');
        		$type = $(this).attr('data-type');
                Ossn.MessageBox('event/relations/'+$guid+'?type='+$type);
        });
		$('body').on('click', '.ossn-wall-container-menu-eventsgroups', function(){
					$url = window.location.href;
					$url = $url.replace(Ossn.site_url, '');
					$url = $url.replace('group/', '');
					Ossn.redirect('event/add/group/'+$url);															  
		});			
    });
});