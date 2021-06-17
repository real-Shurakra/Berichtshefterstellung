class Abmelden{
    logout(){
        var cookie = new Cookie();
        cookie.setCookie('UserID', '', 0);
        cookie.setCookie('vName', '', 0);
        cookie.setCookie('nName', '', 0);
    }
}