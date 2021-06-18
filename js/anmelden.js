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
            var noty = new Notify();
            if (
                xml.readyState == 4 && 
                xml.status == 200
            ) {
                var response = JSON.parse(xml.responseText);
                
                console.log(response);
                var cookie = new Cookie();
                cookie.setCookie('UserID', response['id'], 1);
                cookie.setCookie('vName', response['firstname'], 1);
                cookie.setCookie('nName', response['lastname'], 1);
                console.log(cookie.getCookie('UserID'));
                console.log(cookie.getCookie('vName'));
                console.log(cookie.getCookie('nName'));

            } 
        }
        xml.open('POST', '../php/Page.php');
        xml.send(frage);
    }
}
var main = new Main();
main.bouncer('nav-berichte');
main.bouncer('nav-abmelden');