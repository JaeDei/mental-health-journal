$(document).ready( function () {
    var table = $('#dataTable').DataTable({
        responsive: true
    });
});

$(document).on('click', '.clickable-row', function(e){
	var url = $(this).data('href');

	window.location = url;
});