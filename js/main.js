class Main{
    constructor(){
        console.log('Main is currently running.');
    }

    bouncer(element, invert=false){
        element = document.getElementById(element);
        var cookie = new Cookie();
        if (invert) {
            if (typeof cookie.getCookie('UserID') !== 'undefined') {
                element.style.display = 'none';
            }
            else{
                element.style.display = 'initial';
            }
        } else {
            if (typeof cookie.getCookie('UserID') !== 'undefined') {
                element.style.display = 'initial';
            }
            else{
                element.style.display = 'none';
            }
        }
    }
}