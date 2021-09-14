let bookletGrid = document.getElementById("bookletGrid");

var formData = new FormData();

formData.append("method", "getAllBooklets");
formData.append("id_creator", 1);

var request = new XMLHttpRequest();

try {

  request.open("POST", "../php/Booklets.php", false);
  request.send(formData);
  console.log(request.responseText);
  var response = JSON.parse(request.responseText);
} catch (error) {
  console.log(error);
}
console.log('$booklets->getAllBooklets( $id_creator );');
console.log(response);
console.log("------------------------------");
var tempArray = [];
if (response) {
  for (let item in response) {
    let temp = response[item];
    console.log(temp);
    const tempString = "<a id='nav-post' class='card col-lg-4' href='?id="+temp.id+"'><div><p>" + temp.id + "</p><p>" + temp.creationdate + "</p><p>" + temp.subject + "</p></div></a>";

    tempArray.push(tempString);
  }
  console.log(tempArray);
  bookletGrid.innerHTML = tempArray.join("");

}

/*
let booklets = [];

for (let pathKey in buttonPaths) {
  console.log(pathKey);
  document.getElementById(pathKey).addEventListener('mousedown', () => {
    let http = new XMLHttpRequest();

    http.open('get', buttonPaths[pathKey], true);

    http.addEventListener('readystatechange', () => {

      if (http.status === 200 && http.readyState === 4) {
        document.getElementById('content').innerHTML = http.responseText;
      }

    })
    http.send();
  })
}
*/



