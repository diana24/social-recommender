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

        $query='select * where {
                { ?film rdf:type dbo:Film }
                 union
                { ?film rdf:type <http://dbpedia.org/ontology/Wikidata:Q11424> }
                  union
                { ?film rdf:type owl:Thing }
                  union
                { ?film rdf:type sch:Movie }.
                ?film rdfs:label ?label.
                optional { ?film dbp:director ?director }.
                optional { ?film dbp:starring ?actor }.
                optional { {?film dbp:musicComposer ?musicComposer} union {?film dbp:music ?musicComposer}}.
                optional { ?film dbp:genre ?genre }.
                optional { {?film dbp:imageCaption ?image} union {?film foaf:depiction ?image} }.';

        if(isset($directorUri)){
            $query .= "\n".' ?film dbp:director <'.$directorUri.'> .';
        }
        if(isset($actorUri)){
            $query .= "\n".'?film dbp:starring <'.$actorUri.'> .';
        }
        if(isset($musicalArtistUri)){
            $query .= "\n".'{?film dbp:musicComposer <'.$musicalArtistUri.'>} union {?film dbp:music <'.$musicalArtistUri.'>}.';
        }
        if(isset($movieGenreUri)){
            $query .= "\n".'?film dbp:genre <'.$movieGenreUri.'>.';
        }
        if(isset($countryUri)){
            $query .= "\n".'?film dbp:country <'.$countryUri.'>.';
        }
        if(isset($originalLanguageUri)){
            $query .= "\n".'?film dbp:language <'.$originalLanguageUri.'>.';
        }
        $query .= "\n".'filter ( lang(?label) = "en" )';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?label), "'.$name.'"^^xsd:string, "i")';
        }
////        if(isset($releaseDate)){
////            $query .= "\n".'filter (?releaseDate = '.$releaseDate.')';
////        }
        $query .= '}  limit 50';

        try{
            $result = $sparql->query($query);
        } catch(\Exception $e){
            return json_encode([]);
        }

        $films=[];
        foreach($result as $row){
            $uri = $row->film->getUri();
            if(!array_has($films,$uri)){
                $films[$uri]=[];
            }
            $film=$films[$uri];
            $film['title']=$row->label->getValue();
            if(isset($row->director) && method_exists($row->director, 'getUri')){
                $directorUri = $row->director->getUri();
                if(!isset($film['directors'])){
                    $film['directors']=[];
                }
                if(!array_has($film['directors'],$directorUri)){
                    $directorUri = $row->director->getUri();
                    $query = 'select ?directorName where { <'.$directorUri.'> rdfs:label ?directorName . filter (lang(?directorName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->directorName)){
                            $directorName = $rw->directorName->getValue();
                            $film['directors'][$directorUri]=$directorName;
                        }
                    }
                }

            }
            if(isset($row->actor) && method_exists($row->actor, 'getUri')){
                $actorUri = $row->actor->getUri();
                if(!isset($film['actors'])){
                    $film['actors']=[];
                }
                if(!array_has($film['actors'],$actorUri)){
                    $actorUri = $row->actor->getUri();
                    $query = 'select ?actorName where { <'.$actorUri.'> rdfs:label ?actorName . filter (lang(?actorName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->actorName)){
                            $actorName = $rw->actorName->getValue();
                            $film['actors'][$actorUri]=$actorName;
                        }
                    }
                }

            }
            if(isset($row->musicComposer) && method_exists($row->musicComposer, 'getUri')){
                $musicComposerUri = $row->musicComposer->getUri();
                if(!isset($film['musicComposers'])){
                    $film['musicComposers']=[];
                }
                if(!array_has($film['musicComposers'],$musicComposerUri)){
                    $musicComposerUri = $row->musicComposer->getUri();
                    $query = 'select ?musicComposerName where { <'.$musicComposerUri.'> rdfs:label ?musicComposerName . filter (lang(?musicComposerName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->musicComposerName)){
                            $musicComposerName = $rw->musicComposerName->getValue();
                            $film['musicComposers'][$musicComposerUri]=$musicComposerName;
                        }
                    }
                }

            }
            if(isset($row->language) && method_exists($row->language, 'getUri')){
                $languageUri = $row->language->getUri();
                if(!isset($film['languages'])){
                    $film['languages']=[];
                }
                if(!array_has($film['languages'],$languageUri)){
                    $languageUri = $row->language->getUri();
                    $query = 'select ?languageName where { <'.$languageUri.'> rdfs:label ?languageName . filter (lang(?languageName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->languageName)){
                            $languageName = $rw->languageName->getValue();
                            $film['languages'][$languageUri]=$languageName;
                        }
                    }
                }

            }
            if(isset($row->country) && method_exists($row->country, 'getUri')){
                $countryUri = $row->country->getUri();
                if(!isset($film['countrys'])){
                    $film['countrys']=[];
                }
                if(!array_has($film['countrys'],$countryUri)){
                    $countryUri = $row->country->getUri();
                    $query = 'select ?countryName where { <'.$countryUri.'> rdfs:label ?countryName . filter (lang(?countryName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->countryName)){
                            $countryName = $rw->countryName->getValue();
                            $film['countrys'][$countryUri]=$countryName;
                        }
                    }
                }

            }
            if(isset($row->genre) && method_exists($row->genre, 'getUri')){
                $genreUri = $row->genre->getUri();
                if(!isset($film['genres'])){
                    $film['genres']=[];
                }
                if(!array_has($film['genres'],$genreUri)){
                    $genreUri = $row->genre->getUri();
                    $query = 'select ?genreName where { <'.$genreUri.'> rdfs:label ?genreName . filter (lang(?genreName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->genreName)){
                            $genreName = $rw->genreName->getValue();
                            $film['genres'][$genreUri]=$genreName;
                        }
                    }
                }

            }

            if(isset($row->image)){
                $film['image']=(method_exists($row->image, 'getUri')) ? $row->image->getUri() : (
                (method_exists($row->image, 'getValue')) ? $row->image->getValue() : $row->image
                );
            }
            if(isset($row->releaseDate)){
                $film['releaseDate']= method_exists($row->releaseDate, 'getValue') ? $row->releaseDate->getValue() : $row->releaseDate;
            }
            $films[$uri]=$film;

        }
//        dd($films);
        return json_encode($films);
    }

    public function recommendFilms(){
        $mybooks =  (new RdfController())->getBooks(); //dd($mybooks);
        $books=[];
        $i=0;

        shuffle($mybooks);

        $n=5;
        while($n>count($mybooks)){
            $n--;
        }
        $results=[];
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $mybooks = array_slice($mybooks, 0, $n);
        foreach($mybooks as $mb){
            $au = $mb['authors'][0];
            try{
                $query = 'select distinct ?book where {

                { ?book rdf:type dbo:WrittenWork }
                 union
                { ?book rdf:type <http://dbpedia.org/class/Book> }
                union
                { ?book rdf:type owl:Thing }.

                ?book rdfs:label ?label.
                {?book dbo:author ?author} union {?book dbp:author ?author}.
                ?author rdfs:label ?a

                filter ( lang(?label) = "en") filter regex(str(?label), "'.$mb['name'].'", "i")
                filter regex(str(?a), "'.$au.'", "i") } limit 10';

                $result = $sparql->query($query);
                array_push($results,$result);


            }catch (\Exception $e){
                dd($e);
            }
        }
//        dd($results);

        $filmResults=[];

        foreach($results as $result){
            foreach($result as $row){
                $uri = $row->book->getUri();

                $query = 'select distinct ?film, ?label, MIN(?image) as ?img where{
                    { optional{
                    ?x dbo:wikiPageDisambiguates <'.$uri.'>.
                    ?x dbo:wikiPageDisambiguates ?film.
                    } } union
                    { optional {
                    { ?film dbo:basedOn <'.$uri.'> } union {?film dbp:basedOn <'.$uri.'>}
                    } }.

                    ?film rdf:type dbo:Film.
                    ?film rdfs:label ?label.
                    optional { {?film dbp:imageCaption ?image} union {?film dbo:imageCaption ?image} union {?film foaf:depiction ?image} }.
                    filter(lang(?label)="en")
                } limit 6';
                try{
                    $x = $sparql->query($query);
                    array_push($filmResults,$x);
                }catch(\Exception $e){

                }
            }
        }
//        dd($filmResults);

        $films=[];

        foreach($filmResults as $filmResult){
            foreach($filmResult as $row){
                $uri = $row->film->getUri();
                $query = 'select distinct ?film, ?label, MIN(?image) as ?img where{
                    ?film rdf:type dbo:Film.
                    ?film rdfs:label ?label.

                    {optional{
                    {?film dbo:director ?x} union {?film dbo:director ?x}.
                    {<'.$uri.'> dbo:director ?x} union {<'.$uri.'> dbp:director ?x}.
                    }}

                    union

                    {optional{
                    {?film dbo:starring ?x} union {?film dbo:starring ?x}.
                    {<'.$uri.'> dbo:starring ?x} union {<'.$uri.'> dbp:starring ?x}.
                    }}

                    union

                    {optional{
                    {?film dbo:genre ?x} union {?film dbo:genre ?x}.
                    {<'.$uri.'> dbo:genre ?x} union {<'.$uri.'> dbp:genre ?x}.
                    }}.
                    filter(lang(?label)="en")
                } limit 5';
                try{
                    $x = $sparql->query($query);
                    array_push($films,$x);
                }catch(\Exception $e){

                }
            }
        }
        $filmResults=array_merge($filmResults,$films);
        $films=[];
        foreach($filmResults as $filmResult){
            foreach($filmResult as $row){
                $uri = $row->film->getUri();
                if(!array_has($films,$uri)){
                    $films[$uri]=[];
                }
                $film=$films[$uri];
                $film['title']=$row->label->getValue();

                if(isset($row->img)){
                    $film['image']=(method_exists($row->img, 'getUri')) ? $row->img->getUri() : (
                    (method_exists($row->img, 'getValue')) ? $row->img->getValue() : $row->img
                    );
                }
                $films[$uri]=$film;
            }
        }
        dd($films);
    }
}
