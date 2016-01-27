<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyRdf_Graph;
use EasyRdf_Namespace;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    function getAllLiteraryGenres(Request $request=null){
        (new RdfController())->initRdf();
        $name = isset($request) ? $request->get('name') : "" ;
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'SELECT str(?literary_genre) AS ?gen_literar, count(?book) AS ?nr_carti, ?label WHERE {'.
            '  ?book rdf:type dbo:Book .'.
            '  ?book <http://dbpedia.org/ontology/literaryGenre> ?literary_genre .'.
            '  ?literary_genre rdfs:label ?label .'.
            '  FILTER ( lang(?label) = "en" )'.
            '  FILTER regex( str(?label), "'.$name.'", "i" )'.
//            '} ORDER BY DESC(count(?book)) '.
            '} ORDER BY (?label) '.
            'LIMIT 100'
        );
        $lit = [];
        foreach($result as $row){
            $l['uri']=$row->gen_literar->getValue();
            $l['name']=$row->label->getValue();
            $l['book_count']=$row->nr_carti->getValue();
            array_push($lit,$l);
        }
       return json_encode($lit);
    }
    function getAllMovieGenres(Request $request=null){
        (new RdfController())->initRdf();
        $name = isset($request) ? $request->get('name') : "" ;
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'SELECT str(?literary_genre) AS ?gen_literar, count(?book) AS ?nr_carti, ?label WHERE {'.
            '  ?book rdf:type dbo:Film .'.
            '  ?book <http://dbpedia.org/property/genre> ?literary_genre .'.
            '  ?literary_genre rdfs:label ?label .'.
            '  FILTER ( lang(?label) = "en" )'.
            '  FILTER regex( str(?label), "'.$name.'", "i" )'.
            '} ORDER BY DESC(count(?book)) '.
//            '} ORDER BY (?label) '.
            'LIMIT 100'
        );
        $lit = [];
        foreach($result as $row){
            $l['uri']=$row->gen_literar->getValue();
            $l['name']=$row->label->getValue();
            $l['film_count']=$row->nr_carti->getValue();
            array_push($lit,$l);
        }
        return json_encode($lit);
    }
    function getAllCountries(Request $request=null){
        (new RdfController())->initRdf();
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $name = isset($request) ? $request->get('name') : "" ;
        $result = $sparql->query(
            'select ?country, ?label where {
                ?country <http://purl.org/dc/terms/subject> <http://dbpedia.org/resource/Category:Member_states_of_the_United_Nations>;
                <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://schema.org/Country> .
                ?country rdfs:label ?label . FILTER ( lang(?label) = "en" ) FILTER regex( str(?label), "'.$name.'", "i" )
                } order by ?country'
        );
        $countries = [];
        foreach($result as $row){
            $l['uri']=$row->country->getUri();
            $l['name']=$row->label->getValue();
            array_push($countries,$l);
        }
        return json_encode($countries);
    }
    function getAllEventTypes(Request $request=null){
        (new RdfController())->initRdf();
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'select distinct ?type, ?label where {
                $type rdfs:subClassOf dbo:Event.
                $type rdfs:label ?label
            } limit 10');
        $countries = [];
        foreach($result as $row){
            $l['uri']=$row->type->getUri();
            $l['name']=$row->label->getValue();
            array_push($countries,$l);
        }
        return json_encode($countries);
    }
    function getAllLanguages(Request $request=null){
        (new RdfController())->initRdf();
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $name = isset($request) ? $request->get('name') : "" ;
        $result = $sparql->query(
            'select ?language, ?label where {
                ?language rdf:type dbo:Language.
                ?language rdfs:label ?label.
                FILTER regex( str(?label), "'.$name.'", "i" )
                FILTER ( lang(?label)="en" )
                } order by ?label'
        );
        $countries = [];
        foreach($result as $row){
            $l['uri']=$row->language->getUri();
            $l['name']=$row->label->getValue();
            array_push($countries,$l);
        }
        return json_encode($countries);
    }
    function getAllCities(Request $request=null){
        if(isset($request) && isset($request['countryUri']) && isset($request['city'])){
            (new RdfController())->initRdf();
            $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select ?city, ?country, ?label where {
                        ?city rdf:type yago:City108524735.
                        ?city rdfs:label ?label.
                        ?city dbo:country ?country.
                        ?city dbo:country <'.$request['countryUri'].'>.
                      filter regex(str(?label),"'.$request['city'].'", "i")
                      filter ( lang(?label) = "en" )
                    } order by (?label) limit 30'

            );//dd($result);
            $cities = [];
            foreach($result as $row){
                $l['uri']=$row->city->getUri();
                $l['name']=$row->label->getValue();
                array_push($cities,$l);
            }
            return json_encode($cities);
        }
    }
    function getIllustrators(Request $request=null){
        $name = $request->get('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        ?book dbo:illustrator ?illustrator.
                      filter regex(str(?label),"'.$name.'", "i")
                      FILTER ( lang(?label) = "en" )
                    } limit 30'
            );
            $illustrators = [];
            foreach($result as $row){
                $l['uri']=$row->illustrator->getUri();
                $l['name']=$row->label->getValue();
                array_push($illustrators,$l);
            }
            return json_encode($illustrators);
        }
    }
    function getAuthors(Request $request=null){
        $name = $request->get('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        ?book dbo:author ?illustrator.
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } limit 30'
            );
            $illustrators = [];
            foreach($result as $row){
                $l['uri']=$row->illustrator->getUri();
                $l['name']=$row->label->getValue();
                array_push($illustrators,$l);
            }
            return json_encode($illustrators);
        }
    }

    function getDirectors(Request $request=null){
        $name = $request->get('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        ?film dbo:director ?illustrator.
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } limit 30'
            );
            $illustrators = [];
            foreach($result as $row){
                $l['uri']=$row->illustrator->getUri();
                $l['name']=$row->label->getValue();
                array_push($illustrators,$l);
            }
            return json_encode($illustrators);
        }
    }
    function getActors(Request $request=null){
        $name = $request->get('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        ?film dbo:starring ?illustrator.
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } limit 30'
            );
            $illustrators = [];
            foreach($result as $row){
                $l['uri']=$row->illustrator->getUri();
                $l['name']=$row->label->getValue();
                array_push($illustrators,$l);
            }
            return json_encode($illustrators);
        }
    }
    function getMusicalArtists(Request $request=null){
        $name = $request->get('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val where {
                        ?illustrator rdf:type dbo:MusicalArtist.
                        ?illustrator rdfs:label ?label.
                        {?film dbo:musicComposer ?illustrator} union {?film dbp:music ?illustrator}
                        union {?film dbp:musicComposer ?illustrator} union {?film dbo:music ?illustrator}.
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } limit 30'
            );
            $illustrators = [];
            foreach($result as $row){
                $l['uri']=$row->illustrator->getUri();
                $l['name']=$row->label->getValue();
                array_push($illustrators,$l);
            }
            return json_encode($illustrators);
        }
    }
    function getPlaces(Request $request=null){
        $name = $request->get('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?place, ?label where {
                        ?place rdf:type dbo:Place.
                        ?place rdfs:label ?label.
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } limit 30'
            );
            $illustrators = [];
            foreach($result as $row){
                $l['uri']=$row->place->getUri();
                $l['name']=$row->label->getValue();
                array_push($illustrators,$l);
            }
            return json_encode($illustrators);
        }
    }
}
