<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleXMLElement;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class voertuigenController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function krijgCSV($csv)
    {
        //De CSVs geef ik hier aan, als je iets moet wijzigen, kan het hier en hoeft het niet in de rest van het bestand
        switch ($csv)
        {
            case 'voertuigen':
                return "../data/Open_Data_RDW__Gekentekende_voertuigen.csv";
                break;
            case 'brandstof':
                return "../data/Open_Data_RDW__Gekentekende_voertuigen_brandstof.csv";
                break;
            case 'assen':
                return "../data/Open_Data_RDW__Gekentekende_voertuigen_assen.csv";
                break;
        }

    }



    public function showAllevoertuigenJson()
    {
        return response()->json($this->showAllevoertuigen());//Return de array en maak er een json van
    }

    public function showAllevoertuigenXML()
    {
        $xml_data = new SimpleXMLElement('<root/>');
        $this->array_to_xml($this->showAllevoertuigen(), $xml_data);
        print $xml_data->asXML();
    }

    public function showAllevoertuigen(): array
    {
        $i = 0;//Hiermee hou ik de counter bij
        $json = array();//Ik maak vast een lege array aan, waar ik straks alles inpleur
        $kenCSV = fopen($this->krijgCSV('voertuigen'), "r");//Haal het bestand op
        while (($kenArr = fgetcsv($kenCSV, 3000,",")) !== FALSE)//Loop door het hele bestand heen
        {
            $json[$i] = //Dit is de algemene json. Hierin stop ik alle gevonden waarden het het voertuigenbestand. Tevens stop ik $braJson en $assJson erook bij zodat alles in dezelde json komt
            [
                "Kenteken" => $kenArr[0],
                "Brandstof" => $this->showVoertuigenBrandstof($kenArr[0]),
                "Assen" => $this->showVoertuigenAssen($kenArr[0]),
                "Voertuigsoort" => $kenArr[1],
                "Merk" => $kenArr[2],
                "Handelsbenaming" => $kenArr[3],
                "Vervaldatum APK" => $kenArr[4],
                "Datum tentaamstelling" => $kenArr[5],
                "Bruto BPM" => $kenArr[6],
                "Inrichting" => $kenArr[7],
                "Aantal zitplaatsen" => $kenArr[8],
                "Eerste kleur" => $kenArr[9],
                "Tweede kleur" => $kenArr[10],
                "Aantal cilinders" => $kenArr[11],
                "Cilinderinhoud" => $kenArr[12],
                "Massa ledig voertuig" => $kenArr[13],
                "Toegestane maximum massa voertuig" => $kenArr[14],
                "Massa rijklaar" => $kenArr[15],
                "Maximum massa trekken ongeremd" => $kenArr[16],
                "Maximum massa trekken geremd" => $kenArr[17],
                "Zuinigheidslabel" => $kenArr[18],
                "Datum eerste toelating" => $kenArr[19],
                "Datum eerste afgifte Nederland" => $kenArr[20],
                "Wacht op keuren" => $kenArr[21],
                "Catalogusprijs" => $kenArr[22],
                "WAM verzekerd" => $kenArr[23],
                "Maximale constuctiesnelheid (brom/snorfiets)" => $kenArr[24],
                "Laadvermogen" => $kenArr[25],
                "Oplegger geremd" => $kenArr[26],
                "Aanhanger autonoom geremd" => $kenArr[27],
                "Aanhanger middenas geremd" => $kenArr[28],
                "Vermogen (brom/snorfiets)" => $kenArr[29],
                "Aantal staanplaatsen" => $kenArr[30],
                "Aantal deuren" => $kenArr[31],
                "Aantal wielen" => $kenArr[32],
                "Afstand hart koppeling tot achterzijden voertuig" => $kenArr[33],
                "Afstand voorzijde voertuig tot hart koppeling" => $kenArr[34],
                "Afwijkende maximum snelheid" => $kenArr[35],
                "Lengte" => $kenArr[36],
                "Breedte" => $kenArr[37],
                "Europese voertuigcategorie" => $kenArr[38],
                "Europese voertuigcategorie toevoeging" => $kenArr[39],
                "Plaats chassisnummer" => $kenArr[41],
                "Technische max. masse voertuig" => $kenArr[42],
                "Type" => $kenArr[43],
                "Type gasinstalatie" => $kenArr[44],
                "Typegoedkeuringnummer" => $kenArr[45],
                "Variant" => $kenArr[46] ?? null,
                "Uitvoering" => $kenArr[47] ?? null,
                "Volgnummer wijziging EU typegoedkeuring" => $kenArr[48] ?? null,
                "Vermogen massarijklaar" => $kenArr[49] ?? null,
                "Wielbasis" => $kenArr[50] ?? null,
                "Export indicator" => $kenArr[51] ?? null,
                "Openstaande terugroepactie indicator" => $kenArr[52] ?? null,
                "Valvaldatum tachograaf" => $kenArr[53] ?? null,
                "Taxi indicator" => $kenArr[54] ?? null,
                "Maximum massa samenstelling" => $kenArr[55] ?? null,
                "Aantal rolstoelplaatsen" => $kenArr[56] ?? null,
                "Maximum ondersteunde snelheid" => $kenArr[57] ?? null
            ];
            $i++;
        }
        fclose($kenCSV);
        return $json;
    }



    public function showEenvoertuigJson($kenteken)
    {
        $array = $this->showEenvoertuig($kenteken);
        return response()->json($array);//Return de array en maak er een json van
    }

    public function showEenvoertuigXML($kenteken)
    {
        $xml_data = new SimpleXMLElement('<root/>');
        $array = $this->showEenvoertuig($kenteken);
        $this->array_to_xml($array, $xml_data);
        print $xml_data->asXML();
    }

    public function showEenvoertuig($kenteken)
    {

        $kenCSV = fopen($this->krijgCSV('voertuigen'), "r");
        while (($kenArr = fgetcsv($kenCSV, 3000,",")) !== FALSE)
        {

            if ($kenArr[0] == $kenteken)//Deze funtie werkt hetzelfde als 'showAlleVoertuigen' alleen zit deze check erbij. Zo gaat hij alleen verder wanneer het gevonden kenteken overeenkomt met de kenteken uit de request. Deze functie is ook veel sneller omdat hij maar een keer naar brandstof en assen hoeft te zoeken i.p.v. bij ieder voertuig.
            {
                $array =
                [
                    "Kenteken" => $kenArr[0],
                    "Brandstof" => $this->showVoertuigenBrandstof($kenArr[0]),
                    "Assen" => $this->showVoertuigenAssen($kenArr[0]),
                    "Voertuigsoort" => $kenArr[1],
                    "Merk" => $kenArr[2],
                    "Handelsbenaming" => $kenArr[3],
                    "Vervaldatum APK" => $kenArr[4],
                    "Datum tentaamstelling" => $kenArr[5],
                    "Bruto BPM" => $kenArr[6],
                    "Inrichting" => $kenArr[7],
                    "Aantal zitplaatsen" => $kenArr[8],
                    "Eerste kleur" => $kenArr[9],
                    "Tweede kleur" => $kenArr[10],
                    "Aantal cilinders" => $kenArr[11],
                    "Cilinderinhoud" => $kenArr[12],
                    "Massa ledig voertuig" => $kenArr[13],
                    "Toegestane maximum massa voertuig" => $kenArr[14],
                    "Massa rijklaar" => $kenArr[15],
                    "Maximum massa trekken ongeremd" => $kenArr[16],
                    "Maximum massa trekken geremd" => $kenArr[17],
                    "Zuinigheidslabel" => $kenArr[18],
                    "Datum eerste toelating" => $kenArr[19],
                    "Datum eerste afgifte Nederland" => $kenArr[20],
                    "Wacht op keuren" => $kenArr[21],
                    "Catalogusprijs" => $kenArr[22],
                    "WAM verzekerd" => $kenArr[23],
                    "Maximale constuctiesnelheid (brom/snorfiets)" => $kenArr[24],
                    "Laadvermogen" => $kenArr[25],
                    "Oplegger geremd" => $kenArr[26],
                    "Aanhanger autonoom geremd" => $kenArr[27],
                    "Aanhanger middenas geremd" => $kenArr[28],
                    "Vermogen (brom/snorfiets)" => $kenArr[29],
                    "Aantal staanplaatsen" => $kenArr[30],
                    "Aantal deuren" => $kenArr[31],
                    "Aantal wielen" => $kenArr[32],
                    "Afstand hart koppeling tot achterzijden voertuig" => $kenArr[33],
                    "Afstand voorzijde voertuig tot hart koppeling" => $kenArr[34],
                    "Afwijkende maximum snelheid" => $kenArr[35],
                    "Lengte" => $kenArr[36],
                    "Breedte" => $kenArr[37],
                    "Europese voertuigcategorie" => $kenArr[38],
                    "Europese voertuigcategorie toevoeging" => $kenArr[39],
                    "Plaats chassisnummer" => $kenArr[41],
                    "Technische max. masse voertuig" => $kenArr[42],
                    "Type" => $kenArr[43],
                    "Type gasinstalatie" => $kenArr[44],
                    "Typegoedkeuringnummer" => $kenArr[45],
                    "Variant" => $kenArr[46] ?? null,
                    "Uitvoering" => $kenArr[47] ?? null,
                    "Volgnummer wijziging EU typegoedkeuring" => $kenArr[48] ?? null,
                    "Vermogen massarijklaar" => $kenArr[49] ?? null,
                    "Wielbasis" => $kenArr[50] ?? null,
                    "Export indicator" => $kenArr[51] ?? null,
                    "Openstaande terugroepactie indicator" => $kenArr[52] ?? null,
                    "Valvaldatum tachograaf" => $kenArr[53] ?? null,
                    "Taxi indicator" => $kenArr[54] ?? null,
                    "Maximum massa samenstelling" => $kenArr[55] ?? null,
                    "Aantal rolstoelplaatsen" => $kenArr[56] ?? null,
                    "Maximum ondersteunde snelheid" => $kenArr[57] ?? null
                ];
                return $array;
            }
        }
        fclose($kenCSV);
    }



    public function showVoertuigenAssenJson($kenteken = null)
    {
        return response()->json($this->showVoertuigenAssen($kenteken));//Return de array en maak er een json van
    }

    public function showVoertuigenAssenXml($kenteken = null)
    {
        $xml_data = new SimpleXMLElement('<root/>');
        $array = $this->showVoertuigenAssen($kenteken);
        $this->array_to_xml($array, $xml_data);
        print $xml_data->asXML();
    }

    public function showVoertuigenAssen($kenteken = null)
    {
        $i = 0;//Hiermee hou ik de counter bij
        $array = array();//Ik maak vast een lege array aan, waar ik straks alles inpleur
        $kenCSV = fopen($this->krijgCSV('assen'), "r");//Haal het bestand op
        while (($assArr = fgetcsv($kenCSV, 3000,",")) !== FALSE)//Loop door het hele bestand heen
        {
            if (isset($kenteken))
            {
                if ($assArr[0] == $kenteken)
                {
                    $array[$i] = //Dit is de algemene json. Hierin stop ik alle gevonden waarden het het voertuigenbestand. Tevens stop ik $braJson en $assJson erook bij zodat alles in dezelde json komt
                        [
                            "Kenteken" => $assArr[0],
                            "As nummer" => $assArr[1] ?? null,
                            "Aantal assen" => $assArr[2] ?? null,
                            "Aangedreven as" => $assArr[3] ?? null,
                            "Hefas" => $assArr[4] ?? null,
                            "Plaatscode as" => $assArr[5] ?? null,
                            "Spoorbreedte" => $assArr[6] ?? null,
                            "Weggedrag code" => $assArr[7] ?? null,
                            "Wettelijk Toegestane maximum aslast" => $assArr[8] ?? null,
                            "Technisch Toegestane maximum aslast" => $assArr[9] ?? null
                        ];
                }
            }
            else
            {
                $array[$i] = //Dit is de algemene json. Hierin stop ik alle gevonden waarden het het voertuigenbestand. Tevens stop ik $braJson en $assJson erook bij zodat alles in dezelde json komt
                    [
                        "Kenteken" => $assArr[0],
                        "As nummer" => $assArr[1] ?? null,
                        "Aantal assen" => $assArr[2] ?? null,
                        "Aangedreven as" => $assArr[3] ?? null,
                        "Hefas" => $assArr[4] ?? null,
                        "Plaatscode as" => $assArr[5] ?? null,
                        "Spoorbreedte" => $assArr[6] ?? null,
                        "Weggedrag code" => $assArr[7] ?? null,
                        "Wettelijk Toegestane maximum aslast" => $assArr[8] ?? null,
                        "Technisch Toegestane maximum aslast" => $assArr[9] ?? null
                    ];
            }
            $i++;
        }
        fclose($kenCSV);
        return $array;
    }//cd /dC:\xampp\htdocs\Github\Data\Deel 2\dataprocessing
    //>php -S localhost:8000 -t public


    public function showVoertuigenBrandstofJson($kenteken = null)
    {
        return response()->json($this->showVoertuigenBrandstof($kenteken));//Return de array en maak er een json van
    }

    public function showVoertuigenBrandstofXml($kenteken = null)
    {
        $xml_data = new SimpleXMLElement('<root/>');
        $array = $this->showVoertuigenBrandstof($kenteken);
        $this->array_to_xml($array, $xml_data);
        print $xml_data->asXML();
    }

    public function showVoertuigenBrandstof($kenteken = null): array
    {
        $i = 0;//Hiermee hou ik de counter bij
        $array = array();//Ik maak vast een lege array aan, waar ik straks alles inpleur
        $kenCSV = fopen($this->krijgCSV('brandstof'), "r");//Haal het bestand op
        while (($braArr = fgetcsv($kenCSV, 3000,",")) !== FALSE)//Loop door het hele bestand heen
        {
            if (isset($kenteken))
            {
                if ($braArr[0] == $kenteken)
                {
                    $array[$i] = //Dit is de algemene json. Hierin stop ik alle gevonden waarden het het voertuigenbestand. Tevens stop ik $braJson en $assJson erook bij zodat alles in dezelde json komt
                        [
                            "Kenteken" => $braArr[0],
                            "Brandstof volgnummer" => $braArr[1] ?? null,
                            "Brandstof omschrijving" => $braArr[2] ?? null,
                            "Brandstofverbruik buiten de stad" => $braArr[3] ?? null,
                            "Brandstofverbruik gecombineerd" => $braArr[4] ?? null,
                            "Brandstofverbruik stad" => $braArr[5] ?? null,
                            "CO2 uitstoot gecombineerd" => $braArr[6] ?? null,
                            "Geluidsniveau rijdend" => $braArr[8] ?? null,
                            "Geluidsniveau stationair" => $braArr[9] ?? null,
                            "Emissieklasse" => $braArr[10] ?? null,
                            "Milliueklasse EG Goedkeuring(licht)" => $braArr[11] ?? null,
                            "Milliueklasse EG Goedkeuring(zwaar)" => $braArr[12] ?? null,
                            "Uitstoot deeltjes(licht)" => $braArr[13] ?? null,
                            "Nettomaximumvermogen" => $braArr[15] ?? null,
                            "Roetuitstoot" => $braArr[17] ?? null,
                            "Toerental geluidsniveau" => $braArr[18] ?? null
                        ];
                    $i++;
                }
            }
            else
            {
                $array[$i] = //Dit is de algemene json. Hierin stop ik alle gevonden waarden het het voertuigenbestand. Tevens stop ik $braJson en $assJson erook bij zodat alles in dezelde json komt
                    [
                        "Kenteken" => $braArr[0],
                        "Brandstof volgnummer" => $braArr[1] ?? null,
                        "Brandstof omschrijving" => $braArr[2] ?? null,
                        "Brandstofverbruik buiten de stad" => $braArr[3] ?? null,
                        "Brandstofverbruik gecombineerd" => $braArr[4] ?? null,
                        "Brandstofverbruik stad" => $braArr[5] ?? null,
                        "CO2 uitstoot gecombineerd" => $braArr[6] ?? null,
                        "Geluidsniveau rijdend" => $braArr[8] ?? null,
                        "Geluidsniveau stationair" => $braArr[9] ?? null,
                        "Emissieklasse" => $braArr[10] ?? null,
                        "Milliueklasse EG Goedkeuring(licht)" => $braArr[11] ?? null,
                        "Milliueklasse EG Goedkeuring(zwaar)" => $braArr[12] ?? null,
                        "Uitstoot deeltjes(licht)" => $braArr[13] ?? null,
                        "Nettomaximumvermogen" => $braArr[15] ?? null,
                        "Roetuitstoot" => $braArr[17] ?? null,
                        "Toerental geluidsniveau" => $braArr[18] ?? null
                    ];
                $i++;
            }
        }
        fclose($kenCSV);
        return $array;
    }



    public function maakJson(Request $request)
    {
        $json = $request->input();//Hier haal ik de json op die is meegegeven in de post
        print_r($json);
        $array = json_decode(json_encode($json),true);//Als ik hem een keer decodeer werkt het niet. Ik moet hem encoden en dan weer terugdecoderen
        $this->maak($array);
    }

    public function maakXml(Request $request)
    {
        $input = $request->getContent();
        $array = $this->xml_to_array($input);
        $this->maak($array);
    }

    public function maak($array)
    {
        print_r($array);
        $this->maakAlgemeen($array, 'voertuigen', $array['Kenteken']);
        if (isset($array['Assen']))
            $this->maakAlgemeen($array['Assen'], 'assen', $array['Kenteken']);
        if (isset($array['Brandstof']))
            $this->maakAlgemeen($array['Brandstof'], 'brandstof', $array['Kenteken']);
    }


    public function maakAssenJson(Request $request)
    {
        //Ik haal hier een json op uit de request, die data schrijf ik vervolgns in de CSVs. Ik lees de json uit op key, de volgorde maakt dus niet uit waarin de json is opgestled.
        $json = $request->input();//Hier haal ik de json op die is meegegeven in de post
        $array = json_decode(json_encode($json),true);//Als ik hem een keer decodeer werkt het niet. Ik moet hem encoden en dan weer terugdecoderen
        $this->maakAlgemeen($array, 'assen', $array['Kenteken']);
    }

    public function maakAssenXml(Request $request)
    {
        $input = $request->getContent();
        $array = $this->xml_to_array($input);
        $this->maakAlgemeen($array, 'assen', $array['Kenteken']);
    }


    public function maakBrandstofJson(Request $request)
    {
        //Ik haal hier een json op uit de request, die data schrijf ik vervolgns in de CSVs. Ik lees de json uit op key, de volgorde maakt dus niet uit waarin de json is opgestled.
        $json = $request->input();//Hier haal ik de json op die is meegegeven in de pos
        $array = json_decode(json_encode($json),true);//Als ik hem een keer decodeer werkt het niet. Ik moet hem encoden en dan weer terugdecoderen
        $this->maakAlgemeen($array, 'assen', $array['Kenteken']);
    }

    public function maakBrandstofXml(Request $request)
    {
        $input = $request->getContent();
        $array = $this->xml_to_array($input);
        $this->maakAlgemeen($array, 'brandstof', $array['Kenteken']);
    }


    public function maakAlgemeen($array, $CSV, $kenteken)
    {
        $kenCSV = fopen($this->krijgCSV($CSV), "r");//Haal het bestand op
        $arrayEerstelijn = (fgetcsv($kenCSV, 3000,","));

        $kenArr[0] = $kenteken;
        $counter = 0;
        foreach ($arrayEerstelijn as $waardeEerstelijn)
        {
            $waardeEerstelijn = str_replace("_", " ", $waardeEerstelijn);
            foreach ($array as $key => $waarde)
            {
                if ($waardeEerstelijn == $key)
                    $kenArr[$counter] = $waarde;
            }
            $counter++;
        }

        $file = fopen($this->krijgCSV($CSV), 'a');
        fputcsv($file, $kenArr);
        fclose($file);
    }



    public function delete($kenteken)
    {
        $this->deleteAlgemeen($kenteken, 'voertuigen');
        $this->deleteAlgemeen($kenteken, 'assen');
        $this->deleteAlgemeen($kenteken, 'brandstof');
    }

    public function deleteAssen($kenteken)
    {
        $this->deleteAlgemeen($kenteken, 'assen');
    }

    public function deleteBrandstof($kenteken)
    {
        $this->deleteAlgemeen($kenteken, 'brandstof');
    }

    public function deleteAlgemeen($kenteken, $CSV)
    {
        $array = [];
        $file = fopen($this->krijgCSV($CSV), 'r');
        while (($lijn = fgetcsv($file, 3000,",")) !== FALSE)
        {
            array_push($array, $lijn);
        }
        fclose($file);
        $k=0;
        foreach ($array as &$waarde)
        {
            if ($waarde[0] === $kenteken)
            {
                unset($array[$k]);
                array_values($array);
                $file = fopen($this->krijgCSV($CSV), 'w');
                foreach ($array as $line)
                {
                    fputcsv($file, $line);
                }
                fclose($file);
                break;
            }
            $k++;
        }
    }



    public function updateJson(Request $request, $kenteken)
    {
        //Deze functie is nogal ingewikkeld, het is in feite een combi tussen 'maak' en 'delete'
        $json = $request->input();//Hier haal ik de json op die is meegegeven in de post
        $jsonArray = json_decode(json_encode($json),true);//Als ik hem een keer decodeer werkt het niet. Ik moet hem encoden en dan weer terugdecoderen
        $this->update($jsonArray, $kenteken);
    }

    public function updateXML(Request $request, $kenteken)
    {
        $input = $request->getContent();
        $array = $this->xml_to_array($input);
        $this->update($array, $kenteken);
    }

    public function update($array, $kenteken)
    {
        $this->updateAlgemeen($array, $kenteken, 'voertuigen');

        //Assen updaten
        if (array_key_exists('Assen', $array))//Als er een key 'brandstof' is meegestuurd, willen we blijkbaar de bradstof updaten. Als dit niet het geval is, hoeven we niks up te daten.
            $this->updateAlgemeen($array['Assen'], $kenteken, 'assen');

        //Brandstof updaten
        if (array_key_exists('Brandstof', $array))//Als er een key 'brandstof' is meegestuurd, willen we blijkbaar de bradstof updaten. Als dit niet het geval is, hoeven we niks up te daten.
            $this->updateAlgemeen($array['Brandstof'], $kenteken, 'brandstof');
    }


    public function updateAssenJson(Request $request, $kenteken)
    {
    //Deze functie is nogal ingewikkeld, het is in feite een combi tussen 'maak' en 'delete'
    $json = $request->input();//Hier haal ik de json op die is meegegeven in de post

    $jsonArray = json_decode(json_encode($json),true);//Als ik hem een keer decodeer werkt het niet. Ik moet hem encoden en dan weer terugdecoderen

    $this->updateAlgemeen($jsonArray, $kenteken, 'assen');
    }

    public function updateAssenXml(Request $request, $kenteken)
    {
        $input = $request->getContent();
        $array = $this->xml_to_array($input);
        $this->updateAlgemeen($array, $kenteken, 'assen');
    }


    public function updateBrandstofJson(Request $request, $kenteken)
    {
        //Deze functie is nogal ingewikkeld, het is in feite een combi tussen 'maak' en 'delete'
        $json = $request->input();//Hier haal ik de json op die is meegegeven in de post
        $jsonArray = json_decode(json_encode($json),true);//Als ik hem een keer decodeer werkt het niet. Ik moet hem encoden en dan weer terugdecoderen
        $this->updateAlgemeen($jsonArray, $kenteken, 'brandstof');
    }

    public function updateBrandstofXml(Request $request, $kenteken)
    {
        $input = $request->getContent();
        $array = $this->xml_to_array($input);
        $this->updateAlgemeen($array, $kenteken, 'brandstof');
    }


    public function updateAlgemeen($inputArray, $kenteken, $CSV)
    {
        $outputArray = [];
        $file = fopen($this->krijgCSV($CSV), 'r');
        while (($lijn = fgetcsv($file, 3000,",")) !== FALSE)
        {
            array_push($outputArray, $lijn);
        }
        fclose($file);
        $i=0;
        foreach ($outputArray as $voertuig)
        {
            if ($voertuig[0] === $kenteken)
            {
                foreach ($inputArray as $inputKey => $inputValue)
                {
                    foreach ($outputArray[0] as $voertuigKey => $voertuigValue)
                    {
                        if ($inputKey == $voertuigValue)
                        {
                            $outputArray[$i][$voertuigKey] = $inputValue;
                        }
                    }
                }
                $file = fopen($this->krijgCSV($CSV), 'w');
                foreach ($outputArray as $line)
                {
                    fputcsv($file, $line);
                }
                fclose($file);
                break;
            }
            $i++;
        }
    }



    function array_to_xml($data, &$xml_data )
    {
        foreach($data as $key => $value )
        {
            $key = str_replace(" ", "_", $key);
            if (is_array($value) || strval($value))
            {
                if( is_array($value))
                {
                    if( is_numeric($key))
                    {
                        $key = 'item'.$key; //dealing with <0/>..<n/> issues
                    }
                    $subnode = $xml_data->addChild($key);
                    $this->array_to_xml($value, $subnode);
                }
                else
                {
                    $xml_data->addChild("$key",htmlspecialchars("$value"));
                }
            }
        }
    }

    function xml_to_array($input): array
    {
        $xml = simplexml_load_string($input, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        return $array;
    }
}
