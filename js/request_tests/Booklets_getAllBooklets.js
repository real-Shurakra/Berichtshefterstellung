var formData = new FormData();

formData.append("method", "getAllBooklets");
formData.append("id_creator", 1);

var request = new XMLHttpRequest();

request.open("POST", "../../php/Booklets.php", false);
request.send(formData);

var response = JSON.parse(request.responseText);
//var response = request.responseText;

console.log("$booklets->getAllBooklets( $id_creator );");
console.log(response);
console.log("------------------------------")
