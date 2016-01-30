<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Http\EasyRdf\EasyRdf_Graph;
use \App\Http\EasyRdf\EasyRdf_Namespace;
use \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
ini_set('max_execution_time', 300);

class PlaceRdfController extends Controller
{
    public function searchPlaces(Request $request=null){
        if(!$request){
            return json_encode([]);
        }
        $name = $request->get('name');
        $placeTypeUri = $request->get('placeTypeUri');
        $countryUri = $request->get('countryUri');

        (new RdfController())->initRdf();
        $query='select ?place, ?label, ?wiki, ?country,  ?countryLabel where {
                { ?place rdf:type dbo:Place }.
                ?place rdfs:label ?label.
                optional{{?place dbo:wikiPageExternalLink ?wiki} union {?place dbp:wikiPageExternalLink ?wiki}}.
                optional { {?place dbo:country ?country} union {?place dbp:country ?country} }.
                ?country rdfs:label ?countryLabel';
        if(isset($countryUri)){
            $query .= "\n".' {?place dbo:country <'.$countryUri.'>} union {?place dbp:country <'.$countryUri.'>} .';
        }
        if(isset($placeTypeUri)){
            $query .= "\n".' ?place rdf:type <'.$placeTypeUri.'> .';
        }
        $query .= "\n".'filter ( lang(?label) = "en" && lang(?countryLabel)="en")';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?label), "'.$name.'"^^xsd:string, "i")';
        }
        $query .= '} limit 50';

        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        try{
            $result = $sparql->query($query);
        } catch(\Exception $e){
            return json_encode([]);
        }
//
        $places=[];
        foreach($result as $row){
            $uri = $row->place->getUri();
            if(!array_has($places,$uri)){
                $places[$uri]=[];
            }
            $place=$places[$uri];
            if(isset($row->wiki)){
                $place['link']=(method_exists($row->wiki, 'getUri')) ? $row->wiki->getUri() : (
                (method_exists($row->wiki, 'getValue')) ? $row->wiki->getValue() : $row->wiki
                );
            }
            else{
                $place['link']=$uri;
            }
            $place['title']=$row->label->getValue();
//            if(isset($row->type) && method_exists($row->type, 'getUri')){
//                $typeUri = $row->type->getUri();
//                if(!isset($place['types'])){
//                    $place['types']=[];
//                }
//                if(!array_has($place['types'],$typeUri)){
//                    $typeUri = $row->type->getUri();
//                    $query = 'select ?typeName where { <'.$typeUri.'> rdfs:label ?typeName . filter (lang(?typeName)="en")} limit 1';
//                    $r = $sparql->query($query);
//                    foreach($r as $rw){
//                        if(isset($rw->typeName)){
//                            $typeName = $rw->typeName->getValue();
//                            $place['types'][$typeUri]=$typeName;
//                        }
//                    }
//                }
//
//            }
            if(isset($row->country) && method_exists($row->country, 'getUri')){
                if(!isset($place['countries'])){
                    $place['countries']=[];
                }
                if(isset($row->country) && method_exists($row->country, 'getUri')){
                    if(isset($row->countryLabel) && method_exists($row->countryLabel,'getValue')){
                        $place['countries'][$row->country->getUri()]=$row->countryLabel->getValue();
                    }
                }
//                if(!array_has($place['countries'],$countryUri)){
//                    $countryUri = $row->country->getUri();
//                    $query = 'select ?countryName where { <'.$countryUri.'> rdfs:label ?countryName . filter (lang(?countryName)="en")} limit 1';
//                    $r = $sparql->query($query);
//                    foreach($r as $rw){
//                        if(isset($rw->countryName)){
//                            $countryName = $rw->countryName->getValue();
//                            $place['countries'][$countryUri]=$countryName;
//                        }
//                    }
//                }

            }


            $places[$uri]=$place;
        }
        return json_encode($places);
    }





}
