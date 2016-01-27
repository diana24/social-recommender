<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyRdf_Graph;
use EasyRdf_Namespace;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;

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
        $query='select distinct ?place where {
                { ?place rdf:type dbo:Place }.
                ?place rdfs:label ?label.
                optional { ?place rdf:type ?type }.
                optional { {?place dbo:country ?startDate} union {?place dbp:country ?startDate} }.';
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
        $query .= '} limit 10';

        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query($query);
//        dd($result);
//
        $places=[];
        foreach($result as $row){
            $uri = $row->place->getUri();
            $place = $this->getPlaceData($uri);
            array_push($places,$place);
        }dd($places);
        return json_encode($places);
    }

    public function getPlaceData($uri){
        $place=[];
        $place['uri']=$uri;
        $query = 'select ?label where{
                <'.$uri.'> rdfs:label ?label.
                filter(lang(?label)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $place['name']=$a->label->getValue();
        }
        $query = 'select distinct ?country, ?countryName where{
                {<'.$uri.'> dbo:country ?country} union {<'.$uri.'> dbp:country ?country}.
                ?country rdfs:label ?countryName.
                filter(lang(?countryName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $place['countries']=[];
            $location['uri']=$a->country->getUri();
            $location['name']=$a->countryName->getValue();
            array_push($place['countries'],$location);
        }
        $query = 'select distinct ?type, ?typeName where{
                <'.$uri.'> rdf:type ?type.
                ?type rdfs:label ?typeName.
                filter(lang(?typeName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $place['types']=[];
            $location['uri']=$a->type->getUri();
            $location['name']=$a->typeName->getValue();
            array_push($place['types'],$location);
        }
        $query = 'select distinct ?image where{
                {<'.$uri.'> dbo:imageCaption ?image} union {<'.$uri.'> dbp:imageCaption ?image} union {<'.$uri.'> foaf:depiction ?image}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $place['images']=[];
            $im = (method_exists($a->image,'getUri')) ? $a->image->getUri() : $a->image->getValue();
            array_push($place['images'],$im);
        }


        return $place;
    }
}
