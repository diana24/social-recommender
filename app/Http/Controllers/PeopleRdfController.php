<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Http\EasyRdf\EasyRdf_Graph;
use \App\Http\EasyRdf\EasyRdf_Namespace;
use \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;

class PeopleRdfController extends Controller
{
    function searchPeople(Request $request){
        (new RdfController())->initRdf();
        if(!$request){
            return json_encode([]);
        }
        $name = $request->get('personName');
        $birthplaceUri= $request->get('personBirthPlace');
        $profession= $request->get('personProfession');
        $countryUri = $request->get('personCountry');

        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');

        $query='select *
                where {
                { ?person rdf:type dbo:Person }
                  union
                { ?person rdf:type foaf:Person }.
                ?person rdfs:label ?label.
                optional{{?person dbo:wikiPageExternalLink ?wiki} union {?person dbp:wikiPageExternalLink ?wiki}}.
                {?person dbo:name ?name} union {?person dbp:name ?name}.
                {?person dbo:birthPlace ?birthPlace} union {?person dbp:birthPlace ?birthPlace}.
                ?birthPlace rdfs:label ?bpLabel
                {?person dbo:profession ?profession} union {?person dbp:profession ?profession}.
                optional { {?person dbo:country ?country} union {?person dbp:country ?country} }.
                ?country rdfs:label ?countryLabel
                optional { {?person dbp:imageCaption ?image} union {?person dbo:imageCaption ?image} union {?person foaf:depiction ?image} }.
                ';
        if(isset($countryUri)){
            $query .= "\n".' {?person dbo:country <'.$countryUri.'>} union {?person dbp:country <'.$countryUri.'>} .';
        }
        if(isset($birthplaceUri)){
            $query .= "\n".'{?person dbo:birthPlace <'.$birthplaceUri.'>} union {?person dbp:birthPlace <'.$birthplaceUri.'>} .';
        }
        $query .= "\n".'filter ( lang(?label) = "en" && lang(?bpLabel) = "en" && lang(?countryLabel) = "en")';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?name), "'.$name.'"^^xsd:string, "i")';
        }
        if(isset($profession) && strlen($profession)){
            $query .= "\n".'filter regex(str(?profession), "'.$profession.'"^^xsd:string, "i")';
        }

        $query .= '}  limit 50'; //dd($query);

        try{
            $result = $sparql->query($query); //dd($result);
        } catch(\Exception $e){dd($e);
            return json_encode([]);
        }

        $people=$this->unify($result,$sparql);
//        dd($people);
        return json_encode($people);
    }


    function unify($result, \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client $sparql){
        $people=[];
        foreach($result as $row){
            $uri = $row->person->getUri();
            if(!array_has($people,$uri)){
                $people[$uri]=[];
            }
            $person=$people[$uri];
            if(isset($row->wiki)){
                $person['link']=(method_exists($row->wiki, 'getUri')) ? $row->wiki->getUri() : (
                (method_exists($row->wiki, 'getValue')) ? $row->wiki->getValue() : $row->wiki
                );
            }
            else{
                $person['link']=$uri;
            }
            $person['name']=$row->label->getValue();
            $person['name']= (isset($row->name) && method_exists($row->name,'getValue')) ? $row->name->getValue() : "";
            $person['profession']= (isset($row->profession) && method_exists($row->profession,'getValue')) ? $row->profession->getValue() : "";
            $person['birthPlace']['uri']= (isset($row->birthPlace) && method_exists($row->birthPlace,'getUri')) ? $row->birthPlace->getUri() : "";
            $person['birthPlace']['name']= (isset($row->bpLabel) && method_exists($row->bpLabel,'getValue')) ? $row->bpLabel->getValue() : "";

            $person['country']['uri']= (isset($row->country) && method_exists($row->country,'getUri')) ? $row->country->getUri() : "";
            $person['country']['name']= (isset($row->countryLabel) && method_exists($row->countryLabel,'getValue')) ? $row->countryLabel->getValue() : "";


            $people[$uri]=$person;
        }
        return $people;
    }
}
