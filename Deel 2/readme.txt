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


Welke bestanden moet ik als docent beoordelen?
	De meestse bestanden in dit project zijn door Lumen aangemaakt. Bestanden met zelfgeschreven code zijn voornamelijk 'routes/web.php' en 'app/Http/Controllers/voertuigenController'.