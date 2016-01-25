<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyRdf_Graph;
use EasyRdf_Namespace;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;

class BookRdfController extends Controller
{

    function getBookRec($book){
        $name = $book['name'];
        $graph = (new RdfController())->getResourceInfo($name);
//        $mainRes = $graph->resources('rdf:Description')[$resourceUri];
        foreach($graph->resources() as $resource){
            $uri = $resource->getUri();
            $works = $graph->allOfType('dbo:Work');
            $books = $graph->allOfType('dbo:WrittenWork');
            $films = $graph->allOfType('dbo:Film');
            $people = $graph->allOfType('foaf:Person');
            dd($graph->allOfType('owl:SameAs'));
        }
    }

    function searchBooks(Request $request){
        $authorUri = $request->get('authorUri');
        $illustratorUri = $request->get('illustratorUri');
        $countryUri = $request->get('countryUri');
        $releaseDate= $request->get('releaseDate');
        $literaryGenreUri= $request->get('literaryGenreUri');
        $name = $request->get('name');
        $numberOfPagesMin = $request->get('numberOfPagesMin');
        $numberOfPagesMax = $request->get('numberOfPagesMax');
        $numberOfVolumes = $request->get('numberOfVolumes');
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $query='select * where {
                ?book a dbo:WrittenWork;
                    rdfs:label ?label;
                    dbo:author ?author;
                    dbp:genre ?genre.

                optional {
                ?book dbo:illustrator ?illustrator;
                    dbo:numberOfPages ?numberOfPages;
                    dbo:numberOfVolumes ?numberOfVolumes;
                    dbp:releaseDate ?releaseDate;
                    dbp:country ?country.
                    ' ;

        if(isset($authorUri)){
            $query .= "\n".'?book dbo:author <'.$authorUri.'>.';
        }
        if(isset($illustratorUri)){
            $query .= "\n".'?book dbo:illustrator <'.$illustratorUri.'>.';
        }
        if(isset($literaryGenreUri)){
            $query .= "\n".'?book dbo:genre <'.$literaryGenreUri.'>.';
        }
        if(isset($countryUri)){
            $query .= "\n".'?book dbp:country <'.$countryUri.'>.';
        }
        $query .= "} \n".'filter ( lang(?label) = "en" )';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter contains(?label, "'.$name.'"^^xsd:string)';
        }
        if(isset($numberOfPagesMin)){
            $query .= "\n".'filter (numberOfPages >= '.$numberOfPagesMin.')';
        }
        if(isset($numberOfPagesMax)){
            $query .= "\n".'filter (numberOfPages >= '.$numberOfPagesMax.')';
        }
        if(isset($numberOfVolumes)){
            $query .= "\n".'filter (numberOfVolumes = '.$numberOfVolumes.')';
        }
        if(isset($releaseDate)){
            $query .= "\n".'filter (releaseDate = '.$releaseDate.')';
        }
        $query .= '}  limit 30';
//dd($query);
        $result = $sparql->query($query);dd($result);
        (new RdfController())->initRdf();
    }

    function recommendBooks(){
        
    }
}
