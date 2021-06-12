var formData = new FormData();

formData.append("method", "create");
formData.append("reportDate", "2021-04-23");
formData.append("id_author", 1);
formData.append("id_booklet", 1);
formData.append("id_category", 1);
formData.append("description", "Dies ist ein Testeintrag.");

var request = new XMLHttpRequest();

request.open("POST", "../../php/Reports.php", false);
request.send(formData);

var response = JSON.parse(request.responseText);
//var response = request.responseText;

console.log("reports->create( $reportDate, $id_author, $id_booklet, $id_category, $description );");
console.log(response);
console.log("------------------------------")
