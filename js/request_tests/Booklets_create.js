var formData = new FormData();

formData.append("method", "create");
formData.append("id_creator", 1);
formData.append("subject", "TEST_Booklet");

var request = new XMLHttpRequest();

request.open("POST", "../../php/Booklets.php", false);
request.send(formData);

var response = JSON.parse(request.responseText);
//var response = request.responseText;

console.log("$booklets->create( $id_creator, $subject );");
console.log(response);
console.log("------------------------------")
