$(document).ready(function(){

	(function(){
		$(':checkbox.user').each(function(){
			$(this).on('change',function(event){
				var check = Object.values($(':checkbox.user')).every(function(checkbox){
			
					return !checkbox.checked;
				});
				var disabled = check === true ? true : false;
				
				$('#users').prop('disabled', disabled);
			});
				
		});
	})();

});