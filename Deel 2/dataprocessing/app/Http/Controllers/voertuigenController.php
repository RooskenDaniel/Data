<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function showAllevoertuigen()
    {
        ini_set('max_execution_time', 3000); // Ik zet de maximale executietijd op 15 min. De stock 2 min. zijn te kort om het hele bestand door de lezen.
        $i = 0;//Hiermee hou ik de counter bij
        $json = array();//Ik maak vast een lege array aan, waar ik straks alles inpleur
        $kenCSV = fopen($this->krijgCSV('voertuigen'), "r");//Haal het bestand op
        while (($kenArr = fgetcsv($kenCSV, 3000,",")) !== FALSE)//Loop door het hele bestand heen
        {  
            //Brandstof ophalen
            $braCSV = fopen($this->krijgCSV('brandstof'), "r");
            $braArr = array();//Deze array is speciaal gemaakt voor de brandstof
            while (($braArr = fgetcsv($braCSV, 3000,",")) !== FALSE)
            {
                if ($braArr[0] == $kenArr[0])//In zowel het algemene voertuigenbestand als het speciale brandstofbestand staat kenteken op nummer [0]. Als deze gelijk aan elkaar zijn, hebben we dus met hetzelfde voertuig te maken
                {
                    $braJson = //Ik stop alle gevonden gegeven hierin, later maak ik er een json van
                    [
                        "Brandstof volgnummer" => $braArr[1],
                        "Brondstof omschrijving" => $braArr[2],
                        "Brandstofverbruik buiten de stad" => $braArr[3],
                        "Brandstofverbruik gecombineerd" => $braArr[4],
                        "Brandstofverbruik stad" => $braArr[5],
                        "CO2 uitstoot gecombineerd" => $braArr[6],
                        "Geluidsniveau rijdend" => $braArr[8],
                        "Geluidsniveau stationair" => $braArr[9],
                        "Emissieklasse" => $braArr[10],
                        "Milliueklasse EG Goedkeuring(licht)" => $braArr[11],
                        "Milliueklasse EG Goedkeuring(zwaar)" => $braArr[12],
                        "Uitstoot deeltjes(licht)" => $braArr[13],
                        "Nettomaximumvermogen" => $braArr[15],
                        "Roetuitstoot" => $braArr[17],
                        "Toerental eluidsniveau" => $braArr[18]
                    ];
                    break;
                }
            }
            fclose($braCSV);//Netjes afsluiten


            //Assen ophalen     //Dit werkt behoorlijk hetzelfde als 'Brandstof ophalen'
            $assCSV = fopen($this->krijgCSV('assen'), "r");
            $assJson = "";
            while (($assArr = fgetcsv($assCSV, 3000,",")) !== FALSE)
            {
                if ($assArr[0] == $kenArr[0])
                {
                    $assJson = 
                    [
                        "As nummer" => $assArr[1],
                        "Aantal assen" => $assArr[2],
                        "Aangedreven as" => $assArr[3],
                        "Hefas" => $assArr[4],
                        "Plaatscode as" => $assArr[5],
                        "Spoorbreedte" => $assArr[6],
                        "Weggedrag code" => $assArr[7],
                        "Wettelijk Toegestane maximum aslast" => $assArr[8],
                        "Technisch Toegestane maximum aslast" => $assArr[9]
                    ];
                    break;
                }
            }
            fclose($assCSV);


            $json[$i] = //Dit is de algemene json. Hierin stop ik alle gevonden waarden het het voertuigenbestand. Tevens stop ik $braJson en $assJson erook bij zodat alles in dezelde json komt
            [
                "Kenteken" => $kenArr[0],
                "Brandstof" => $braJson,
                "Assen" => $assJson,
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
                "Variant" => $kenArr[46],
                "Uitvoering" => $kenArr[47],
                "Volgnummer wijziging EU typegoedkeuring" => $kenArr[48],
                "Vermogen massarijklaar" => $kenArr[49],
                "Wielbasis" => $kenArr[50],
                "Export indicator" => $kenArr[51],
                "Openstaande terugroepactie indicator" => $kenArr[52],
                "Valvaldatum tachograaf" => $kenArr[53],
                "Taxi indicator" => $kenArr[54],
                "Maximum massa samenstelling" => $kenArr[55],
                "Aantal rolstoelplaatsen" => $kenArr[56],
                "Maximum ondersteunde snelheid" => $kenArr[57]
            ];
            $i++;
        }
        return response()->json($json);//Return de array en maak er een json van
        fclose($kenCSV);;
    }

    public function showEenvoertuig($kenteken)
    {

        $kenCSV = fopen($this->krijgCSV('voertuigen'), "r");
        while (($kenArr = fgetcsv($kenCSV, 3000,",")) !== FALSE)
        {
            
            if ($kenArr[0] == $kenteken)//Deze funtie werkt hetzelfde als 'showAlleVoertuigen' alleen zit deze check erbij. Zo gaat hij alleen verder wanneer het gevonden kenteken overeenkomt met de kenteken uit de request. Deze functie is ook veel sneller omdat hij maar een keer naar brandstof en assen hoeft te zoeken i.p.v. bij ieder voertuig.
            {
                //Brandstof ophalen
                $braCSV = fopen($this->krijgCSV('brandstof'), "r");
                $braJson = "";
                while (($braArr = fgetcsv($braCSV, 3000,",")) !== FALSE)
                {  
                    $Json = "";
                    if ($braArr[0] == $kenteken)
                    {
                        $braJson = 
                        [
                            "Brandstof volgnummer" => $braArr[1],
                            "Brondstof omschrijving" => $braArr[2],
                            "Brandstofverbruik buiten de stad" => $braArr[3],
                            "Brandstofverbruik gecombineerd" => $braArr[4],
                            "Brandstofverbruik stad" => $braArr[5],
                            "CO2 uitstoot gecombineerd" => $braArr[6],
                            "Geluidsniveau rijdend" => $braArr[8],
                            "Geluidsniveau stationair" => $braArr[9],
                            "Emissieklasse" => $braArr[10],
                            "Milliueklasse EG Goedkeuring(licht)" => $braArr[11],
                            "Milliueklasse EG Goedkeuring(zwaar)" => $braArr[12],
                            "Uitstoot deeltjes(licht)" => $braArr[13],
                            "Nettomaximumvermogen" => $braArr[15],
                            "Roetuitstoot" => $braArr[17],
                            "Toerental eluidsniveau" => $braArr[18]
                        ];
                        break;
                    }
                }
                fclose($braCSV);


                //Assen ophalen
                $assCSV = fopen($this->krijgCSV('assen'), "r");
                $assJson = "";
                while (($assArr = fgetcsv($assCSV, 3000,",")) !== FALSE)
                {
                    if ($assArr[0] == $kenteken)
                    {
                        $assJson = 
                        [
                            "As nummer" => $assArr[1],
                            "Aantal assen" => $assArr[2],
                            "Aangedreven as" => $assArr[3],
                            "Hefas" => $assArr[4],
                            "Plaatscode as" => $assArr[5],
                            "Spoorbreedte" => $assArr[6],
                            "Weggedrag code" => $assArr[7],
                            "Wettelijk Toegestane maximum aslast" => $assArr[8],
                            "Technisch Toegestane maximum aslast" => $assArr[9]
                        ];
                        break;
                    }
                }
                fclose($assCSV);


                $json =
                [
                    "Kenteken" => $kenArr[0],
                    "Brandstof" => $braJson,
                    "Assen" => $assJson,
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
                    "Variant" => $kenArr[46],
                    "Uitvoering" => $kenArr[47],
                    "Volgnummer wijziging EU typegoedkeuring" => $kenArr[48],
                    "Vermogen massarijklaar" => $kenArr[49],
                    "Wielbasis" => $kenArr[50],
                    "Export indicator" => $kenArr[51],
                    "Openstaande terugroepactie indicator" => $kenArr[52],
                    "Valvaldatum tachograaf" => $kenArr[53],
                    "Taxi indicator" => $kenArr[54],
                    "Maximum massa samenstelling" => $kenArr[55],
                    "Aantal rolstoelplaatsen" => $kenArr[56],
                    "Maximum ondersteunde snelheid" => $kenArr[57]
                ];
                return response()->json($json);
                break;
            }
        }
        fclose($kenCSV);
    }
    
    public function maak(Request $request)
    {
        //Ik haal hier een json op uit de request, die data schrijf ik vervolgns in de CSVs. Ik lees de json uit op key, de volgorde maakt dus niet uit waarin de json is opgestled.
        $json = $request->input();//Hier haal ik de json op die is meegegeven in de post

        $array = json_decode(json_encode($json),true);//Als ik hem een keer decodeer werkt het niet. Ik moet hem encoden en dan weer terugdecoderen


        //Het wegschrijven naar gekentekende voertuigen
        $kenArr[0] = $array['Kenteken'];
        $kenArr[1] = $array['Voertuigsoort'];
        $kenArr[2] = $array['Merk'];
        $kenArr[3] = $array['Handelsbenaming'];
        $kenArr[4] = $array['Vervaldatum APK'];
        $kenArr[5] = $array['Datum tentaamstelling'];
        $kenArr[6] = $array['Bruto BPM'];
        $kenArr[7] = $array['Inrichting'];
        $kenArr[8] = $array['Aantal zitplaatsen'];
        $kenArr[9] = $array['Eerste kleur'];
        $kenArr[10] = $array['Tweede kleur'];
        $kenArr[11] = $array['Aantal cilinders'];
        $kenArr[12] = $array['Cilinderinhoud'];
        $kenArr[13] = $array['Massa ledig voertuig'];
        $kenArr[14] = $array['Toegestane maximum massa voertuig'];
        $kenArr[15] = $array['Massa rijklaar'];
        $kenArr[16] = $array['Maximum massa trekken ongeremd'];
        $kenArr[17] = $array['Maximum massa trekken geremd'];
        $kenArr[18] = $array['Zuinigheidslabel'];
        $kenArr[19] = $array['Datum eerste toelating'];
        $kenArr[20] = $array['Datum eerste afgifte Nederland'];
        $kenArr[21] = $array['Wacht op keuren'];
        $kenArr[22] = $array['Catalogusprijs'];
        $kenArr[23] = $array['WAM verzekerd'];
        $kenArr[24]  = $array['Maximale constuctiesnelheid (brom/snorfiets)'];
        $kenArr[25] = $array['Laadvermogen'];
        $kenArr[26] = $array['Oplegger geremd'];
        $kenArr[27] = $array['Aanhanger autonoom geremd'];
        $kenArr[28] = $array['Aanhanger middenas geremd'];
        $kenArr[29] = $array['Vermogen (brom/snorfiets)'];
        $kenArr[30] = $array['Aantal staanplaatsen'];
        $kenArr[31] = $array['Aantal deuren'];
        $kenArr[32] = $array['Aantal wielen'];
        $kenArr[33] = $array['Afstand hart koppeling tot achterzijden voertuig'];
        $kenArr[34] = $array['Afstand voorzijde voertuig tot hart koppeling'];
        $kenArr[35] = $array['Afwijkende maximum snelheid'];
        $kenArr[36] = $array['Lengte'];
        $kenArr[37] = $array['Breedte'];
        $kenArr[38] = $array['Europese voertuigcategorie'];
        $kenArr[39] = $array['Europese voertuigcategorie toevoeging'];
        $kenArr[40] = "";
        $kenArr[41] = $array['Plaats chassisnummer'];
        $kenArr[42] = $array['Technische max. masse voertuig'];
        $kenArr[43] = $array['Type'];
        $kenArr[44] = $array['Type gasinstalatie'];
        $kenArr[45] = $array['Typegoedkeuringnummer'];
        $kenArr[46] = $array['Variant'];
        $kenArr[47] = $array['Uitvoering'];
        $kenArr[48] = $array['Volgnummer wijziging EU typegoedkeuring'];
        $kenArr[49] = $array['Vermogen massarijklaar'];
        $kenArr[50] = $array['Wielbasis'];
        $kenArr[51] = $array['Export indicator'];
        $kenArr[52] = $array['Openstaande terugroepactie indicator'];
        $kenArr[53] = $array['Valvaldatum tachograaf'];
        $kenArr[54] = $array['Taxi indicator'];
        $kenArr[55] = $array['Maximum massa samenstelling'];
        $kenArr[56] = $array['Aantal rolstoelplaatsen'];
        $kenArr[57] = $array['Maximum ondersteunde snelheid'];

        $file = fopen($this->krijgCSV('voertuigen'), 'a');
        fputcsv($file, $kenArr);
        fclose($file);


        //Het wegschrijven naar de branstofcsv
        $BrandstofArr = $array['Brandstof'];

        $braArr[0] = $array['Kenteken'];
        $braArr[1] = $BrandstofArr['Brandstof volgnummer'];
        $braArr[2] = $BrandstofArr['Brondstof omschrijving'];
        $braArr[3] = $BrandstofArr['Brandstofverbruik buiten de stad'];
        $braArr[4] = $BrandstofArr['Brandstofverbruik gecombineerd'];
        $braArr[5] = $BrandstofArr['Brandstofverbruik stad'];
        $braArr[6] = $BrandstofArr['CO2 uitstoot gecombineerd'];
        $braArr[7] = "";
        $braArr[8] = $BrandstofArr['Geluidsniveau rijdend'];
        $braArr[9] = $BrandstofArr['Geluidsniveau stationair'];
        $braArr[10] = $BrandstofArr['Emissieklasse'];
        $braArr[11] = $BrandstofArr['Milliueklasse EG Goedkeuring(licht)'];
        $braArr[12] = $BrandstofArr['Milliueklasse EG Goedkeuring(zwaar)'];
        $braArr[13] = $BrandstofArr['Uitstoot deeltjes(licht)'];
        $braArr[14] = "";
        $braArr[15] = $BrandstofArr['Nettomaximumvermogen'];
        $braArr[16] = "";
        $braArr[17] = $BrandstofArr['Roetuitstoot'];
        $braArr[18] = $BrandstofArr['Toerental eluidsniveau'];

        $file = fopen($this->krijgCSV('brandstof'), 'a');
        fputcsv($file, $braArr);
        fclose($file);


        //Het wegschrijven naar de assencsv
        $assenArr = $array['Assen'];

        $assArr[0] = $array['Kenteken'];
        $assArr[1] = $assenArr['As nummer'];
        $assArr[2] = $assenArr['Aantal assen'];
        $assArr[3] = $assenArr['Aangedreven as'];
        $assArr[4] = $assenArr['Hefas'];
        $assArr[5] = $assenArr['Plaatscode as'];
        $assArr[6] = $assenArr['Spoorbreedte'];
        $assArr[7] = $assenArr['Weggedrag code'];
        $assArr[8] = $assenArr['Wettelijk Toegestane maximum aslast'];
        $assArr[9] = $assenArr['Technisch Toegestane maximum aslast'];

        $file = fopen($this->krijgCSV('assen'), 'a');
        fputcsv($file, $assArr);
        fclose($file);
    }

    public function delete($kenteken)
    {
        //Voertuigen deleten
        $array = [];//Maak een array aan
        $file = fopen($this->krijgCSV('voertuigen'), 'r');
        while (($lijn = fgetcsv($file, 3000,",")) !== FALSE)//Loop door de CSV
        {
            array_push($array, $lijn);//Alle lijnen de worden gevonden, worden in een array gestopt
        }
        fclose($file);

        //Nu loop ik door de array en verwijder de eerste instantie waar het kenteken gelijk is aan het kenteken uit de request
        $i=0;//Dit is de counter
        foreach ($array as &$waarde)
        {
            if ($waarde[0] === $kenteken)
            {
                unset($array[$i]);//Hier wordt de hele lijn verwijderd
                array_values($array);//De array wordt opniew gerangschikt omdat er anders een lege lijn tussen zou staan

                //Overschrijf het CSV met onze (aangepaste) array
                $file = fopen($this->krijgCSV('voertuigen'), 'w');
                foreach ($array as $line)
                {
                    fputcsv($file, $line);
                }
                fclose($file);
                break;
            }
            $i++;
        }

        //Brandstof deleten         //Dit werkt verder hetzelfde als het bij het algemene CSV, alleen nu in het CSV van de brandstof
        $array = [];       
        $file = fopen($this->krijgCSV('brandstof'), 'r');
        while (($lijn = fgetcsv($file, 3000,",")) !== FALSE)
        {
            array_push($array, $lijn);
        }
        fclose($file);
        $j=0;
        foreach ($array as &$waarde)
        {
            if ($waarde[0] === $kenteken)
            {
                unset($array[$j]);
                array_values($array);
                $file = fopen($this->krijgCSV('brandstof'), 'w');
                foreach ($array as $line)
                {
                    fputcsv($file, $line);
                }
                fclose($file);
                break;
            }
            $j++;
        }

        //Assen deleten         //Dit werkt verder hetzelfde als het bij het algemene CSV, alleen nu in het CSV van de assen
        $array = [];       
        $file = fopen($this->krijgCSV('assen'), 'r');
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
                $file = fopen($this->krijgCSV('assen'), 'w');
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

    public function update(Request $request, $kenteken)
    {
        //Deze functie is nogal ingewikkeld, het is in feite een combi tussen 'maak' en 'delete'
        $json = $request->input();//Hier haal ik de json op die is meegegeven in de post

        $jsonArray = json_decode(json_encode($json),true);//Als ik hem een keer decodeer werkt het niet. Ik moet hem encoden en dan weer terugdecoderen

        //Voertuigen updaten
        $voertuigenArray = [];       
        $file = fopen($this->krijgCSV('voertuigen'), 'r');
        while (($lijn = fgetcsv($file, 3000,",")) !== FALSE)
        {
            array_push($voertuigenArray, $lijn);
        }
        fclose($file);
        $i=0;
        foreach ($voertuigenArray as &$waarde)
        {
            if ($waarde[0] === $kenteken)
            {
                foreach ($jsonArray as $jsonKey => $jsonValue)
                {
                    foreach ($voertuigenArray[$i] as $voertuigKey => $voertuigValue)
                    {
                        if ($jsonKey == $voertuigenArray[0][$voertuigKey])
                        {
                            $voertuigenArray[$i][$voertuigKey] = $jsonValue;
                        }
                    }
                }
                $file = fopen($this->krijgCSV('voertuigen'), 'w');
                foreach ($voertuigenArray as $line)
                {
                    fputcsv($file, $line);
                }
                fclose($file);
                break;
            }
            $i++;
        }

        //Brandstof updaten
        if (array_key_exists('Brandstof', $jsonArray))//Als er een key 'brandstof' is meegestuurd, willen we blijkbaar de bradstof updaten. Als dit niet het geval is, hoeven we niks up te daten.
        {
            $brandstofArray = [];       
            $file = fopen($this->krijgCSV('brandstof'), 'r');
            while (($lijn = fgetcsv($file, 3000,",")) !== FALSE)
            {
                array_push($brandstofArray, $lijn);
            }
            fclose($file);
            $i=0;
            foreach ($brandstofArray as &$waarde)
            {
                if ($waarde[0] === $kenteken)
                {
                    foreach ($jsonArray['Brandstof'] as $jsonKey => $jsonValue)
                    {
                        foreach ($brandstofArray[$i] as $voertuigKey => $voertuigValue)
                        {
                            if ($jsonKey == $brandstofArray[0][$voertuigKey])
                            {
                                $brandstofArray[$i][$voertuigKey] = $jsonValue;
                            }
                        }
                    }
                    $file = fopen($this->krijgCSV('brandstof'), 'w');
                    foreach ($brandstofArray as $line)
                    {
                        fputcsv($file, $line);
                    }
                    fclose($file);
                    break;
                }
                $i++;
            }
        }

        //Assen updaten
        if (array_key_exists('Assen', $jsonArray))//Als er een key 'brandstof' is meegestuurd, willen we blijkbaar de bradstof updaten. Als dit niet het geval is, hoeven we niks up te daten.
        {
            $assenArray = [];       
            $file = fopen($this->krijgCSV('assen'), 'r');
            while (($lijn = fgetcsv($file, 3000,",")) !== FALSE)
            {
                array_push($assenArray, $lijn);
            }
            fclose($file);
            $i=0;
            foreach ($assenArray as &$waarde)
            {
                if ($waarde[0] === $kenteken)
                {
                    foreach ($jsonArray['Assen'] as $jsonKey => $jsonValue)
                    {
                        foreach ($assenArray[$i] as $voertuigKey => $voertuigValue)
                        {
                            if ($jsonKey == $assenArray[0][$voertuigKey])
                            {
                                $assenArray[$i][$voertuigKey] = $jsonValue;
                            }
                        }
                    }
                    $file = fopen($this->krijgCSV('assen'), 'w');
                    foreach ($assenArray as $line)
                    {
                        fputcsv($file, $line);
                    }
                    fclose($file);
                    break;
                }
                $i++;
            }
        }
    }
}