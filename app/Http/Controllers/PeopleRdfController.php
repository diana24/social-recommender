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
        $professionUri= $request->get('personProfession');
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
                {?person dbo:profession ?profession} union {?person dbp:profession ?profession}.

                ?profession rdfs:label ?professionLabel.

                {?person dbo:country ?country} union {?person dbp:country ?country} .
                ?country rdfs:label ?countryLabel.
                ';
        if(isset($countryUri)){
            $query .= "\n".' {?person dbo:country <'.$countryUri.'>} union {?person dbp:country <'.$countryUri.'>} .';
        }
        if(isset($professionUri)){
            $query .= "\n".'{?person dbo:profession <'.$professionUri.'>} union {?person dbp:profession <'.$professionUri.'>} .';
        }
        $query .= "\n".'filter ( lang(?label) = "en" && lang(?professionLabel) = "en" && lang(?countryLabel) = "en")';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?name), "'.$name.'"^^xsd:string, "i")';
        }

        $query .= '}  limit 50';

        try{
            $result = $sparql->query($query);
        } catch(\Exception $e){dd($e);
            return json_encode([]);
        }

        $people=$this->unify($result,$sparql);
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
            $person['profession']['uri']= (isset($row->profession) && method_exists($row->profession,'getUri')) ? $row->profession->getUri() : "";
            $person['profession']['name']= (isset($row->professionLabel) && method_exists($row->professionLabel,'getValue')) ? $row->professionLabel->getValue() : "";

            $person['country']['uri']= (isset($row->country) && method_exists($row->country,'getUri')) ? $row->country->getUri() : "";
            $person['country']['name']= (isset($row->countryLabel) && method_exists($row->countryLabel,'getValue')) ? $row->countryLabel->getValue() : "";


            $people[$uri]=$person;
        }
        return $people;
    }
}
