var formData = new FormData();

formData.append("method", "getAllBookletReports");
formData.append("id_booklet", 3);

var request = new XMLHttpRequest();

request.open("POST", "../php/Reports.php", false);
request.send(formData);

var response = JSON.parse(request.responseText);
//var response = request.responseText;

console.log("reports->getAllBookletReports( $id_booklet );");
console.log(response);
console.log("------------------------------")
