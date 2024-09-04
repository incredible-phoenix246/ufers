$("document").ready(function(){
	var res= {
		loader: $('<div />',{class: 'loader'}),
		mainbody: $('.mainbody')
	}

	$('#start').click(function(){
			$.ajax({
				
				url: 'php/instructions.php',
				beforeSend: function(){
					res.mainbody.append(res.loader);
				},
				success: function(data){
					//$('#start').attr('disabled','disabled');
					window.location=data;
					//res.mainbody.find(res.loader).remove();
				}
			});
	});
});