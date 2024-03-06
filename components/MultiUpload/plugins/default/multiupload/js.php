//<script>
Ossn.add_hook('ajax', 'request:settings', 'multiupload_check');

function multiupload_check(hook, type, ret, params) {
	if (ret['url'].includes('action/wall/post/a') || ret['url'].includes('action/wall/post/g') || ret['url'].includes('action/wall/post/u') || ret['url'].includes('action/wall/post/bpage')) {
		$text = $('#ossn-wall-form').find('textarea').val();
		fileAmmountCheck = $('.multiple-upload-container').attr('data-count');
		if (fileAmmountCheck && fileAmmountCheck > 1) {
			if ($text == '') {
				Ossn.trigger_message(Ossn.Print('multiupload:text'), 'error');
				return {
					action: false,
				};
			}
		}
		//clear data
		$('.multiple-upload-container').attr('data-count', 0);
		$('.multiple-upload-container').html("");
	}
	return ret;
}
$(document).ready(function () {
	var form = $('#ossn-wall-form');
	if (form.length > 0) {
		form.find('input[name="ossn_photo"]').attr('name', 'multiphotos[]').attr('multiple', 'multiple').attr('id', 'multipleupload-wall');
	}
	$('#ossn-wall-photo').append('<div class="multiple-upload-container" data-count="0"></div>');
	var imagesPreview = function (input) {
		if (input.files) {
			var filesAmount = input.files.length;
			$('.multiple-upload-container').attr('data-count', filesAmount);

			for (var i = 0; i < filesAmount; i++) {
				var reader = new FileReader();

				reader.onload = (function (file) {
					return function (event) {
						console.log(file);
						var template = '<div class="multiple-upload-item"><span data-name="' + file.name + '" class="multiple-upload-remove-item"><span>x</span></span><img src="' + event.target.result + '" /></div>';
						$('.multiple-upload-container').append(template);
					};
				})(input.files[i]);
				reader.readAsDataURL(input.files[i]);
			}
		}

	};
	$('body').on('click', '.multiple-upload-remove-item', function () {

		$input = $('#multipleupload-wall')[0];
		var buffer = new DataTransfer();
		var name = $(this).attr('data-name');
		for (let i = 0; i < $input.files.length; i++) {
			if (name !== $input.files[i].name) {
				buffer.items.add($input.files[i]);
			}
		}

		document.getElementById("multipleupload-wall").files = buffer.files;
		$input = $('#multipleupload-wall')[0];
		$(this).parent().fadeOut().remove();
	});
	$('#multipleupload-wall').on('change', function (e) {
		$('.multiple-upload-container').html("");
		imagesPreview(this);
	});
	$('#ossn-wall-form').on('asubmit', function () {
		if (fileAmmountCheck && fileAmmountCheck > 1) {
			if ($text == '') {
				Ossn.trigger_message(Ossn.Print('multiupload:text'), 'error');
				e.preventDefault();
			}
		}
	});
});