$(document).ready(function() {
    let hash = window.location.hash.replace('#', '');
	if(typeof(hash) == 'string' && hash != '') {
		$('#' + hash).click();
	}

    // Кнопка в шапке "Добавить зазачу из шаблона"
    let contractor_id = window.location.pathname.replace(/^.*\//, '');
    $('a[href="/task#add_group_task"]').attr('href', `/task?contractor_id=${contractor_id}#add_group_task`);
});
