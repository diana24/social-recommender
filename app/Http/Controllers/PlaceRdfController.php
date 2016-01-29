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
        $countryUri = $request->get('$countryUri');
//        $closeToPlaceUri = $request->get('closeToPlaceUri');

        (new RdfController())->initRdf();
        $query='select * where {
                { ?place rdf:type dbo:Place }.
                ?place rdfs:label ?label.
                optional{{?place dbo:wikiPageExternalLink ?wiki} union {?place dbp:wikiPageExternalLink ?wiki}}.
                optional { {?place dbo:country ?country} union {?place dbp:country ?country} }.';
        if(isset($countryUri)){
            $query .= "\n".' {?place dbo:country <'.$countryUri.'>} union {?place dbp:country <'.$countryUri.'>} .';
        }
//        if(isset($closeToPlaceUri)){
//            $query .= "\n".' {?place dbo:closeTo <'.$closeToPlaceUri.'>} union {?place dbp:closeTo <'.$closeToPlaceUri.'>} .';
//        }
        if(isset($placeTypeUri)){
            $query .= "\n".' ?place rdf:type <'.$placeTypeUri.'> .';
        }
        $query .= "\n".'filter ( lang(?label) = "en" )';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?label), "'.$name.'"^^xsd:string, "i")';
        }
        $query .= '} limit 50';

        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        try{
            $result = $sparql->query($query); //dd($result);
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
                $countryUri = $row->country->getUri();
                if(!isset($place['countries'])){
                    $place['countries']=[];
                }
                if(!array_has($place['countries'],$countryUri)){
                    $countryUri = $row->country->getUri();
                    $query = 'select ?countryName where { <'.$countryUri.'> rdfs:label ?countryName . filter (lang(?countryName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->countryName)){
                            $countryName = $rw->countryName->getValue();
                            $place['countries'][$countryUri]=$countryName;
                        }
                    }
                }

            }


            if(isset($row->image)){
                $place['image']=(method_exists($row->image, 'getUri')) ? $row->image->getUri() : (
                (method_exists($row->image, 'getValue')) ? $row->image->getValue() : $row->image
                );
            }
            $places[$uri]=$place;
        }//dd($places);
        return json_encode($places);
    }

}
