<!-- source template: wad_about.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>WAD-QC</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff">

<table cellspacing="0" cellpadding="0" align="left" width="100%">
  <tr>
    <td> <img src="{$main_logo}" align="left" border="0" > </td>
  </tr>
  <tr>
    <td class="table_data_blue_header">
      <br>WAD-QC
    </td>
  </tr>
  <tr>
    <td class="table_data">
      De WAD-QC software is geinitieerd vanuit de <a href="http://www.nvkf.nl" target="_blank" class="table_data_select" type="text/html">NVKF</a>
      Werkgroep Apparatuur in de Diagnostiek (WAD) voor het automatiseren van kwaliteitscontroles voor beeldvormende apparatuur. De software is bedoeld om DICOM beelden
      te ontvangen, deze vervolgens volledig automatisch te analysen door een analyse module, en de resultaten hiervan beschikbaar te maken in een database.
      
      <br>Deze web interface maakt het mogelijk om enerzijds een analyse module te koppelen aan DICOM beelden met een bepaald kenmerk, en anderzijds de resultaten van de 
      analyses te bekijken. De analyse modules zelf moeten worden geupload als executable file, deze zijn strikt genomen geen onderdeel van de WAD-QC software.
    </td>
  </tr>
  <tr>
    <td class="table_data_blue_header">
      <br>Disclaimer
    </td>
  </tr>
  <tr>
    <td class="table_data">
      De gebruiker van de informatie op dit software platform is geheel zelf verantwoordelijk voor handelen op basis van de op of via de website beschikbare informatie. De NVKF aanvaardt geen aansprakelijkheid voor enige directe of indirecte schade op welke wijze ook ontstaan, als gevolg van gebruik van op de site beschikbare informatie of het om welke reden dan ook niet beschikbaar zijn of niet - behoorlijk - functioneren van de website, database en/of achterliggende applicaties.
    </td>
  </tr>

  <tr>
    <td class="table_data_blue_header">
      <br>WAD-QC - Copyright (C) 2012-2013 - NVKF Werkgroep Apparatuur in de Diagnostiek
    </td>
  </tr>
  <tr>
    <td class="table_data">
      WAD Initiatief: KlaasJan Renema, Jurgen Mourik en Arjen Becht
      <br>WAD Software Ontwikkelaars: Ralph Berendsen, Anne Talsma, Tim de Wit, Bart Titulaer, Joost Kuijer.
      <br>WAD Software Leden: Niels Matheijssen, Leo Romijn, Bart van Rooijen, Michiel Sinaasappel.
      <br>
    </td>
  </tr>
  <tr>
    <td class="table_data">
      Dit programma is gratis software; je kan het herdistribueren en/of veranderen onder de clausules van de GNU General Public License zoals gepubliceerd bij de Free Software Foundation; zowel versie 3 van de Licentie als (naargelang je eigen voorkeur) enige latere versie.
      <br>Dit programma is gedistribueerd in de hoop dat het bruikbaar is, maar ZONDER ENIGE GARANTIE; zonder maar ook de geimpliceerde garantie van VERKOOP, of DEGELIJKHEID VOOR EEN BEPAALD DOELEIND. Zie de <a href="http://www.gnu.org/licenses/">GNU General Public License</a> voor meer details.
    </td>
  </tr>
</table>

<br>

<table cellspacing="0" cellpadding="0" align="left">
  <tr>
    <td class="table_data_blue_header" colspan="3">
      <br>{$versions_title}
    </td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>

{$versions_list}
</table>
   
</body>
</html>
