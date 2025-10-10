<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="'de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../src/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Datenschutz</title>
    <link rel="icon" type="image/x-icon" href="../src/img/bj-logo.png">
</head>

<body class="flex flex-col min-h-screen bg-green-200">
    <!-- <main class="relative flex flex-col items-center justify-center gap-y-10 flex-grow"> -->

    <header class="fixed w-full flex justify-between">
        <div class="flex gap-x-4 items-center p-4">
            <a href="../pages/home.php" class="flex item-center ">
                <img class="flex w-20 h-20 rounded-2xl" src="../src/img/bj-logo.png" alt="logo">
            </a>
            <h1 class="flex flex-col uppercase w-20 tracking-wide text-2xl leading-none font-bold">
                <a href="../pages/home.php">
                    <span>Book</span>
                    <span>loving</span>
                    <span>journal</span>
                </a>
            </h1>
        </div>

        <!-- logout-button -->
        <div class="flex gap-y-2 items-end flex-col w-60 p-4">
            <p class="">Eingeloggt als <span class="font-bold"><?php echo $_SESSION['name']; ?></span></p>

            <a href="../php/logout.php"
                class="logoutBtn justify-self-right bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a>
        </div>
    </header>
    <main class="flex flex-grow flex-col item-center justify-center px-6">
        <div id="searchDiv" class="mt-38 px-10 pb-20 flex flex-col items-start gap-y-4">
            <h2 class="text-4xl font-semibold mt-4">Datenschutzerklärung</h2>
            <h3 class="font-bold" id="m716">Präambel</h3>
            <p>Mit der folgenden Datenschutzerklärung möchten wir Sie darüber aufklären, welche Arten Ihrer
                personenbezogenen Daten (nachfolgend auch kurz als "Daten" bezeichnet) wir zu welchen Zwecken und in
                welchem
                Umfang verarbeiten. Die Datenschutzerklärung gilt für alle von uns durchgeführten Verarbeitungen
                personenbezogener Daten, sowohl im Rahmen der Erbringung unserer Leistungen als auch insbesondere auf
                unseren Webseiten, in mobilen Applikationen sowie innerhalb externer Onlinepräsenzen, wie z. B. unserer
                Social-Media-Profile (nachfolgend zusammenfassend bezeichnet als "Onlineangebot").</p>
            <p>Die verwendeten Begriffe sind nicht geschlechtsspezifisch.</p>

            <p>Stand: 8. Oktober 2025</p>
            <div>
                <h3 class="font-bold text-start">Inhaltsübersicht</h3>
                <ol class="index list-decimal">
                    <li><a class="index-link" href="#m716">Präambel</a></li>
                    <li><a class="index-link" href="#m3">Verantwortlicher</a></li>
                    <li><a class="index-link" href="#mOverview">Übersicht der Verarbeitungen</a></li>
                    <li><a class="index-link" href="#m2427">Maßgebliche Rechtsgrundlagen</a></li>
                    <li><a class="index-link" href="#m27">Sicherheitsmaßnahmen</a></li>
                    <li><a class="index-link" href="#m10">Rechte der betroffenen Personen</a></li>
                    <li><a class="index-link" href="#m134">Einsatz von Cookies</a></li>
                    <li><a class="index-link" href="#m367">Registrierung, Anmeldung und Nutzerkonto</a></li>
                    <li><a class="index-link" href="#m182">Kontakt- und Anfrageverwaltung</a></li>
                    <li><a class="index-link" href="#m15">Änderung und Aktualisierung</a></li>
                    <li><a class="index-link" href="#m42">Begriffsdefinitionen</a></li>
                </ol>
            </div>
            <h3 class="font-bold" id="m3">Verantwortlicher</h3>
            <p>Maggi Yuen<br>Steeler Str. 438<br>45138 Essen</p>
            <p>E-Mail-Adresse: <a href="mailto:yuen.maggi@icloud.com">yuen.maggi@icloud.com</a></p>

            <h3 class="font-bold" id="mOverview">Übersicht der Verarbeitungen</h3>
            <p>Die nachfolgende Übersicht fasst die Arten der verarbeiteten Daten und die Zwecke ihrer Verarbeitung
                zusammen
                und verweist auf die betroffenen Personen.</p>
            <div>
                <h3 class="font-bold">Arten der verarbeiteten Daten</h3>
                <ol class="list-disc">
                    <li>Bestandsdaten.</li>
                    <li>Kontaktdaten.</li>
                    <li>Inhaltsdaten.</li>
                    <li>Nutzungsdaten.</li>
                    <li>Meta-, Kommunikations- und Verfahrensdaten.</li>
                    <li>Protokolldaten.</li>
                </ol>
            </div>
            <h3 class="font-bold">Kategorien betroffener Personen</h3>
            <ul>
                <li>Kommunikationspartner.</li>
                <li>Nutzer.</li>
            </ul>
            <div class="">
                <h3 class="font-bold">Zwecke der Verarbeitung</h3>
                <ol class="list-disc">
                    <li>Erbringung vertraglicher Leistungen und Erfüllung vertraglicher Pflichten.</li>
                    <li>Kommunikation.</li>
                    <li>Sicherheitsmaßnahmen.</li>
                    <li>Organisations- und Verwaltungsverfahren.</li>
                    <li>Feedback.</li>
                    <li>Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.</li>
                </ol>
            </div>
            <h3 class="font-bold" id="m2427">Maßgebliche Rechtsgrundlagen</h3>
            <p><strong>Maßgebliche Rechtsgrundlagen nach der DSGVO: </strong>Im Folgenden erhalten Sie eine Übersicht
                der
                Rechtsgrundlagen der DSGVO, auf deren Basis wir personenbezogene Daten verarbeiten. Bitte nehmen Sie zur
                Kenntnis, dass neben den Regelungen der DSGVO nationale Datenschutzvorgaben in Ihrem bzw. unserem Wohn-
                oder
                Sitzland gelten können. Sollten ferner im Einzelfall speziellere Rechtsgrundlagen maßgeblich sein,
                teilen
                wir Ihnen diese in der Datenschutzerklärung mit.</p>
            <ul>
                <li><strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO)</strong> - Die betroffene Person hat ihre
                    Einwilligung in die Verarbeitung der sie betreffenden personenbezogenen Daten für einen spezifischen
                    Zweck oder mehrere bestimmte Zwecke gegeben.</li>
                <li><strong>Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO)</strong> -
                    Die
                    Verarbeitung ist für die Erfüllung eines Vertrags, dessen Vertragspartei die betroffene Person ist,
                    oder
                    zur Durchführung vorvertraglicher Maßnahmen erforderlich, die auf Anfrage der betroffenen Person
                    erfolgen.</li>
                <li><strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO)</strong> - die Verarbeitung ist
                    zur
                    Wahrung der berechtigten Interessen des Verantwortlichen oder eines Dritten notwendig,
                    vorausgesetzt,
                    dass die Interessen, Grundrechte und Grundfreiheiten der betroffenen Person, die den Schutz
                    personenbezogener Daten verlangen, nicht überwiegen.</li>
            </ul>
            <p><strong>Nationale Datenschutzregelungen in Deutschland: </strong>Zusätzlich zu den Datenschutzregelungen
                der
                DSGVO gelten nationale Regelungen zum Datenschutz in Deutschland. Hierzu gehört insbesondere das Gesetz
                zum
                Schutz vor Missbrauch personenbezogener Daten bei der Datenverarbeitung (Bundesdatenschutzgesetz –
                BDSG).
                Das BDSG enthält insbesondere Spezialregelungen zum Recht auf Auskunft, zum Recht auf Löschung, zum
                Widerspruchsrecht, zur Verarbeitung besonderer Kategorien personenbezogener Daten, zur Verarbeitung für
                andere Zwecke und zur Übermittlung sowie automatisierten Entscheidungsfindung im Einzelfall
                einschließlich
                Profiling. Ferner können Landesdatenschutzgesetze der einzelnen Bundesländer zur Anwendung gelangen.</p>
            <p><strong>Hinweis auf Geltung DSGVO und Schweizer DSG: </strong>Diese Datenschutzhinweise dienen sowohl der
                Informationserteilung nach dem Schweizer DSG als auch nach der Datenschutzgrundverordnung (DSGVO). Aus
                diesem Grund bitten wir Sie zu beachten, dass aufgrund der breiteren räumlichen Anwendung und
                Verständlichkeit die Begriffe der DSGVO verwendet werden. Insbesondere statt der im Schweizer DSG
                verwendeten Begriffe „Bearbeitung" von „Personendaten", "überwiegendes Interesse" und "besonders
                schützenswerte Personendaten" werden die in der DSGVO verwendeten Begriffe „Verarbeitung" von
                „personenbezogenen Daten" sowie "berechtigtes Interesse" und "besondere Kategorien von Daten" verwendet.
                Die
                gesetzliche Bedeutung der Begriffe wird jedoch im Rahmen der Geltung des Schweizer DSG weiterhin nach
                dem
                Schweizer DSG bestimmt.</p>

            <h3 class="font-bold" id="m27">Sicherheitsmaßnahmen</h3>
            <p>Wir treffen nach Maßgabe der gesetzlichen Vorgaben unter Berücksichtigung des Stands der Technik, der
                Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der
                unterschiedlichen Eintrittswahrscheinlichkeiten und des Ausmaßes der Bedrohung der Rechte und Freiheiten
                natürlicher Personen geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes
                Schutzniveau zu gewährleisten.</p>
            <p>Zu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von
                Daten durch Kontrolle des physischen und elektronischen Zugangs zu den Daten als auch des sie
                betreffenden
                Zugriffs, der Eingabe, der Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren
                haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, die Löschung von Daten
                und
                Reaktionen auf die Gefährdung der Daten gewährleisten. Ferner berücksichtigen wir den Schutz
                personenbezogener Daten bereits bei der Entwicklung bzw. Auswahl von Hardware, Software sowie Verfahren
                entsprechend dem Prinzip des Datenschutzes, durch Technikgestaltung und durch datenschutzfreundliche
                Voreinstellungen.</p>
            <p>Sicherung von Online-Verbindungen durch TLS-/SSL-Verschlüsselungstechnologie (HTTPS): Um die Daten der
                Nutzer, die über unsere Online-Dienste übertragen werden, vor unerlaubten Zugriffen zu schützen, setzen
                wir
                auf die TLS-/SSL-Verschlüsselungstechnologie. Secure Sockets Layer (SSL) und Transport Layer Security
                (TLS)
                sind die Eckpfeiler der sicheren Datenübertragung im Internet. Diese Technologien verschlüsseln die
                Informationen, die zwischen der Website oder App und dem Browser des Nutzers (oder zwischen zwei
                Servern)
                übertragen werden, wodurch die Daten vor unbefugtem Zugriff geschützt sind. TLS, als die
                weiterentwickelte
                und sicherere Version von SSL, gewährleistet, dass alle Datenübertragungen den höchsten
                Sicherheitsstandards
                entsprechen. Wenn eine Website durch ein SSL-/TLS-Zertifikat gesichert ist, wird dies durch die Anzeige
                von
                HTTPS in der URL signalisiert. Dies dient als ein Indikator für die Nutzer, dass ihre Daten sicher und
                verschlüsselt übertragen werden.</p>

            <h3 class="font-bold" id="m10">Rechte der betroffenen Personen</h3>
            <p>Rechte der betroffenen Personen aus der DSGVO: Ihnen stehen als Betroffene nach der DSGVO verschiedene
                Rechte
                zu, die sich insbesondere aus Art. 15 bis 21 DSGVO ergeben:</p>
            <ul>
                <li><strong>Widerspruchsrecht: Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation
                        ergeben, jederzeit gegen die Verarbeitung der Sie betreffenden personenbezogenen Daten, die
                        aufgrund
                        von Art. 6 Abs. 1 lit. e oder f DSGVO erfolgt, Widerspruch einzulegen; dies gilt auch für ein
                        auf
                        diese Bestimmungen gestütztes Profiling. Werden die Sie betreffenden personenbezogenen Daten
                        verarbeitet, um Direktwerbung zu betreiben, haben Sie das Recht, jederzeit Widerspruch gegen die
                        Verarbeitung der Sie betreffenden personenbezogenen Daten zum Zwecke derartiger Werbung
                        einzulegen;
                        dies gilt auch für das Profiling, soweit es mit solcher Direktwerbung in Verbindung
                        steht.</strong>
                </li>
                <li><strong>Widerrufsrecht bei Einwilligungen:</strong> Sie haben das Recht, erteilte Einwilligungen
                    jederzeit zu widerrufen.</li>
                <li><strong>Auskunftsrecht:</strong> Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob
                    betreffende Daten verarbeitet werden und auf Auskunft über diese Daten sowie auf weitere
                    Informationen
                    und Kopie der Daten entsprechend den gesetzlichen Vorgaben.</li>
                <li><strong>Recht auf Berichtigung:</strong> Sie haben entsprechend den gesetzlichen Vorgaben das Recht,
                    die
                    Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen
                    Daten zu verlangen.</li>
                <li><strong>Recht auf Löschung und Einschränkung der Verarbeitung:</strong> Sie haben nach Maßgabe der
                    gesetzlichen Vorgaben das Recht, zu verlangen, dass Sie betreffende Daten unverzüglich gelöscht
                    werden,
                    bzw. alternativ nach Maßgabe der gesetzlichen Vorgaben eine Einschränkung der Verarbeitung der Daten
                    zu
                    verlangen.</li>
                <li><strong>Recht auf Datenübertragbarkeit:</strong> Sie haben das Recht, Sie betreffende Daten, die Sie
                    uns
                    bereitgestellt haben, nach Maßgabe der gesetzlichen Vorgaben in einem strukturierten, gängigen und
                    maschinenlesbaren Format zu erhalten oder deren Übermittlung an einen anderen Verantwortlichen zu
                    fordern.</li>
                <li><strong>Beschwerde bei Aufsichtsbehörde:</strong> Sie haben unbeschadet eines anderweitigen
                    verwaltungsrechtlichen oder gerichtlichen Rechtsbehelfs das Recht auf Beschwerde bei einer
                    Aufsichtsbehörde, insbesondere in dem Mitgliedstaat ihres gewöhnlichen Aufenthaltsorts, ihres
                    Arbeitsplatzes oder des Orts des mutmaßlichen Verstoßes, wenn Sie der Ansicht sind, dass die
                    Verarbeitung der Sie betreffenden personenbezogenen Daten gegen die Vorgaben der DSGVO verstößt.
                </li>
            </ul>

            <h3 class="font-bold" id="m134">Einsatz von Cookies</h3>
            <p>Unter dem Begriff „Cookies" werden Funktionen, die Informationen auf Endgeräten der Nutzer speichern und
                aus
                ihnen auslesen, verstanden. Cookies können ferner in Bezug auf unterschiedliche Anliegen Einsatz finden,
                etwa zu Zwecken der Funktionsfähigkeit, der Sicherheit und des Komforts von Onlineangeboten sowie der
                Erstellung von Analysen der Besucherströme. Wir verwenden Cookies gemäß den gesetzlichen Vorschriften.
                Dazu
                holen wir, wenn erforderlich, vorab die Zustimmung der Nutzer ein. Ist eine Zustimmung nicht notwendig,
                setzen wir auf unsere berechtigten Interessen. Dies gilt, wenn das Speichern und Auslesen von
                Informationen
                unerlässlich ist, um ausdrücklich angeforderte Inhalte und Funktionen bereitstellen zu können. Dazu
                zählen
                etwa die Speicherung von Einstellungen sowie die Sicherstellung der Funktionalität und Sicherheit
                unseres
                Onlineangebots. Die Einwilligung kann jederzeit widerrufen werden. Wir informieren klar über deren
                Umfang
                und welche Cookies genutzt werden.</p>
            <p><strong>Hinweise zu datenschutzrechtlichen Rechtsgrundlagen: </strong>Ob wir personenbezogene Daten
                mithilfe
                von Cookies verarbeiten, hängt von einer Einwilligung ab. Liegt eine Einwilligung vor, dient sie als
                Rechtsgrundlage. Ohne Einwilligung stützen wir uns auf unsere berechtigten Interessen, die vorstehend in
                diesem Abschnitt und im Kontext der jeweiligen Dienste und Verfahren erläutert sind.</p>
            <p><strong>Speicherdauer: </strong>Im Hinblick auf die Speicherdauer werden die folgenden Arten von Cookies
                unterschieden:</p>
            <ul>
                <li><strong>Temporäre Cookies (auch: Session- oder Sitzungscookies):</strong> Temporäre Cookies werden
                    spätestens gelöscht, nachdem ein Nutzer ein Onlineangebot verlassen und sein Endgerät (z. B. Browser
                    oder mobile Applikation) geschlossen hat.</li>
                <li><strong>Permanente Cookies:</strong> Permanente Cookies bleiben auch nach dem Schließen des
                    Endgeräts
                    gespeichert. So können beispielsweise der Log-in-Status gespeichert und bevorzugte Inhalte direkt
                    angezeigt werden, wenn der Nutzer eine Website erneut besucht. Ebenso können die mithilfe von
                    Cookies
                    erhobenen Nutzerdaten zur Reichweitenmessung Verwendung finden. Sofern wir Nutzern keine expliziten
                    Angaben zur Art und Speicherdauer von Cookies mitteilen (z. B. im Rahmen der Einholung der
                    Einwilligung), sollten sie davon ausgehen, dass diese permanent sind und die Speicherdauer bis zu
                    zwei
                    Jahre betragen kann.</li>
            </ul>
            <p><strong>Allgemeine Hinweise zum Widerruf und Widerspruch (Opt-out): </strong>Nutzer können die von ihnen
                abgegebenen Einwilligungen jederzeit widerrufen und zudem einen Widerspruch gegen die Verarbeitung
                entsprechend den gesetzlichen Vorgaben, auch mittels der Privatsphäre-Einstellungen ihres Browsers,
                erklären.</p>
            <ul class="m-elements">
                <li><strong>Verarbeitete Datenarten:</strong> Meta-, Kommunikations- und Verfahrensdaten (z. B.
                    IP-Adressen,
                    Zeitangaben, Identifikationsnummern, beteiligte Personen).</li>
                <li><strong>Betroffene Personen:</strong> Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).
                </li>
                <li class=""><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f)
                    DSGVO).
                    Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).</li>
            </ul>
            <p><strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong></p>
            <ul class="m-elements">
                <li><strong>Verarbeitung von Cookie-Daten auf Grundlage einer Einwilligung: </strong>Wir setzen eine
                    Einwilligungs-Management-Lösung ein, bei der die Einwilligung der Nutzer zur Verwendung von Cookies
                    oder
                    zu den im Rahmen der Einwilligungs-Management-Lösung genannten Verfahren und Anbietern eingeholt
                    wird.
                    Dieses Verfahren dient der Einholung, Protokollierung, Verwaltung und dem Widerruf von
                    Einwilligungen,
                    insbesondere bezogen auf den Einsatz von Cookies und vergleichbaren Technologien, die zur
                    Speicherung,
                    zum Auslesen und zur Verarbeitung von Informationen auf den Endgeräten der Nutzer eingesetzt werden.
                    Im
                    Rahmen dieses Verfahrens werden die Einwilligungen der Nutzer für die Nutzung von Cookies und die
                    damit
                    verbundenen Verarbeitungen von Informationen, einschließlich der im
                    Einwilligungs-Management-Verfahren
                    genannten spezifischen Verarbeitungen und Anbieter, eingeholt. Die Nutzer haben zudem die
                    Möglichkeit,
                    ihre Einwilligungen zu verwalten und zu widerrufen. Die Einwilligungserklärungen werden gespeichert,
                    um
                    eine erneute Abfrage zu vermeiden und den Nachweis der Einwilligung gemäß der gesetzlichen
                    Anforderungen
                    führen zu können. Die Speicherung erfolgt serverseitig und/oder in einem Cookie (sogenanntes
                    Opt-In-Cookie) oder mittels vergleichbarer Technologien, um die Einwilligung einem spezifischen
                    Nutzer
                    oder dessen Gerät zuordnen zu können. Sofern keine spezifischen Angaben zu den Anbietern von
                    Einwilligungs-Management-Diensten vorliegen, gelten folgende allgemeine Hinweise: Die Dauer der
                    Speicherung der Einwilligung beträgt bis zu zwei Jahre. Dabei wird ein pseudonymer
                    Nutzer-Identifikator
                    erstellt, der zusammen mit dem Zeitpunkt der Einwilligung, den Angaben zum Umfang der Einwilligung
                    (z. B. betreffende Kategorien von Cookies und/oder Diensteanbieter) sowie Informationen über den
                    Browser, das System und das verwendete Endgerät gespeichert wird; <span
                        class=""><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a)
                        DSGVO).</span>
                </li>
            </ul>
            <h3 class="font-bold" id="m367">Registrierung, Anmeldung und Nutzerkonto</h3>
            <p>Nutzer können ein Nutzerkonto anlegen. Im Rahmen der Registrierung werden den Nutzern die erforderlichen
                Pflichtangaben mitgeteilt und zu Zwecken der Bereitstellung des Nutzerkontos auf Grundlage vertraglicher
                Pflichterfüllung verarbeitet. Zu den verarbeiteten Daten gehören insbesondere die Login-Informationen
                (Nutzername, Passwort sowie eine E-Mail-Adresse).</p>
            <p>Im Rahmen der Inanspruchnahme unserer Registrierungs- und Anmeldefunktionen sowie der Nutzung des
                Nutzerkontos speichern wir die IP-Adresse und den Zeitpunkt der jeweiligen Nutzerhandlung. Die
                Speicherung
                erfolgt auf Grundlage unserer berechtigten Interessen als auch jener der Nutzer an einem Schutz vor
                Missbrauch und sonstiger unbefugter Nutzung. Eine Weitergabe dieser Daten an Dritte erfolgt
                grundsätzlich
                nicht, es sei denn, sie ist zur Verfolgung unserer Ansprüche erforderlich oder es besteht eine
                gesetzliche
                Verpflichtung hierzu.</p>
            <p>Die Nutzer können über Vorgänge, die für deren Nutzerkonto relevant sind, wie z. B. technische
                Änderungen,
                per E-Mail informiert werden.</p>
            <ul class="m-elements">
                <li><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z. B. der vollständige Name, Wohnadresse,
                    Kontaktinformationen, Kundennummer, etc.); Kontaktdaten (z. B. Post- und E-Mail-Adressen oder
                    Telefonnummern); Inhaltsdaten (z. B. textliche oder bildliche Nachrichten und Beiträge sowie die sie
                    betreffenden Informationen, wie z. B. Angaben zur Autorenschaft oder Zeitpunkt der Erstellung);
                    Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz,
                    verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen).
                    Protokolldaten
                    (z. B. Logfiles betreffend Logins oder den Abruf von Daten oder Zugriffszeiten.).</li>
                <li><strong>Betroffene Personen:</strong> Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).
                </li>
                <li><strong>Zwecke der Verarbeitung:</strong> Erbringung vertraglicher Leistungen und Erfüllung
                    vertraglicher Pflichten; Sicherheitsmaßnahmen; Organisations- und Verwaltungsverfahren.
                    Bereitstellung
                    unseres Onlineangebotes und Nutzerfreundlichkeit.</li>
                <li><strong>Aufbewahrung und Löschung:</strong> Löschung entsprechend Angaben im Abschnitt "Allgemeine
                    Informationen zur Datenspeicherung und Löschung". Löschung nach Kündigung.</li>
                <li class=""><strong>Rechtsgrundlagen:</strong> Vertragserfüllung und vorvertragliche Anfragen (Art. 6
                    Abs.
                    1 S. 1 lit. b) DSGVO). Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).</li>
            </ul>
            <p><strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong></p>
            <ul class="m-elements">
                <li><strong>Profile der Nutzer sind nicht öffentlich: </strong>Die Profile der Nutzer sind öffentlich
                    nicht
                    sichtbar und nicht zugänglich.</li>
                <li><strong>Löschung von Daten nach Kündigung: </strong>Wenn Nutzer ihr Nutzerkonto gekündigt haben,
                    werden
                    deren Daten im Hinblick auf das Nutzerkonto, vorbehaltlich einer gesetzlichen Erlaubnis, Pflicht
                    oder
                    Einwilligung der Nutzer, gelöscht; <span class=""><strong>Rechtsgrundlagen:</strong>
                        Vertragserfüllung
                        und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO).</span></li>
                <li><strong>Keine Aufbewahrungspflicht für Daten: </strong>Es obliegt den Nutzern, ihre Daten bei
                    erfolgter
                    Kündigung vor dem Vertragsende zu sichern. Wir sind berechtigt, sämtliche während der Vertragsdauer
                    gespeicherte Daten des Nutzers unwiederbringlich zu löschen; <span
                        class=""><strong>Rechtsgrundlagen:</strong> Vertragserfüllung und vorvertragliche Anfragen (Art.
                        6
                        Abs. 1 S. 1 lit. b) DSGVO).</span></li>
            </ul>
            <h3 class="font-bold" id="m182">Kontakt- und Anfrageverwaltung</h3>
            <p>Bei der Kontaktaufnahme mit uns (z. B. per Post, Kontaktformular, E-Mail, Telefon oder via soziale
                Medien)
                sowie im Rahmen bestehender Nutzer- und Geschäftsbeziehungen werden die Angaben der anfragenden Personen
                verarbeitet, soweit dies zur Beantwortung der Kontaktanfragen und etwaiger angefragter Maßnahmen
                erforderlich ist.</p>
            <ul class="m-elements">
                <li><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z. B. der vollständige Name, Wohnadresse,
                    Kontaktinformationen, Kundennummer, etc.); Kontaktdaten (z. B. Post- und E-Mail-Adressen oder
                    Telefonnummern); Inhaltsdaten (z. B. textliche oder bildliche Nachrichten und Beiträge sowie die sie
                    betreffenden Informationen, wie z. B. Angaben zur Autorenschaft oder Zeitpunkt der Erstellung);
                    Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz,
                    verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen). Meta-,
                    Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern,
                    beteiligte
                    Personen).</li>
                <li><strong>Betroffene Personen:</strong> Kommunikationspartner.</li>
                <li><strong>Zwecke der Verarbeitung:</strong> Kommunikation; Organisations- und Verwaltungsverfahren;
                    Feedback (z. B. Sammeln von Feedback via Online-Formular). Bereitstellung unseres Onlineangebotes
                    und
                    Nutzerfreundlichkeit.</li>
                <li><strong>Aufbewahrung und Löschung:</strong> Löschung entsprechend Angaben im Abschnitt "Allgemeine
                    Informationen zur Datenspeicherung und Löschung".</li>
                <li class=""><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f)
                    DSGVO).
                    Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO).</li>
            </ul>
            <p><strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong></p>
            <ul class="m-elements">
                <li><strong>Kontaktformular: </strong>Bei Kontaktaufnahme über unser Kontaktformular, per E-Mail oder
                    anderen Kommunikationswegen, verarbeiten wir die uns übermittelten personenbezogenen Daten zur
                    Beantwortung und Bearbeitung des jeweiligen Anliegens. Dies umfasst in der Regel Angaben wie Name,
                    Kontaktinformationen und gegebenenfalls weitere Informationen, die uns mitgeteilt werden und zur
                    angemessenen Bearbeitung erforderlich sind. Wir nutzen diese Daten ausschließlich für den
                    angegebenen
                    Zweck der Kontaktaufnahme und Kommunikation; <span class=""><strong>Rechtsgrundlagen:</strong>
                        Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO), Berechtigte
                        Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).</span></li>
            </ul>
            <h3 class="font-bold" id="m15">Änderung und Aktualisierung</h3>
            <p>Wir bitten Sie, sich regelmäßig über den Inhalt unserer Datenschutzerklärung zu informieren. Wir passen
                die
                Datenschutzerklärung an, sobald die Änderungen der von uns durchgeführten Datenverarbeitungen dies
                erforderlich machen. Wir informieren Sie, sobald durch die Änderungen eine Mitwirkungshandlung
                Ihrerseits
                (z. B. Einwilligung) oder eine sonstige individuelle Benachrichtigung erforderlich wird.</p>
            <p>Sofern wir in dieser Datenschutzerklärung Adressen und Kontaktinformationen von Unternehmen und
                Organisationen angeben, bitten wir zu beachten, dass die Adressen sich über die Zeit ändern können und
                bitten die Angaben vor Kontaktaufnahme zu prüfen.</p>

            <h3 class="font-bold" id="m42">Begriffsdefinitionen</h3>
            <p>In diesem Abschnitt erhalten Sie eine Übersicht über die in dieser Datenschutzerklärung verwendeten
                Begrifflichkeiten. Soweit die Begrifflichkeiten gesetzlich definiert sind, gelten deren gesetzliche
                Definitionen. Die nachfolgenden Erläuterungen sollen dagegen vor allem dem Verständnis dienen.</p>
            <ul class="glossary mb-8">
                <li><strong>Bestandsdaten:</strong> Bestandsdaten umfassen wesentliche Informationen, die für die
                    Identifikation und Verwaltung von Vertragspartnern, Benutzerkonten, Profilen und ähnlichen
                    Zuordnungen
                    notwendig sind. Diese Daten können u.a. persönliche und demografische Angaben wie Namen,
                    Kontaktinformationen (Adressen, Telefonnummern, E-Mail-Adressen), Geburtsdaten und spezifische
                    Identifikatoren (Benutzer-IDs) beinhalten. Bestandsdaten bilden die Grundlage für jegliche formelle
                    Interaktion zwischen Personen und Diensten, Einrichtungen oder Systemen, indem sie eine eindeutige
                    Zuordnung und Kommunikation ermöglichen. </li>
                <li><strong>Inhaltsdaten:</strong> Inhaltsdaten umfassen Informationen, die im Zuge der Erstellung,
                    Bearbeitung und Veröffentlichung von Inhalten aller Art generiert werden. Diese Kategorie von Daten
                    kann
                    Texte, Bilder, Videos, Audiodateien und andere multimediale Inhalte einschließen, die auf
                    verschiedenen
                    Plattformen und Medien veröffentlicht werden. Inhaltsdaten sind nicht nur auf den eigentlichen
                    Inhalt
                    beschränkt, sondern beinhalten auch Metadaten, die Informationen über den Inhalt selbst liefern, wie
                    Tags, Beschreibungen, Autoreninformationen und Veröffentlichungsdaten </li>
                <li><strong>Kontaktdaten:</strong> Kontaktdaten sind essentielle Informationen, die die Kommunikation
                    mit
                    Personen oder Organisationen ermöglichen. Sie umfassen u.a. Telefonnummern, postalische Adressen und
                    E-Mail-Adressen, sowie Kommunikationsmittel wie soziale Medien-Handles und
                    Instant-Messaging-Identifikatoren. </li>
                <li><strong>Meta-, Kommunikations- und Verfahrensdaten:</strong> Meta-, Kommunikations- und
                    Verfahrensdaten
                    sind Kategorien, die Informationen über die Art und Weise enthalten, wie Daten verarbeitet,
                    übermittelt
                    und verwaltet werden. Meta-Daten, auch bekannt als Daten über Daten, umfassen Informationen, die den
                    Kontext, die Herkunft und die Struktur anderer Daten beschreiben. Sie können Angaben zur Dateigröße,
                    dem
                    Erstellungsdatum, dem Autor eines Dokuments und den Änderungshistorien beinhalten.
                    Kommunikationsdaten
                    erfassen den Austausch von Informationen zwischen Nutzern über verschiedene Kanäle, wie
                    E-Mail-Verkehr,
                    Anrufprotokolle, Nachrichten in sozialen Netzwerken und Chat-Verläufe, inklusive der beteiligten
                    Personen, Zeitstempel und Übertragungswege. Verfahrensdaten beschreiben die Prozesse und Abläufe
                    innerhalb von Systemen oder Organisationen, einschließlich Workflow-Dokumentationen, Protokolle von
                    Transaktionen und Aktivitäten, sowie Audit-Logs, die zur Nachverfolgung und Überprüfung von
                    Vorgängen
                    verwendet werden. </li>
                <li><strong>Nutzungsdaten:</strong> Nutzungsdaten beziehen sich auf Informationen, die erfassen, wie
                    Nutzer
                    mit digitalen Produkten, Dienstleistungen oder Plattformen interagieren. Diese Daten umfassen eine
                    breite Palette von Informationen, die aufzeigen, wie Nutzer Anwendungen nutzen, welche Funktionen
                    sie
                    bevorzugen, wie lange sie auf bestimmten Seiten verweilen und über welche Pfade sie durch eine
                    Anwendung
                    navigieren. Nutzungsdaten können auch die Häufigkeit der Nutzung, Zeitstempel von Aktivitäten,
                    IP-Adressen, Geräteinformationen und Standortdaten einschließen. Sie sind besonders wertvoll für die
                    Analyse des Nutzerverhaltens, die Optimierung von Benutzererfahrungen, das Personalisieren von
                    Inhalten
                    und das Verbessern von Produkten oder Dienstleistungen. Darüber hinaus spielen Nutzungsdaten eine
                    entscheidende Rolle beim Erkennen von Trends, Vorlieben und möglichen Problembereichen innerhalb
                    digitaler Angebote </li>
                <li><strong>Personenbezogene Daten:</strong> "Personenbezogene Daten" sind alle Informationen, die sich
                    auf
                    eine identifizierte oder identifizierbare natürliche Person (im Folgenden "betroffene Person")
                    beziehen;
                    als identifizierbar wird eine natürliche Person angesehen, die direkt oder indirekt, insbesondere
                    mittels Zuordnung zu einer Kennung wie einem Namen, zu einer Kennnummer, zu Standortdaten, zu einer
                    Online-Kennung (z. B. Cookie) oder zu einem oder mehreren besonderen Merkmalen identifiziert werden
                    kann, die Ausdruck der physischen, physiologischen, genetischen, psychischen, wirtschaftlichen,
                    kulturellen oder sozialen Identität dieser natürlichen Person sind. </li>
                <li><strong>Protokolldaten:</strong> Protokolldaten sind Informationen über Ereignisse oder Aktivitäten,
                    die
                    in einem System oder Netzwerk protokolliert wurden. Diese Daten enthalten typischerweise
                    Informationen
                    wie Zeitstempel, IP-Adressen, Benutzeraktionen, Fehlermeldungen und andere Details über die Nutzung
                    oder
                    den Betrieb eines Systems. Protokolldaten werden oft zur Analyse von Systemproblemen, zur
                    Sicherheitsüberwachung oder zur Erstellung von Leistungsberichten verwendet. </li>
                <li><strong>Verantwortlicher:</strong> Als "Verantwortlicher" wird die natürliche oder juristische
                    Person,
                    Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und
                    Mittel der Verarbeitung von personenbezogenen Daten entscheidet, bezeichnet. </li>
                <li><strong>Verarbeitung:</strong> "Verarbeitung" ist jeder mit oder ohne Hilfe automatisierter
                    Verfahren
                    ausgeführte Vorgang oder jede solche Vorgangsreihe im Zusammenhang mit personenbezogenen Daten. Der
                    Begriff reicht weit und umfasst praktisch jeden Umgang mit Daten, sei es das Erheben, das Auswerten,
                    das
                    Speichern, das Übermitteln oder das Löschen. </li>
            </ul>
            <p class="seal text-xs mb-4"><a href="https://datenschutz-generator.de/"
                    title="Rechtstext von Dr. Schwenke - für weitere Informationen bitte anklicken." target="_blank"
                    rel="noopener noreferrer nofollow">Erstellt mit kostenlosem Datenschutz-Generator.de von Dr. Thomas
                    Schwenke</a></p>
            </p>

            <!-- <footer class="absolute bottom-4 w-full">
            <ul class="flex justify-center gap-x-2">
                <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                    <a href="./datenschutz.php">Datenschutz</a>
                </li>
                <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                    <a href="./Barrierefreiheit.php">Barrierefreiheit</a>
                </li>
                <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                    <a href="./impressum.php">Impressum</a>
                </li>
            </ul>
        </footer> -->
        </div>
    </main>
    <!-- <footer class="relative bottom-0 h-full">
            <ul class="absolute h-full w-full bottom-0 flex justify-center items-end gap-x-2"> -->
    <footer class="flex justify-center w-full">
        <ul class="flex pb-10">
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="./datenschutz.php">Datenschutz</a>
            </li>
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="./Barrierefreiheit.php">Barrierefreiheit</a>
            </li>
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="./impressum.php">Impressum</a>
            </li>
        </ul>
    </footer>

    <script>
        // header wird weiß beim vertikalen Scrollen
        const headerStatus = document.querySelector('header');

        function scrollDown() {
            if (window.scrollY > 40) {

                // headerSttus muss das div drüber sein
                headerStatus.classList.add('bg-white');
                headerStatus.classList.add('top-0');
                headerStatus.classList.add('h-28');
                headerStatus.classList.add('transition');
                headerStatus.classList.add('duration-500');
                headerStatus.classList.add('z-10000');
                headerStatus.classList.add('opacity-90');
            } else {
                headerStatus.classList.remove('bg-white');
            }
        }

        window.addEventListener('scroll', scrollDown);

    </script>
</body>

</html>