<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyRdf_Graph;
use EasyRdf_Namespace;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;

class FilmRdfController extends Controller
{
    public function searchFilms(Request $request=null){
        (new RdfController())->initRdf();
        if(!$request){
            return json_encode([]);
        }
        $directorUri = $request->get('directorUri');
        $actorUri = $request->get('actorUri');
//        $fictionalCharacterUri = $request->get('fictionalCharacterUri');
        $musicalArtistUri = $request->get('musicalArtistUri');
        $originalLanguageUri = $request->get('originalLanguageUri');
        $countryUri = $request->get('countryUri');
//        $releaseDate= $request->get('releaseDate');
        $movieGenreUri= $request->get('movieGenreUri');
        $name = $request->get('name');

        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');

        $query='select distinct ?film where {
                { ?film rdf:type dbo:Film }
                 union
                { ?film rdf:type <http://dbpedia.org/ontology/Wikidata:Q11424> }
                  union
                { ?film rdf:type owl:Thing }
                  union
                { ?film rdf:type sch:Movie }.
                ?film rdfs:label ?label.
                optional { {?film dbo:director ?director} union {?film dbp:director ?director} }.
                optional { {?film dbo:starring ?actor} union {?film dbp:starring ?actor} }.
                optional { {?film dbo:musicComposer ?music} union {?film dbp:musicComposer ?music}
                union {?film dbo:music ?music} union {?film dbp:music ?music}}.
                optional { {?film dbo:genre ?genre} union {?film dbp:genre ?genre} }.
                optional { {?film dbp:imageCaption ?image} union {?film dbo:imageCaption ?image} union {?film foaf:depiction ?image} }.';

        if(isset($directorUri)){
            $query .= "\n".' {?film dbo:director <'.$directorUri.'>} union {?film dbp:director <'.$directorUri.'>} .';
        }
        if(isset($actorUri)){
            $query .= "\n".'{?film dbo:starring <'.$actorUri.'>} union {?film dbp:starring <'.$actorUri.'>} .';
        }
        if(isset($musicalArtistUri)){
            $query .= "\n".'{?film dbo:musicComposer <'.$musicalArtistUri.'>} union {?film dbp:musicComposer <'.$musicalArtistUri.'>}
            union {?film dbo:music <'.$musicalArtistUri.'>} union {?film dbp:music <'.$musicalArtistUri.'>}.';
        }
        if(isset($movieGenreUri)){
            $query .= "\n".'{?film dbo:genre <'.$movieGenreUri.'>} union {?film dbp:genre <'.$movieGenreUri.'>}.';
        }
        if(isset($countryUri)){
            $query .= "\n".'{?film dbo:country <'.$countryUri.'>} union {?film dbp:country <'.$countryUri.'>}.';
        }
        if(isset($originalLanguageUri)){
            $query .= "\n".'{?film dbo:language <'.$originalLanguageUri.'>} union {?film dbp:language <'.$originalLanguageUri.'>}.';
        }
        $query .= "\n".'filter ( lang(?label) = "en" )';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?label), "'.$name.'"^^xsd:string, "i")';
        }
////        if(isset($releaseDate)){
////            $query .= "\n".'filter (?releaseDate = '.$releaseDate.')';
////        }
        $query .= '}  limit 10';
//
        $result = $sparql->query($query);
//        dd($result);

        $films=[];
        foreach($result as $row){
            $uri = $row->film->getUri();
            $film = $this->getFilmData($uri);
            array_push($films,$film);
        }
        return json_encode($films);
    }

    function getFilmData($uri){
        $film=[];
        $film['uri']=$uri;
        $query = 'select ?label where{
                <'.$uri.'> rdfs:label ?label.
                filter(lang(?label)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $film['name']=$a->label->getValue();
        }
        $query = 'select distinct ?director, ?directorName where{
                {<'.$uri.'> dbo:director ?director} union {<'.$uri.'> dbp:director ?director}.
                ?director rdfs:label ?directorName.
                filter(lang(?directorName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $film['directors']=[];
            $author['uri']=$a->director->getUri();
            $author['name']=$a->directorName->getValue();
            array_push($film['directors'],$author);
        }
        $query = 'select distinct ?image where{
                {<'.$uri.'> dbo:imageCaption ?image} union {<'.$uri.'> dbp:imageCaption ?image} union {<'.$uri.'> foaf:depiction ?image}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $film['images']=[];
            $im = (method_exists($a->image,'getUri')) ? $a->image->getUri() : $a->image->getValue();
            array_push($film['images'],$im);
        }

        $query = 'select distinct ?actor, ?actorName where{
                {<'.$uri.'> dbo:starring ?actor} union {<'.$uri.'> dbp:starring ?actor}.
                ?actor rdfs:label ?actorName.
                filter(lang(?actorName)="en")
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $film['actors']=[];
            $illustrator['uri']=$a->actor->getUri();
            $illustrator['name']=$a->actorName->getValue();
            array_push($film['actors'],$illustrator);
        }

        $query = 'select distinct ?language, ?languageName where{
                {<'.$uri.'> dbo:language ?language} union {<'.$uri.'> dbp:language ?language}.
                ?language rdfs:label ?languageName.
                filter(lang(?languageName)="en")
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $film['languages']=[];
            $illustrator['uri']=$a->language->getUri();
            $illustrator['name']=$a->languageName->getValue();
            array_push($film['languages'],$illustrator);
        }

        $query = 'select distinct ?country, ?countryName where{
                {<'.$uri.'> dbo:country ?country} union {<'.$uri.'> dbp:country ?country}.
                ?country rdfs:label ?countryName.
                filter(lang(?countryName)="en")
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $film['countries']=[];
            $illustrator['uri']=$a->country->getUri();
            $illustrator['name']=$a->countryName->getValue();
            array_push($film['countries'],$illustrator);
        }

        $query = 'select distinct ?musicComposer, ?musicComposerName where{
                {<'.$uri.'> dbo:musicComposer ?musicComposer} union {<'.$uri.'> dbp:musicComposer ?musicComposer}
                 union {<'.$uri.'> dbo:music ?musicComposer} union {<'.$uri.'> dbp:music ?musicComposer}.
                ?musicComposer rdfs:label ?musicComposerName.
                filter(lang(?musicComposerName)="en")
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $film['musicComposers']=[];
            $illustrator['uri']=$a->musicComposer->getUri();
            $illustrator['name']=$a->musicComposerName->getValue();
            array_push($film['musicComposers'],$illustrator);
        }
        $query = 'select distinct ?genre, ?genreName where{
                {<'.$uri.'> dbo:genre ?genre} union {<'.$uri.'> dbp:genre ?genre}.
                ?genre rdfs:label ?genreName.
                filter(lang(?genreName)="en")
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $film['genres']=[];
            $genre['uri']=$a->genre->getUri();
            $genre['name']=$a->genreName->getValue();
            array_push($film['genres'],$genre);
        }
        return $film;
    }
}
