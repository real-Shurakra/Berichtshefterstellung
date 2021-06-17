class Notify{
	constructor(){
		this.noteType = Object.freeze({
			erfolg : '<div class="alert alert-success" role="alert">',
			hinweis : '<div class="alert alert-info" role="alert">',
			warnung : '<div class="alert alert-warning" role="alert">',
			fehler : '<div class="alert alert-danger" role="alert">'
		});
		this.displayText = null;
	}
	
	setText(type, text){
		this.displayText = type + text + '</div>';
	}
	
	makeModal(size='sm'){
		document.getElementById('notifyDiv').innerHTML=`
<div class="modal fade" id="notify">
	<div class="modal-dialog modal-` + size + `">
		<div class="modal-content">
			<div class="modal-body" style="background-color: #C7C7C7">
				<form class="form-inline" action="/action_page.php">`
				+ this.displayText + `
				</form>
			</div>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
		</div>
	</div>
</div>`;
	}
	
	showModal(){
		$('#notify').modal('show');
	}
	
	hideModal(){
		$('#notify').modal('hide');
	}
	
	deleteModal(){
		document.getElementById('notifyDiv').innerHTML='';
	}
}