//<script>
Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
        /**
         * Reposition cover page
         */
        $('#reposition-cover-page').on('click', function() {
            $('#reposition-cover-page').hide();
            $('#save-position-cover-page').show();

            $(function() {
                $.globalVars = {
                    originalTop: 0,
                    originalLeft: 0,
                    maxHeight: $("#draggable").height() - $("#container").height(),
                    maxWidth: $("#draggable").width() - $("#container").width()
                };
                $("#draggable").draggable({
                    start: function(event, ui) {
                        if (ui.position != undefined) {
                            $.globalVars.originalTop = ui.position.top;
                            $.globalVars.originalLeft = ui.position.left;
                        }
                    },
                    drag: function(event, ui) {
                        var newTop = ui.position.top;
                        var newLeft = ui.position.left;
                        if (ui.position.top < 0 && ui.position.top * -1 > $.globalVars.maxHeight) {
                            newTop = $.globalVars.maxHeight * -1;
                        }
                        if (ui.position.top > 0) {
                            newTop = 0;
                        }
                        if (ui.position.left < 0 && ui.position.left * -1 > $.globalVars.maxWidth) {
                            newLeft = $.globalVars.maxWidth * -1;
                        }
                        if (ui.position.left > 0) {
                            newLeft = 0;
                        }
                        ui.position.top = newTop;
                        ui.position.left = newLeft;

                        Ossn.PageCover_top = newTop;
                        Ossn.PageCover_left = newLeft;
                    }
                });
            });
        });
        var $profile_cover_text_btn = '';
        Ossn.ajaxRequest({
            url: Ossn.site_url + 'action/bpage/cover/add',
            action: true,
            containMedia: true,
            form: '#upload-cover-page',
            error: function(xhr, status, error) {
                if ((error == 'Internal Server Error' || error !== '') && status !== 'abort') {
                    Ossn.MessageBox('syserror/unknown');
                }
                $('#change-bpcover-btn').html($profile_cover_text_btn);
            },
            beforeSend: function(xhr) {
                $profile_cover_text_btn = $('#change-bpcover-btn').text();
                $('#change-bpcover-btn').html("<div class='ossn-loading'></div>");

                var fileInput = $('#upload-cover-page').find("input[type=file]")[0],
                    file = fileInput.files && fileInput.files[0];
                if (file) {
                    var img = new Image();
                    img.src = window.URL.createObjectURL(file);
                    img.onload = function() {
                        var width = img.naturalWidth,
                            height = img.naturalHeight;
                        window.URL.revokeObjectURL(img.src);
                        if (width < 850 || height < 300) {
                            xhr.abort();
                            Ossn.trigger_message(Ossn.Print('bpage:cover:err1:detail'), 'error');
                            return false;
                        }
                    };
                }
            },
            callback: function(code) {
                $('#change-bpcover-btn').html($profile_cover_text_btn);
                if (code == 0) {
                    Ossn.trigger_message(Ossn.Print('bpage:cover:upload:error'), 'error');
                } else {
                    $time = $.now();
                    $('.business-page-cover-img').attr('src', code);
                    $('business-page-cover-img').attr('style', '');
                }

            }
        });
        var bpage_pchange_btext = $('#bpage-upload-photo-btn').text();
        Ossn.ajaxRequest({
            url: Ossn.site_url + 'action/bpage/photo/add',
            action: true,
            containMedia: true,
            form: '#upload-photo-page',
            error: function(xhr, status, error) {
                $('#bpage-upload-photo-btn').html( bpage_pchange_btext);
            },
            beforeSend: function(xhr) {
                $profile_cover_text_btn = $('#change-bpcover-btn').text();
                $('#bpage-upload-photo-btn').html("<div class='ossn-loading'></div>");
            },
            callback: function(code) {
               $('#bpage-upload-photo-btn').html(bpage_pchange_btext);
                if (code == 0) {
                    Ossn.trigger_message(Ossn.Print('bpage:cover:upload:error'), 'error');
                } else {
                    $time = $.now();
                    $('.business-page .logo-page').attr('src', code);
                    $('.business-page .logo-page').attr('style', '');
                }

            }
        });        
        
        $('body').on('click', '.like-page', function() {
        		$element = $(this);
        		$guid = $element.attr('data-guid');
 				Ossn.PostRequest({
             	    url: Ossn.site_url + "action/bpage/like?guid=" + $guid,
               		beforeSend: function() {
                 		  $element.html('<div class="ossn-loading"></div>');
                	},
                	callback: function(callback) {
                    if (callback == 0) {
                      	$element.html("<i class='fa fa-thumbs-up'></i>"+Ossn.Print('ossn:like'));
                    }
                    if(callback == 1){
                      	$element.html("<i class='fa fa-thumbs-down'></i>"+Ossn.Print('ossn:unlike'));
                        $element.removeClass('like-page');
                        $element.addClass('unlike-page');
                    }
                }
            });  
         });         
        $('body').on('click', '.unlike-page', function() {
        		$element = $(this);
        		$guid = $element.attr('data-guid');
 				Ossn.PostRequest({
             	    url: Ossn.site_url + "action/bpage/unlike?guid=" + $guid,
               		beforeSend: function() {
                 		  $element.html('<div class="ossn-loading"></div>');
                	},
                	callback: function(callback) {
                    if (callback == 0) {
                      	$element.html("<i class='fa fa-thumbs-down'></i>"+Ossn.Print('ossn:unlike'));
                    }
                    if(callback == 1){
                      	$element.html("<i class='fa fa-thumbs-up'></i>"+Ossn.Print('ossn:like'));
                        $element.addClass('like-page');
                        $element.removeClass('unlike-page');
                    }
                }
            });  
         });                             
        $('body').on('click', '#bpage-upload-photo-btn', function() {
					Ossn.Clk("#upload-photo-page input[type='file']");
		});
        $('body').on('click', '#save-position-cover-page', function() {
            var $btn_text_cover_page = $('.save-position-cover-page').text();
            var $pcover_top = $('.business-page-cover-img').css('top');
            var $pcover_left = $('.business-page-cover-img').css('left');
            var $guid = $('.business-page-cover-img').attr('data-guid');

            Ossn.PostRequest({
                url: Ossn.site_url + "action/bpage/cover/save?guid=" + $guid + "&top=" + $pcover_top + '&left=' + $pcover_left,
                beforeSend: function() {
                    $('#save-position-cover-page').html('<div class="ossn-loading"></div>');
                },
                callback: function(callback) {
                    $('.save-position-cover-page').text($btn_text_cover_page);
                    if (callback == 0) {
                        location.reload();
                    } else {
                        $('#reposition-cover-page').show();
                        $('#save-position-cover-page').hide();
                    }
                }
            });
        });

    });
});