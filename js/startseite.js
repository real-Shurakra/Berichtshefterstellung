class startseite{
    constructor(){
        console.log('Startseite is currently runnning.');
    }

    startUp(){
        var cookie = new Cookie();
        console.log(cookie.getCookie('UserID'));
        if (isset(cookie.getCookie('UserID'))) {
            return;
        }
        var noty = new Notify();
        noty.setText(noty.noteType.hinweis, '<strong>Dies Webseite verwendet Cookies.</strong><br>Mit dem bestätigen dieses Popups erklähren sie sich mit der Nutzung, dem Verkauf und dem Misbrauch aller ihrer Daten einverstanden.')
        noty.makeModal('md');
        noty.showModal();
        return;
    }

    
}

var main = new Main();
main.bouncer('nav-berichte');
main.bouncer('nav-anmelden', true);
main.bouncer('nav-abmelden');
var run = new startseite;
run.startUp();