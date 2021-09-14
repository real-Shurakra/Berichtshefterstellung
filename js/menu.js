let buttonPaths = [];
buttonPaths['nav-start'] = 'index.html';
buttonPaths['nav-berichte'] = 'berichtsheft.html';
buttonPaths['nav-anmelden'] = 'anmelden.html';
buttonPaths['nav-abmelden'] = '../index.php';
buttonPaths['nav-post'] = 'post.html';

for (let pathKey in buttonPaths) {
  console.log(pathKey);
  document.getElementById(pathKey).addEventListener('mousedown', () => {
    document.querySelector('.nav-item').classList.remove('active');
    document.getElementById(pathKey).classList.add('active');
    let http = new XMLHttpRequest();

    http.open('get', buttonPaths[pathKey], true);

    http.addEventListener('readystatechange', () => {

      if (http.status === 200 && http.readyState === 4) {
        if (pathKey !== 'nav-start') {
          document.getElementById('content').innerHTML = http.responseText;
        } else {
          location.reload();
        }
      }
    })
    http.send();
  })
}
