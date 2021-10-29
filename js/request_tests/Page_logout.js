var formData = new FormData();

formData.append("method", "logout");

var request = new XMLHttpRequest();

request.open("POST", "../../php/Page.php", false);
request.send(formData);

var response = JSON.parse(request.responseText);
//var response = request.responseText;

console.log("$page->logout();");
console.log(response);
console.log("------------------------------")
