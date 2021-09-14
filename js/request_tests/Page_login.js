var formData = new FormData();

formData.append("method", "login");
formData.append("email", "hans@peter.de");
formData.append("password", '1234');

var request = new XMLHttpRequest();

request.open("POST", "../php/Page.php", false);
request.send(formData);

var response = JSON.parse(request.responseText);
//var response = request.responseText;

console.log("$page->login( $email, $password );");
console.log(response);
console.log("------------------------------")
