# Platypurse Dokumentation
## inf016 Webprogrammierung - Gruppe K
### [Malte Grave](https://github.com/daylien), [Tim Hesse](https://github.com/derPiepmatz), [Marvin Kuhlmann](https://github.com/ceitcher)

![Logo](public/assets/logo/png/logo_text.png)



# Inhaltsverzeichnis
1. [Generelles](#generelles)
2. [Konfiguration](#konfiguration)
    1. [PHP.ini](#phpini)
    2. [Apache](#apache)
    3. [Installation](#installation)
    4. [Testen](#testen)
3. [Features](#features)
4. [Aufgaben und Korrektheit](#aufgaben-und-korrektheit)
5. [Fehler oder Mängel](#fehler-oder-mngel)


# Generelles

Wir freuen uns, euch unsere fertige Abgabe nun zur Verfügung zu stellen. Wir bitten euch dieses Dokument komplett durchzulesen, damit keine ungewollten Nebeneffekte oder Situationen
bei der benutzung der Webseite entstehen. Bei Fragen oder evtl. sogar Fehler bitten wir euch, uns zu Kontaktieren. Vielen Dank!



# Konfiguration

Um dieses Projekt erfolgreich zu starten, müssen wir zum Anfang erst einige Einstellungen bei unserem Webserver vornehmen.
Wir gehen davon aus, das die Installation über XAMPP erfolgt, da dies am Anfang der Vorlesungen gesagt wurde. Wir unterstützen zwar Docker aber
es wurde gesagt, das keine Docker Konfiguration als Abgabe akzeptiert wird, als wir dies explizit nachgefragt haben.

## PHP.ini

Die PHP.ini fällt recht leer aus, es muss hier lediglich die Upload funktion aktiviert werden. Dazu bitte folgendes in die .ini Datei schreiben.
````ini
"file_uploads = On"
````
Das war es schon. Kurz und schmerzlos.

## Apache

Bei dem Apache Webserver müssen wir mehr Einstellungen vornehmen, das hat einen speziellen Grund. Da wir unser Projekt als MVC-Framework aufgesetzt haben, wir mappen die URL relativ und 
Apache löst die URL dann entsprechend
immer auf unsere ``index.php`` auf.

Um ``mod_rewrite`` zu aktivieren bitte Folgendes in die ``httpd.conf`` eingeben.


Unter XAMPP:
````ini
LoadModule rewrite_module modules/mod_rewrite.so
````

Wenn VHost benutzt werden, bitte das ``DocumentRoot`` Anpassen, wir gehen aber davon aus, dass das Projekt sofort in dem ``htdocs`` Ordner von XAMPP landet!


## Installation

Die ``.zip`` Datei könnt ihr einfach in euren XAMPP root ``(htdocs)`` Ordner kopieren und entpacken. Danach könnt ihr auf den Webserver zugreifen, Standardmäßig ist dies die Adresse: ``http://localhost``. Es dauert einige Sekunden beim ersten Start, da die
komplette Datenbank erstellt und mit Daten aufgefüllt wird. Danach solltet ihr auf die Startseite gelangen. Wenn dies geklappt hat, könnt ihr nun alles ausgiebig testen!

## Testen

Um die Webseite vollständig zu testen, stellen wir euch Standartbenutzer zur verfügung.

* Administrator (Super User)
  * Administrator
    * E-Mail: admin@platypurse.com
    * Passwort: 123

* Benutzer (Normale User)
  * SchnabelFan1337
    * E-Mail: schnabelfan@ymail.com
    * Passwort: 123
  * ShadowStabber69_HD
    * E-Mail: yrtwk@gmail.com
    * Passwort: 123
  * Harald
    * E-Mail: harald.haraldsen@outlook.com
    * Passwort: 123

* Support (Spezieller User)
  * Support
    * E-Mail: support@platypurse.com
    * Passwort: 123


# Features

Um euch einen groben Überblick zu beschaffen, haben wir für euch eine Sitemap gebastelt die, die grundlegende Seite darstellt.

![Sitemap](docs/readme/sitemap.svg)

Es folgt eine Liste von Feature-implemtierungen, die wir bei der Seite vorgenommen haben.

## Funktionen

* Login
* Registrierung
* Password vergessen
* Eine Pseudo E-Mail
* Angebote erstellen, bearbeiten und löschen
* Nutzerrechte
* Einen echtzeit Chat
* Eine Standortkarte
* Benutzer bannen
* Eine Merkliste
* Pagination
* Dynamische Suche
* XSS-Protection
* CSRF-Protection
* Dark und Light-Mode


# Aufgaben und Korrektheit

Wir haben jedes Aufgabenblatt durchgearbeitet und haben so weit alle geforderten inhalte mit eingepflegt oder implementiert.
Von unserer Seite können wir keine mängel festellen. 

# Fehler oder Mängel

Uns sind keine fehler mehr nach der Testphase aufgefallen, das hat aber nichts zu bedeuten. Es kann immer sein, das sich hier und dort Fehler einschleichen.
