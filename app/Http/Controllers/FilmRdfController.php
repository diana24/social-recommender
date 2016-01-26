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
        $fictionalCharacterUri = $request->get('fictionalCharacterUri');
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
                optional { {?film dbo:illustrator ?illustrator} union {?film dbp:illustrator ?illustrator} }.
                optional { {?film dbo:starring ?actor} union {?film dbp:starring ?actor} }.
                optional { {?fictionalCharacter dbo:movie ?film} union {?fictionalCharacter dbp:movie ?film} }.
                optional { {?film dbo:musicComposer ?musicalArtist} union {?film dbp:musicComposer ?musicalArtist} }.
                optional { {?film dbo:genre ?genre} union {?film dbp:genre ?genre} }.
                optional { {?film dbp:releaseDate ?releaseDate} union {?film dbo:releaseDate ?releaseDate} }.
                optional { {?film dbp:imageCaption ?image} union {?film dbo:imageCaption ?image} union {?film foaf:depiction ?image} }.';

//        if(isset($authorUri)){
//            $query .= "\n".' {?book dbo:author <'.$authorUri.'>} union {?book dbp:author <'.$authorUri.'>} .';
//        }
//        if(isset($illustratorUri)){
//            $query .= "\n".'{?book dbo:illustrator <'.$illustratorUri.'>} union {?book dbp:illustrator <'.$illustratorUri.'>} .';
//        }
//        if(isset($literaryGenreUri)){
//            $query .= "\n".'{?book dbo:genre <'.$literaryGenreUri.'>} union {?book dbp:genre <'.$literaryGenreUri.'>}.';
//        }
        $query .= "\n".'filter ( lang(?label) = "en" )';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?label), "'.$name.'"^^xsd:string, "i")';
        }
//        if(isset($numberOfPagesMin)){
//            $query .= "\n".'filter (?numberOfPages >= '.$numberOfPagesMin.')';
//        }
//        if(isset($numberOfPagesMax)){
//            $query .= "\n".'filter (?numberOfPages <= '.$numberOfPagesMax.')';
//        }
//        if(isset($numberOfVolumes)){
//            $query .= "\n".'filter (?numberOfVolumes = '.$numberOfVolumes.')';
//        }
////        if(isset($releaseDate)){
////            $query .= "\n".'filter (?releaseDate = '.$releaseDate.')';
////        }
        $query .= '}  limit 10';
//
        $result = $sparql->query($query);
        dd($result);
//
//        $books=[];
//        foreach($result as $row){
//            $book['uri']=$row->book->getUri();
//
//            $uri = $row->book->getUri();
//            $book = $this->getBookData($uri);
//            array_push($books,$book);
//        }
//        return json_encode($books);
    }
}
