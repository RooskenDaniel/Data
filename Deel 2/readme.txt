Hoe instaleer je deze API?
Deze Api is gemaakt in Lumen, omdat uit te voeren is geen aanvulende software nodig.
Zelfs een PHP-server (zoals XAMPP) in niet nodig. Lumen werkt met de ingebouwde PHP-serevr van Windows.
De Windows PHP-server wordt bedient vanuit de Command Prompt.
Open eerst de Command Prompt.
	Dit kan je doen door op Windowsknop + R te drukken. Daarna 'cmd' intpyen en op 'enter' drukken.
Navigeer nu naar het mapje waar het project staat.
	Dit doe je door 'cd /d *mapje*' in te typen. In mijn geval 'cd /d c:\xampp\htdocs\lumen\dataprocessing', maar mischien staat 'ie bij jou ergens anders.
Als dit is gelukt, type je 'php -S localhost:8000 -t public'. Dit houdt in dat je de PHP-server start op localhost:8000.
Navigeer in een webbrowser naar 'http://localhost:8000', als er staat 'Welkom bij mijn api', is het gelukt.


Wat kan ik met deze API?
Alle voertuigen ophalen
	Als je alle info over alle gekentekende voertuigen wilt ophalen, verstuur je een GET naar 'http://localhost:8000/voertuigen' Je krijgt nu alle voertuigen terug in een JSON zals in deel 1 staat.
	Dit kan erg lang duren omdat er voor ieder voertuig twee extra bestander moeten worden doorgezelen.

Een specifiek voertuig ophalen
	Als je alle info over een specifiek voertuig wilt ophalen, verstuur je een GET naar 'http://localhost:8000/voertuigen/{kenteken}'. Hierin staat {kenteken} voor het kenteken van het voertuig dat je wilt ophalen. Je krijgt de data is een JSON zoals in deel 1.

Een voertuig toevoegen
	Als je een voertuig wilt toevoegen, verstuur je een POST naar 'http://localhost:8000/voertuigen'. Je moet een JSON meegeven die precies zo is geformuleerd als in deel 1 staat beschreven, ook de volgorde moet kloppen.

Een voertuig verwijderen
	Als je een voertuig wilt verwijderen, verstuur je een DELETE naar 'http://localhost:8000/voertuigen/{kenteken}'. {kenteken} staat hier voor het kenteken van het voertuig dat je wilt verwijderen.

Een voertuig wijzigen
	Als je een voertuig wilt wijzigen, vurstuur je een PUT naar 'http://localhost:8000/voertuigen/{kenteken}'. {kenteken staat hier voor het te wijzigen voertuig. Je moet een JSON meegeven die dezelfe keys heeft als in deel 1. Er wordt echter niet naar compleetheid of volgorde gekeken. Je hoeft dus alleen de te wijzigen velden mee te geven in een willekeurige volgorde.


Welke bestanden moet ik als docent beoordelen?
	De meestse bestanden in dit project zijn door Lumen aangemaakt. Bestanden met zelfgeschreven code zijn voornamelijk 'routes/web.php' en 'app/Http/Controllers/voertuigenController'.