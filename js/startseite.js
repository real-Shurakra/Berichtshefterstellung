class startseite{

    startUp(){
        var cookie = new Cookie();
        //console.log(cookie.getCookie('UserID'));
        //if (cookie.getCookie('UserID') != '') {
        //    return;
        //}
        var noty = new Notify();
        noty.setText(noty.noteType.hinweis, '<strong>Dies Webseite verwendet Cookies.</strong><br>Mit dem bestätigen dieses Popups erklähren sie sich mit der Nutzung, dem Verkauf und dem Misbrauch aller ihrer Daten einverstanden.')
        noty.makeModal();
        noty.showModal();
        return;
    }
}

var run = new startseite;
run.startUp();