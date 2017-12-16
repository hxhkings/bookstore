$(document).ready(function(){
	
	(function(){
		$(':checkbox.book').each(function(){
			$(this).on('change',function(event){
				var check = Object.values($(':checkbox.book')).every(function(checkbox){
					return !checkbox.checked;
				});
				var disabled = check === true ? true : false;
				
				$('#books').prop('disabled', disabled);
			});
				
		});
	})();

	(function(){
		var filter = /[^\w]+/g;

		$('input.adduser').each(function(){
			$(this).on('keyup change', function(event){
				if($('[name=author]').val().replace(filter, '') === '' ||
					$('[name=title]').val().replace(filter, '') === '' ||
					$('[name=quantity]').val().replace(filter, '') === '' ||
					$('[name=price]').val().replace(filter, '') === '' ||
					$('[name=quantity]').val() < 1 ||
					$('[name=price]').val() < 1){
		
					$('button.adduser').prop('disabled', true);
				} else{
				
					$('button.adduser').prop('disabled', false);
				}
			});
		});

	})();

	

});