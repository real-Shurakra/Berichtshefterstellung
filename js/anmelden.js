import Notify from "./notify.js";
import Cookie from "./Cookie.js";

class anmelden{
    login () {
        var frage = new FormData();
        
        frage.append("method", "login");
        frage.append("email", document.getElementById('usr').value);
        frage.append("password", document.getElementById('pwd').value);
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = () => {
            var noty = new Notify();
            if (
                xml.readyState == 200 && 
                xml.status == 4
            ) {
                var response = xml.responseText;
                if (response.length > 0) {
                    noty.setText(noty.noteType.erfolg, 'Anmeldung erfolgreich.');
                } 
                else if (response == 0) {
                    noty.setText(noty.noteType.hinweis, 'Das angegebene Konto existiert nicht.');
                }
                else if (!response) {
                    noty.setText(noty.noteType.hinweis, 'E-Mail Adresso oder Passwort fehlerhaft.');
                }
            } else {
                noty.setText(noty.noteType.fehler, 'Es ist ein Fehler aufgetreten.')
            }
            noty.makeModal();
            noty.showModal();
        }
        xml.open('POST', '../php/Page.php');
        xml.send(frage);
    }
}