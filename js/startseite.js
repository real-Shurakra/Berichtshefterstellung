import Notify from "http:\\localhost\\Berichtshefterstellung\\js\\notify.js";
import Cookie from "http:\\localhost\\Berichtshefterstellung\\js\\cookie.js";

class startseite{

    startUp(){
        var noty = new Notify();
        noty.setText(noty.noteType.hinweis, '<strong>Dies Webseite verwendet Cookies.</strong><br>Bit dem bestätigen dieser Webseite erklähren sie sich mit der Nutzung aller ihrer Daten einverstanden.')
        noty.makeModal();
        noty.showModal();
    }
}

var run = new startseite;
run.startUp();