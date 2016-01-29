<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Http\EasyRdf\EasyRdf_Graph;
use \App\Http\EasyRdf\EasyRdf_Namespace;
use \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
ini_set('max_execution_time', 300);

class BookRdfController extends Controller
{
    function unify($result, \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client $sparql){
        $books=[];
        foreach($result as $row){
            $uri = $row->book->getUri();
            if(!array_has($books,$uri)){
                $books[$uri]=[];
            }
            $book=$books[$uri];
            if(isset($row->wiki)){
                $book['link']=(method_exists($row->wiki, 'getUri')) ? $row->wiki->getUri() : (
                (method_exists($row->wiki, 'getValue')) ? $row->wiki->getValue() : $row->wiki
                );
            }
            else{
                $book['link']=$uri;
            }
            $book['title']=$row->label->getValue();
            if(isset($row->author) && method_exists($row->author, 'getUri')){
                $authorUri = $row->author->getUri();
                if(!isset($book['authors'])){
                    $book['authors']=[];
                }
                if(!array_has($book['authors'],$authorUri)){
                    $authorUri = $row->author->getUri();
                    $query = 'select ?authorName where { <'.$authorUri.'> rdfs:label ?authorName . filter (lang(?authorName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->authorName)){
                            $authorName = $rw->authorName->getValue();
                            $book['authors'][$authorUri]=$authorName;
                        }
                    }
                }

            }
            if(isset($row->illustrator) && method_exists($row->illustrator, 'getUri')){
                $illustratorUri = $row->illustrator->getUri();
                if(!isset($book['illustrators'])){
                    $book['illustrators']=[];
                }
                if(!array_has($book['illustrators'],$illustratorUri)){
                    $illustratorUri = $row->illustrator->getUri();
                    $query = 'select ?illustratorName where { <'.$illustratorUri.'> rdfs:label ?illustratorName . filter (lang(?illustratorName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->illustratorName)){
                            $illustratorName = $rw->illustratorName->getValue();
                            $book['illustrators'][$illustratorUri]=$illustratorName;
                        }
                    }
                }

            }
            if(isset($row->genre) && method_exists($row->genre, 'getUri')){
                $genreUri = $row->genre->getUri();
                if(!isset($book['genres'])){
                    $book['genres']=[];
                }
                if(!array_has($book['genres'],$genreUri)){
                    $genreUri = $row->genre->getUri();
                    $query = 'select ?genreName where { <'.$genreUri.'> rdfs:label ?genreName . filter (lang(?genreName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->genreName)){
                            $genreName = $rw->genreName->getValue();
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
        return $books;
    }

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

        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');

        $query='select *
                where {
                { ?book rdf:type dbo:WrittenWork }
                 union
                { ?book rdf:type <http://dbpedia.org/class/Book> }
                  union
                { ?book rdf:type owl:Thing }.
                ?book rdfs:label ?label.

                optional{{?book dbo:wikiPageExternalLink ?wiki} union {?book dbp:wikiPageExternalLink ?wiki}}.
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
        $query .= '}  limit 200'; //dd($query);

        try{
            $result = $sparql->query($query);
        } catch(\Exception $e){
            return json_encode([]);
        }

        $books=$this->unify($result,$sparql);
//        dd($books);
        return json_encode($books);
    }

    function recommendBooks(){
        $mybooks =  (new RdfController())->getBooks(); //dd($mybooks);
        $books=[];
        $i=0;

        shuffle($mybooks);

        $n=5;
        while($n>count($mybooks)){
            $n--;
        }
        $results=[];
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $mybooks = array_slice($mybooks, 0, $n);
        foreach($mybooks as $mb){
            try{
                $query = 'select * where {

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


                {?book dbo:genre ?genre} union {?book dbp:genre ?genre}.
                ?genre rdfs:label ?genLabel.
                optional { {?book dbp:imageCaption ?image} union {?book dbo:imageCaption ?image} union {?book foaf:depiction ?image} }.
                optional{{?book dbo:wikiPageExternalLink ?wiki} union {?book dbp:wikiPageExternalLink ?wiki}}.

                filter ( lang(?label) = "en" && lang(?authorName) = "en" && lang(?publisherName) = "en" && lang(?genLabel) = "en")';
                if(isset($mb['genre'])){
                    $query .= 'optional {filter regex(str(?genLabel), "' . $mb['genre'] . '"^^xsd:string, "i")}';
                }
                foreach($mb['authors'] as $author){
                    $query .= ' optional {filter regex(str(?authorName), "' . $author . '"^^xsd:string, "i")}';
                }
                foreach($mb['publishers'] as $publisher){
                    $query .= ' optional {filter regex(str(?publisherName), "' . $publisher . '"^^xsd:string, "i")}';
                }
                $query .= '} limit 10';

                  $result = $sparql->query($query);
                array_push($results,$result);


            }catch (\Exception $e){
//                dd($e);
            }
    }
//        dd($results);
        foreach($results as $result){
            foreach($result as $row){
                $uri = $row->book->getUri();
                if(!array_has($books,$uri)){
                    $books[$uri]=[];
                }
                $book=$books[$uri];
                if(isset($row->wiki)){
                    $book['link']=(method_exists($row->wiki, 'getUri')) ? $row->wiki->getUri() : (
                    (method_exists($row->wiki, 'getValue')) ? $row->wiki->getValue() : $row->wiki
                    );
                }
                else{
                    $book['link']=$uri;
                }
                $book['title']=$row->label->getValue();
                if(isset($row->author) && method_exists($row->author, 'getUri')){
                    $authorUri = $row->author->getUri();
                    if(!isset($book['authors'])){
                        $book['authors']=[];
                    }
                    if(!array_has($book['authors'],$authorUri)){
                        $authorUri = $row->author->getUri();
                        $query = 'select ?authorName where { <'.$authorUri.'> rdfs:label ?authorName . filter (lang(?authorName)="en")} limit 1';
                        try{
                            $r = $sparql->query($query);

                            foreach($r as $rw){
                                if(isset($rw->authorName)){
                                    $authorName = $rw->authorName->getValue();
                                    $book['authors'][$authorUri]=$authorName;
                                }
                            }
                        }catch(\Exception $e){

                        }
                    }

                }
                if(isset($row->genre) && method_exists($row->genre, 'getUri')){
                    $genreUri = $row->genre->getUri();
                    if(!isset($book['genres'])){
                        $book['genres']=[];
                    }
                    if(!array_has($book['genres'],$genreUri)){
                        $genreUri = $row->genre->getUri();
                        $query = 'select ?genreName where { <'.$genreUri.'> rdfs:label ?genreName . filter (lang(?genreName)="en")} limit 1';
                        try{
                            $r = $sparql->query($query);
                            foreach($r as $rw){
                                if(isset($rw->genreName)){
                                    $genreName = $rw->genreName->getValue();
                                    $book['genres'][$genreUri]=$genreName;
                                }
                            }
                        }catch(\Exception $e){

                        }
                    }

                }
                if(isset($row->image)){
                    $book['image']=(method_exists($row->image, 'getUri')) ? $row->image->getUri() : (
                    (method_exists($row->image, 'getValue')) ? $row->image->getValue() : $row->image
                    );
                }
                $books[$uri]=$book;
            }
        }//dd($books);
        return json_encode($books);
    }
}
