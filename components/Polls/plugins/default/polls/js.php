//<script>
Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
    		$('body').on('click', '.ossn-wall-container-menu-polls', function(){
					Ossn.redirect('polls/add');																  
			});
    		$('body').on('click', '.ossn-wall-container-menu-pollsgroup', function(){
					$url = window.location.href;
					$url = $url.replace(Ossn.site_url, '');
					$url = $url.replace('group/', '');
					Ossn.redirect('polls/add/group/'+$url);																  
			});			
			var $counter = 1;
    		$('body').on('click', '#polls-add-option', function(){
					$counter++;
					$('.polls-form-options').append('<input type="text" name="poll_options_'+$counter+'" placeholder="'+Ossn.Print('polls:option:title')+'" />');				
					//due to #1474 we need to add different methods for these polls options as array breaks
					//i don't wanted to call input directly in action due to #1474
					$('#polls-form-counter').val($counter);
			});
        ///	$('.poll-embed').on('click', function(e) {
			////	$guid = $(this).attr('data-guid');
         //	   	Ossn.MessageBox('polls/embedcode?guid='+$guid);
       		//});			
    });
});
Ossn.poll = function($guid){
	var $form = '#ossn-polls-form-questions-'+$guid;
	Ossn.ajaxRequest({
            url: Ossn.site_url + "action/poll/vote",
            form: $form,
            beforeSend: function() {
               	$($form).find('.ossn-poll-loading-submit').show();
                $($form).find('input[type="submit"]').hide();
            },
            callback: function(callback) {
                if (callback['data']['status'] == true) {
					$button = $($form).find('#poll-submit-button');
					$('.ossn-poll-item-main-'+$guid).html(callback['data']['option']);
                    Ossn.trigger_message(callback['success']);
                }
                if (['data']['status']  == false) {
                    Ossn.trigger_message(callback['error'], 'error');
                }
            }
        });				
};