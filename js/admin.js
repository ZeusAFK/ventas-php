function AdminNavigation(status){
	var status = status == 0 ? 'on' : 'off';
	var redirect_url = Backbone.history.fragment.length > 0 ? Backbone.history.fragment.replace('/', 'ISSEPARATOR') : 'home';
	redirectToUrl('administrator/' + status + '/' + redirect_url);
}