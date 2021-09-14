class Reports{
    constructor(){
        console.log('Reports.js => Reports() -> Start');
    }

    createReport(){
        console.log('Reports.js => Reports.createReport() -> Start')
        formData.append("method", "create");
        console.log('Reports.js => Reports.createReport() -> Get inputDate')
        formData.append("reportDate", document.getElementById('inputDate').value);
        console.log('Reports.js => Reports.createReport() -> Get id')
        formData.append("id_author", response['id']);
        console.log('Reports.js => Reports.createReport() -> Get booklet')
        formData.append("id_booklet", document.getElementById('booklet').value);
        console.log('Reports.js => Reports.createReport() -> Get category')
        formData.append("id_category", document.getElementById('category').value);
        console.log('Reports.js => Reports.createReport() -> Get reportinput')
        formData.append("description", document.getElementById('reportinput').value);

        var request = new XMLHttpRequest();

        request.open("POST", "../php/Reports.php", false);
        request.send(formData);
        var classNotify = new Notify()
        try{
            var response = JSON.parse(request.responseText);
            if (response['rc'] == false){throw response['rv']}
            classNotify.setText(classNotify.noteType.erfolg, 'Bericht gespeichert')
        }
        catch (error){
            console.error('Reports.js => Reports.createReport() -> ' + error);
            classNotify.setText(classNotify.noteType.fehler, '<strong>Es ist ein Fehler aufgetreten!</strong>');
        }
        finally{
            classNotify.makeModal();
            classNotify.showModal();
        }
    }
}