<?php

namespace App\Http\Controllers;

class PlayersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() {
       
        return "Hello From Index";
    }

    public function show($kenteken)
    {

        $kenCSV = fopen("C:/xampp/htdocs/lumen/dataprocessing/data/voertuigen.csv", "r");
        while (($kenArr = fgetcsv($kenCSV, 3000,",")) !== FALSE)
        {  
            if ($kenArr[0] == $kenteken)
            {

                //Brandstof ophalen
                $braCSV = fopen("C:/xampp/htdocs/lumen/dataprocessing/data/Open_Data_RDW__Gekentekende_voertuigen_brandstof.csv", "r");
                $braArr = "";
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


                //Assen ophalen
                $assCSV = fopen("C:/xampp/htdocs/lumen/dataprocessing/data/Open_Data_RDW__Gekentekende_voertuigen_assen.csv", "r");
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
                //echo $json;
                return response()->json($json);
                break;
            }
        }
        fclose($objCSV);
    }
    
    public function store() {
       
        return "Hello From Store";
    }

    public function update() {
       
        return "Hello From Update";
    }

    public function destroy() {
       
        return "Hello From Delete";
    }
}