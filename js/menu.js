let buttonPaths = [];
buttonPaths['nav-start'] = 'startseite.html';
buttonPaths['nav-berichte'] = 'berichtsheft.html';
buttonPaths['nav-anmelden'] = 'anmelden.html';
buttonPaths['nav-abmelden'] = '../index.php';

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

/*
<li id="nav-start" className="nav-item">
<a className="nav-link" href="startseite.html">Startseite</a>
</li>
<li id="nav-berichte" className="nav-item">
<a className="nav-link you-are-here" href="berichtsheft.html">Berichtshefte</a>
</li>
<li id="nav-anmelden" className="nav-item">
<a className="nav-link" href="anmelden.html">Anmelden</a>
</li>
<li id="nav-abmelden" className="nav-item">
<a className="nav-link" href="../index.php">Abmelden</a>
</li>
*/
