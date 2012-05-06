$(document).ready(function () {

	$('#preview').click(function() {
		$("#commentbox").html("My text is changed!");
		$('#commentbox').markdown();

	});

	$("table#mods").tablesorter({ sortList: [[2,1]] });
	$("table#servers").tablesorter({ sortList: [[0,1]] });

	$('.tooltip').popover();


	// POSITION STATIC TWIPSIES
	// ========================

	$(window).bind('load resize', function () {
		$(".twipsies a").each(function () {
			$(this)
		.twipsy({
			live: false
		, placement: $(this).attr('title')
		, trigger: 'manual'
		, offset: 2
		})
		.twipsy('show')
		})
	})
});