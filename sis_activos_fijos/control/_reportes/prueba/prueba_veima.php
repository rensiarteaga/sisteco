<?php
#+-----------------------------------------------------------------+
#| AGATA Report API (http://www.agata.org.br)                      |
#| Copyleft (l) 2004  Solis - Lajeado - RS - Brasil                |
#| Licensed under GPL: http://www.fsf.org for further details      |
#+-----------------------------------------------------------------+
#| Started in  2001, August, 10                                    |
#| Author: Pablo Dall'Oglio (pablo@dalloglio.net)                  |
#+-----------------------------------------------------------------+
#| Agata Report: A Database reporting tool written in PHP-GTK      |
#| This file shows how to use AgataAPI to generate simple reports  |
#+-----------------------------------------------------------------+

# Include AgataAPI class
include_once '../../../../lib/agata/classes/core/AgataAPI.class';

# Instantiate AgataAPI
$api = new AgataAPI;
$api->setLanguage('es'); //'en', 'pt', 'es', 'de', 'fr', 'it', 'se'
$api->setReportPath('../../../modelo/_reportes/prueba/veimar.agt');
//$api->setReportPath('../../../modelo/_reportes/prueba/primer_reporte.agt');
$api->setProject('endesis');    
$api->setFormat('pdf'); // 'csv', 'txt', 'xml', 'html', 'csv', 'sxw'
//$api->setOutputPath('tmp/veimar.pdf');
//$api->setLayout('default-PDF');
//$api->setLayout('default-SXW.lay');
//var_dump($api->GetParameters());
//$api->setParameter('$city', 1);
#How to set parameters, if they exist
#$api->setParameter('$personCode', 4);
#$api->setParameter('$personName', "'mary'");

//$ok = $api->generateReport();
$ok = $api->generateDocument();
if (!$ok)
{
    echo $api->getError();
}
else
{
    // opens file dialog
    $api->fileDialog();
}
?>
