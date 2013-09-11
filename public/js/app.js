
var twitterApp = function(opts){

	var $form = $('#'+opts.element);
	var $tbody = $('#'+opts.results).find('tbody');
	var $reset = $('#clear');

	var next = 1;

	$reset.on('click', function(e){

		reset();

		return false;
	});

	$form.on('click', '#b1', function(){

		// If a previous submit is in progress:
		if($form.hasClass('active')) return false;

		var $field = $("#field");
		var account = $field.val();

		if(account==='') return false;

		// Adding the active class to the form
		$form.addClass('active');

		var route = $form.attr('action')+'/'+account;

		// console.log(route);

		// Issuing a GET ajax request (the action attribute of the form):
		$.get(route,function(response){

			var row = '';

			if( response[0]!==undefined && response[0].message )
			{

				row = getTableRow().append(
							getTableCell(next) +
							getTableCell('@'+account) +
							getTableCell(response[0].message, 3)
							);

				$tbody.append(row);


			} else {
					// addFormField();

				row = getTableRow().append(
							getTableCell(next) +
							getTableCell('@'+account) +
							getTableCell(response.max_distance) +
							getTableCell(response.tweets_per_workday) +
							getTableCell(response.spelling_frequency)
							);

				$tbody.append(row);
			}

			$field.val('');
			$form.removeClass('active');

			next = next + 1;

		},'json');

		return false;

	});

	function reset(){
		$tbody.html('');
		$form.find('input[type="text"]').val('');
		$form.removeClass('active');
		next=1;
	}

	function getTableRow(){
		return $('<tr>');
	}
	function getTableCell(value, colspan){
		colspan = typeof colspan !== 'undefined' ? colspan : 1;
		return '<td colspan="'+colspan+'">'+value+'</td>';
	}
};
