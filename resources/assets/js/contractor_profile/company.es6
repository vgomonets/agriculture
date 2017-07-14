$(document).ready(function() {
    let hash = window.location.hash.replace('#', '');
	if(typeof(hash) == 'string' && hash != '') {
		$('#' + hash).click();
	}
});
