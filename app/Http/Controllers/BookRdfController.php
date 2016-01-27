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
    function searchBooks(Request $request=null){
        (new RdfController())->initRdf();
        if(!$request){
            return json_encode([]);
        }
        $authorUri = $request->get('authorUri');
        $illustratorUri = $request->get('illustratorUri');
//        $releaseDate= $request->get('releaseDate');
        $literaryGenreUri= $request->get('literaryGenreUri');
        $name = $request->get('name');
        $numberOfPagesMin = $request->get('numberOfPagesMin');
        $numberOfPagesMax = $request->get('numberOfPagesMax');
        $numberOfVolumes = $request->get('numberOfVolumes');

        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');

        $query='select *
                where {
                { ?book rdf:type dbo:WrittenWork }
                 union
                { ?book rdf:type <http://dbpedia.org/class/Book> }
                  union
                { ?book rdf:type owl:Thing }.
                ?book rdfs:label ?label.

                optional { {?book dbo:author ?author} union {?book dbp:author ?author} }.
                optional { {?book dbo:illustrator ?illustrator} union {?book dbp:illustrator ?illustrator}}.
                optional { {?book dbo:genre ?genre} union {?book dbp:genre ?genre}}.
                optional { {?book dbp:imageCaption ?image} union {?book dbo:imageCaption ?image} union {?book foaf:depiction ?image} }.
                optional { {?book dbo:numberOfPages ?numberOfPages} union {?book dbp:numberOfPages ?numberOfPages} }.
                optional { {?book dbo:numberOfVolumes ?numberOfVolumes} union {?book dbp:numberOfVolumes ?numberOfVolumes} }.
                optional { {?book dbp:releaseDate ?releaseDate} union {?book dbo:releaseDate ?releaseDate} }.';

        if(isset($authorUri)){
            $query .= "\n".' {?book dbo:author <'.$authorUri.'>} union {?book dbp:author <'.$authorUri.'>} .';
        }
        if(isset($illustratorUri)){
            $query .= "\n".'{?book dbo:illustrator <'.$illustratorUri.'>} union {?book dbp:illustrator <'.$illustratorUri.'>} .';
        }
        if(isset($literaryGenreUri)){
            $query .= "\n".'{?book dbo:genre <'.$literaryGenreUri.'>} union {?book dbp:genre <'.$literaryGenreUri.'>}.';
        }
        $query .= "\n".'filter ( lang(?label) = "en")';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?label), "'.$name.'"^^xsd:string, "i")';
        }
        if(isset($numberOfPagesMin)){
            $query .= "\n".'filter (?numberOfPages >= '.$numberOfPagesMin.')';
        }
        if(isset($numberOfPagesMax)){
            $query .= "\n".'filter (?numberOfPages <= '.$numberOfPagesMax.')';
        }
        if(isset($numberOfVolumes)){
            $query .= "\n".'filter (?numberOfVolumes = '.$numberOfVolumes.')';
        }
//        if(isset($releaseDate)){
//            $query .= "\n".'filter (?releaseDate = '.$releaseDate.')';
//        }
        $query .= '}  limit 50'; //dd($query);

        $result = $sparql->query($query); //dd($result);

        $books=[];
        foreach($result as $row){
            $uri = $row->book->getUri();
            if(!array_has($books,$uri)){
                $books[$uri]=[];
            }
            $book=$books[$uri];
            $book['title']=$row->label->getValue();
            if(isset($row->author) && method_exists($row->author, 'getUri')){
                $authorUri = $row->author->getUri();
                $query = 'select ?authorName where { <'.$authorUri.'> rdfs:label ?authorName . filter (lang(?authorName)="en")} limit 1';
                $r = $sparql->query($query);
                foreach($r as $rw){
                    if(isset($rw->authorName)){
                        $authorName = $rw->authorName->getValue();
                        if(!isset($book['authors'])){
                            $book['authors']=[];
                        }
                        if(!array_has($book['authors'],$authorUri)){
                            $book['authors'][$authorUri]=$authorName;
                        }
                    }
                }                
                
            }
            if(isset($row->illustrator) && method_exists($row->illustrator, 'getUri')){
                $illustratorUri = $row->illustrator->getUri();
                $query = 'select ?illustratorName where { <'.$illustratorUri.'> rdfs:label ?illustratorName . filter (lang(?illustratorName)="en")} limit 1';
                $r = $sparql->query($query);
                foreach($r as $rw){
                    if(isset($rw->illustratorName)){
                        $illustratorName = $rw->illustratorName->getValue();
                        if(!isset($book['illustrators'])){
                            $book['illustrators']=[];
                        }
                        if(!array_has($book['illustrators'],$illustratorUri)){
                            $book['illustrators'][$illustratorUri]=$illustratorName;
                        }
                    }
                }

            }
            if(isset($row->genre) && method_exists($row->genre, 'getUri')){
                $genreUri = $row->genre->getUri();
                $query = 'select ?genreName where { <'.$genreUri.'> rdfs:label ?genreName . filter (lang(?genreName)="en")} limit 1';
                $r = $sparql->query($query);
                foreach($r as $rw){
                    if(isset($rw->genreName)){
                        $genreName = $rw->genreName->getValue();
                        if(!isset($book['genres'])){
                            $book['genres']=[];
                        }
                        if(!array_has($book['genres'],$genreUri)){
                            $book['genres'][$genreUri]=$genreName;
                        }
                    }
                }

            }

            if(isset($row->image)){
                $book['image']=(method_exists($row->image, 'getUri')) ? $row->image->getUri() : (
                (method_exists($row->image, 'getValue')) ? $row->image->getValue() : $row->image
                );
            }
            if(isset($row->releaseDate)){
                $book['releaseDate']= method_exists($row->releaseDate, 'getValue') ? $row->releaseDate->getValue() : $row->releaseDate;
            }
            if(isset($row->numberOfPages)){
                $book['numberOfPages']= method_exists($row->numberOfPages, 'getValue') ? $row->numberOfPages->getValue() : $row->numberOfPages;
            }
            if(isset($row->numberOfVolumes)){
                $book['numberOfVolumes']= method_exists($row->numberOfVolumes, 'getValue') ? $row->numberOfVolumes->getValue() : $row->numberOfVolumes;
            }
            $books[$uri]=$book;
        }
        return json_encode($books);
    }

    function recommendBooks(){
        $mybooks =  (new RdfController())->getBooks(); //dd($mybooks);
        $books=[];
        $i=0;

        shuffle($mybooks);

        $n=10;
        while($n>count($mybooks)){
            $n--;
        }

        $mybooks = array_slice($mybooks, 0, $n);

        foreach($mybooks as $mb){
            try{
                $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
                $query = 'select distinct ?book where {

                { ?book rdf:type dbo:WrittenWork }
                 union
                { ?book rdf:type <http://dbpedia.org/class/Book> }
                  union
                { ?book rdf:type owl:Thing }.

                ?book rdfs:label ?label.
                {?book dbo:author ?author} union {?book dbp:author ?author}
                ?author rdfs:label ?authorName

                {?book dbo:publisher ?publisher} union {?book dbp:publisher ?publisher}
                ?publisher rdfs:label ?publisherName

                {?book dbo:genre ?gen} union {?book dbp:genre ?gen}.
                ?gen rdfs:label ?genLabel.

                filter ( lang(?label) = "en" )
                {filter regex(str(?genLabel), "' . $mb['genre'] . '"^^xsd:string, "i")}';
                foreach($mb['authors'] as $author){
                    $query .= ' union {filter regex(str(?authorName), "' . $author . '"^^xsd:string, "i")}';
                }
                foreach($mb['publishers'] as $publisher){
                    $query .= ' union {filter regex(str(?publisherName), "' . $publisher . '"^^xsd:string, "i")}';
                }
                $query .= '} limit 10';

                $result = $sparql->query($query);
                foreach($result as $row){
                    $uri = $row->book->getUri();
                    $book = $this->getBookData($uri);
                    array_push($books,$book);
                }
            }
            catch(\Exception $e){

            }

        }
        dd($books);
    }
}
