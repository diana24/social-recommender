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

class DataController extends Controller
{
    function getAllLiteraryGenres(Request $request=null){
        (new RdfController())->initRdf();
        $name = isset($request) ? $request->input('name') : "" ;
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'SELECT str(?literary_genre) AS ?gen_literar, count(?book) AS ?nr_carti, ?label WHERE {'.
            '  ?book rdf:type dbo:Book .'.
            '  ?book <http://dbpedia.org/ontology/literaryGenre> ?literary_genre .'.
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
            $l['book_count']=$row->nr_carti->getValue();
            array_push($lit,$l);
        }
       return json_encode($lit);
    }
    function getAllProfessions(Request $request=null){
        (new RdfController())->initRdf();
        $name = isset($request) ? $request->input('name') : "" ;
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'SELECT str(?literary_genre) AS ?gen_literar, count(?book) AS ?nr_carti, ?label WHERE {'.
            '  ?book rdf:type foaf:Person .'.
            '  {?book dbo:profession ?literary_genre} union {?book dbp:profession ?literary_genre}.'.
            '  ?literary_genre rdfs:label ?label .'.
            '  FILTER ( lang(?label) = "en" )'.
            '  FILTER regex( str(?label), "'.$name.'", "i" )'.
            '} ORDER BY DESC(count(?book)) '.
//            '} ORDER BY (?label) '.
            'LIMIT 300'
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
        $name = isset($request) ? $request->input('name') : "" ;
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
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
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $name = isset($request) ? $request->input('name') : "" ;
        $result = $sparql->query(
            'select ?country, ?label where {
                ?country <http://purl.org/dc/terms/subject> <http://dbpedia.org/resource/Category:Member_states_of_the_United_Nations>;
                <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://schema.org/Country> .
                ?country rdfs:label ?label . FILTER ( lang(?label) = "en" ) FILTER regex( str(?label), "'.$name.'", "i" )
                } order by ?country limit 200'
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
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'select distinct ?type, ?label where {
                $type rdfs:subClassOf dbo:Event.
                $type rdfs:label ?label
                filter(lang(?label)="en")
            } limit 10');
        $countries = [];
        foreach($result as $row){
            $l['uri']=$row->type->getUri();
            $l['name']=$row->label->getValue();
            array_push($countries,$l);
        }
        return json_encode($countries);
    }
    function getAllPlaceTypes(Request $request=null){
        (new RdfController())->initRdf();
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'select distinct ?type, ?label where {
                $type rdfs:subClassOf dbo:Place.
                $type rdfs:label ?label
                filter(lang(?label)="en")
            } limit 100');
        $countries = [];
        foreach($result as $row){
            $l['uri']=$row->type->getUri();
            $l['name']=$row->label->getValue();
            array_push($countries,$l);
        }
        return json_encode($countries);
    }
    function getAllEducationalInstitutionTypes(Request $request=null){
        (new RdfController())->initRdf();
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'select distinct ?type, ?label where {
                $type rdfs:subClassOf dbo:EducationalInstitution.
                $type rdfs:label ?label
                filter(lang(?label)="en")
            } limit 50');
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
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $name = isset($request) ? $request->input('name') : "" ;
        $result = $sparql->query(
            'select ?language, ?label where {
                ?language rdf:type dbo:Language.
                ?language rdfs:label ?label.
                FILTER regex( str(?label), "'.$name.'", "i" )
                FILTER ( lang(?label)="en" )
                } order by ?label limit 240'
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
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
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
        $name = $request->input('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select ?illustrator, ?label, ?val, count(?book) AS ?nr_carti where{
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        ?book rdf:type dbo:WrittenWork.
                        ?book dbo:illustrator ?illustrator.
                      filter regex(str(?label),"'.$name.'", "i")
                      FILTER ( lang(?label) = "en" )
                    } ORDER BY DESC(count(?book)) limit 400'
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
        $name = $request->input('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select ?illustrator, ?label, ?val, count(?book) AS ?nr_carti where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        ?book dbo:author ?illustrator.

                       ?book rdf:type dbo:WrittenWork.

                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } ORDER BY DESC(count(?book)) limit 400'
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
    function getPrincipals(Request $request=null){
        $name = $request->input('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select ?illustrator, ?label, ?val, count(?nr) where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        {?edu dbo:principal ?illustrator.} union {?edu dbp:principal ?illustrator.}.
                        {?edu dbo:numberOfStudents ?nr} union {?edu dbp:numberOfStudents ?nr} .
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } order by desc (?nr) limit 400'
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
    function getRectors(Request $request=null){
        $name = $request->input('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val, count(?nr)  where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        {?edu dbo:rector ?illustrator.} union {?edu dbp:rector ?illustrator.}.
                        {?edu dbo:numberOfStudents ?nr} union {?edu dbp:numberOfStudents ?nr} .
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } order by desc (?nr) limit 400'
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
        $name = $request->input('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        ?film dbo:director ?illustrator.
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } limit 400'
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
        $name = $request->input('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val where {
                        ?illustrator rdf:type foaf:Person.
                        ?illustrator rdfs:label ?label.
                        ?film dbo:starring ?illustrator.
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } limit 400'
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
        $name = $request->input('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select distinct ?illustrator, ?label, ?val where {
                        ?illustrator rdf:type dbo:MusicalArtist.
                        ?illustrator rdfs:label ?label.
                        {?film dbo:musicComposer ?illustrator} union {?film dbp:music ?illustrator}
                        union {?film dbp:musicComposer ?illustrator} union {?film dbo:music ?illustrator}.
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } limit 400'
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
        $name = $request->input('name');
        if(isset($name)){
            (new RdfController())->initRdf();
            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
            $result = $sparql->query(
                'select ?place, ?label, count(?population) where {
                        ?place rdf:type dbo:Place.
                        ?place rdfs:label ?label.
                        ?place dbo:populationTotal ?population
                      filter regex(str(?label),"'.$name.'","i")
                      FILTER ( lang(?label) = "en" )
                    } order by desc(?population) limit 700'
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
