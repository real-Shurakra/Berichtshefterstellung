function createReport() {
    try{
        if (document.getElementById('newReportDate').value == ''){
            document.getElementById('newReportModalResponse').innerHTML = '<div class="alert alert-warning">Bitte gib ein Datum an</div>'
            return;
        }
        if (document.getElementById('newReportCategory').value == 0){
            document.getElementById('newReportModalResponse').innerHTML = '<div class="alert alert-warning">Bitte wähle eine Kategorie</div>'
            return;
        }
        if (document.getElementById('newReportText').value == ''){
            document.getElementById('newReportModalResponse').innerHTML = '<div class="alert alert-warning">Bitte lege keine leeren Berichte an</div>'
            return;
        }


        var formData = new FormData()

        formData.append("method", "create");
        
        formData.append("reportDate", document.getElementById('newReportDate').value);

        var reportName = document.getElementById("heftauswahl").value
        reportName = reportName.split('_')[0]
        formData.append("id_booklet", reportName);
        
        
        formData.append("id_category", document.getElementById('newReportCategory').value);

        formData.append("description", document.getElementById('newReportText').value);

        var request = new XMLHttpRequest();

        request.open("POST", "../php/Reports.php", false);
        request.send(formData);

        var response = JSON.parse(request.responseText);
        if (response['rc']){
            document.getElementById('newReportModalResponse').innerHTML = '<div class="alert alert-success">Gespiechert</div>'
            getRepots()
        }
        else{throw(response['rv'])}
    }
    catch (error) {
        document.getElementById('newReportModalResponse').innerHTML = '<div class="alert alert-danger">Es ist ein Fehler aufgetreten</div>'
        console.error(error)
    }

}

function createBooklet(newBookletName) {
    var classNotify = new Notify();
    var formData = new FormData();
    formData.append("method", "create");
    formData.append("subject", newBookletName);

    var request = new XMLHttpRequest();
    request.open("POST", "../php/Booklets.php", false);
    request.send(formData);

    var response = JSON.parse(request.responseText);
    document.getElementById('newBookletModalResponse').innerHTML = '<div class="alert alert-success">' + response['rv'] + '</div>'
}

function getRepots() {
    var reportName = document.getElementById("heftauswahl").value
    reportName = reportName.split('_')[1]
    var formData = new FormData();
    formData.append("method", "getAllBooklets");
    var request = new XMLHttpRequest();
    request.open("POST", "../php/Booklets.php", false);
    request.send(formData);
    var response = JSON.parse(request.responseText);
    console.log(response);
    if (response['rc']){
        for (var i in response['rv']){
            var checkReportName = response['rv'][i]['subject'];
            if (checkReportName == reportName){
                var report = '';
                var counter = 1;
                var creationdate = response['rv'][i]['creationdate'];
                document.getElementById('dateinput').value = creationdate;
                for (var i2 in response['rv'][i]['reports']){
                    var category = response['rv'][i]['reports'][i2]['category']
                    var reportdate = response['rv'][i]['reports'][i2]['reportdate']
                    var description = response['rv'][i]['reports'][i2]['description']
                    var reportid = response['rv'][i]['reports'][i2]['id']
                    report += '<div col-'
                    report += '<label for="reportinput">Bericht '+counter+': '+category+'-Bericht  vom '+reportdate+'</label>'
                    report += '<textarea class="form-control" rows="5" id="report_'+reportid+'">'+description+'</textarea>'
                    report += '<button type="button" class="btn btn-success" onclick="alterreport('+reportid+')">Speichern</button><button type="button" class="btn btn-warning" onclick="deletereport('+reportid+')">Löschen</button>'
                    counter += 1
                }
            document.getElementById('reports').innerHTML = report;
            }
        }
    }
}

function getAllBooklets () {
    try{
        var formData = new FormData();
        formData.append("method", "getAllBooklets");
        var request = new XMLHttpRequest();
        request.open("POST", "../php/Booklets.php", false);
        request.send(formData);
        var response = JSON.parse(request.responseText);
        if (response['rc']){
            var strHtml = '<label for="sel2">Heftauswahl:</label>';
            strHtml += '<select class="form-control" id="heftauswahl" name="heftauswahl" onchange="getRepots()">';
            for (var i in response['rv']){
                strHtml += '<option id="' + response['rv'][i]['id'] + '" value="' + response['rv'][i]['id'] + '_' + response['rv'][i]['subject'] + '">' + response['rv'][i]['subject'] + '</option>'
            }
            strHtml += '</select>'
            document.getElementById('options').innerHTML = strHtml;
        }
        else{throw response['rv']}
        getRepots();
    }
    catch (error){
        console.warn(error);
    }
}

function deletereport(reportid) {
    var question = new FormData()
    question.append('reportid', reportid)
    var request = new XMLHttpRequest();
    request.open("POST", "../php/Reports.php?method=deletereport", false);
    request.send(question);
    var classNotify = new Notify()
    try{
        var response = JSON.parse(request.responseText);
        if (response['rc']){
            classNotify.setText(classNotify.noteType.erfolg, 'Gespeichert')
        }
        else{throw(response['rv'])}
    }
    catch (error){
        classNotify.setText(classNotify.noteType.fehler, 'Es ist ein fehler aufgetreten')
        console.error(error)
    }
    finally{
        classNotify.makeModal()
        classNotify.showModal()
        getRepots()
    }
}

function alterreport(reportid) {
    var question = new FormData()
    var textid = 'report_' + reportid
    question.append('reportid', reportid)
    question.append('newDescrioption', document.getElementById(textid).value)
    var request = new XMLHttpRequest();
    request.open("POST", "../php/Reports.php?method=alterreport", false);
    request.send(question);
    var classNotify = new Notify()
    try{
        var response = JSON.parse(request.responseText);
        if (response['rc']){
            classNotify.setText(classNotify.noteType.erfolg, 'Gespeichert')
        }
        else{throw(response['rv'])}
    }
    catch (error){
        classNotify.setText(classNotify.noteType.fehler, 'Es ist ein fehler aufgetreten')
        console.error(error)
    }
    finally{
        classNotify.makeModal()
        classNotify.showModal()
        getRepots()
    }
}

function getAllCategories() {
    var request = new XMLHttpRequest();
    var strHtml
    request.open("POST", "../php/Reports.php?method=getAllCategories", false);
    request.send();
    var response = JSON.parse(request.responseText);
    strHtml += '<option value="0">- Bitte wählen -</option>'
    for (var i in response){
        strHtml += '<option value="' + response[i]['id'] + '">' + response[i]['description'] + '</option>'
    }
    document.getElementById('newReportCategorySelect').innerHTML = '<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">Kategorie</span></div><select class="form-control" id="newReportCategory">' + strHtml + '</select></div>';
}

function bouncerCheck () {
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = () => {
        if (xml.readyState == 4 && xml.status == 200) {
            var response = JSON.parse(xml.responseText);
            if (response){
                document.getElementById('nav-anmelden').innerHTML='<a class="nav-link" href="../index.php"><button type="button" class="btn btn-dark">Abmelden</button></a>'
            }
            else{
                document.getElementById('nav-anmelden').innerHTML='<a class="nav-link"><button type="button" class="btn btn-dark" data-toggle="modal" data-target="#login">Anmelden</button></a>'
            }
        } 
    }
    xml.open('POST', '../php/main.php?mode=bouncerCheck');
    xml.send();
}

function login () {
    /**
     * Login function
     * 
     * Used ids:
     * usr: Username.
     * pwd: Password.
     * 
     * Opens a modal popup on finished.
     */
    var frage = new FormData();
    frage.append("method", "login");
    frage.append("email", document.getElementById('usr').value);
    frage.append("password", document.getElementById('pwd').value);
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = () => {
        if (xml.readyState == 4 &&xml.status == 200) {
            try{
                let response = JSON.parse(xml.responseText);
                if (response['rc'] == false) {
                    throw response['rv']
                }
                else{
                    bouncerCheck();
                    location.reload();
                }
            }
            catch (error) {
                console.warn(error)
            }
        }
    }
    xml.open('POST', '../php/Page.php');
    xml.send(frage);
}

bouncerCheck();
getAllBooklets();
getAllCategories();