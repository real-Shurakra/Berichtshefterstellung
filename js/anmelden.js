class Anmelden{
    constructor(){
        console.log('Anmelden is currently running.')
    }

    login () {
        var frage = new FormData();
        frage.append("method", "login");
        frage.append("email", document.getElementById('usr').value);
        frage.append("password", document.getElementById('pwd').value);
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = () => {
            if (
                xml.readyState == 4 &&
                xml.status == 200
            ) {
                var noty = new Notify();
                var response = JSON.parse(xml.responseText);
                if (response == false) {
                    noty.setText(noty.noteType.warnung, 'Benutzername oder Passwort fehlerhaft.')
                }
                else{
                    var gIntUserId = response['id']
                    console.log(gIntUserId)
                    noty.setText(noty.noteType.erfolg, 'Wilkommen ' + response['firstname'] + ' ' + response['lastname'])
                }
                noty.makeModal()
                noty.showModal()
            }
        }
        xml.open('POST', '../php/Page.php');
        xml.send(frage);
    }
}