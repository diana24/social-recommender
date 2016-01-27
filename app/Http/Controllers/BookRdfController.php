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
    function getBookData($uri){
        $book=[];
        $book['uri']=$uri;
        $query = 'select ?label where{
                <'.$uri.'> rdfs:label ?label.
                filter(lang(?label)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $book['name']=$a->label->getValue();
        }
        $query = 'select distinct ?author, ?authorName where{
                {<'.$uri.'> dbo:author ?author} union {<'.$uri.'> dbp:author ?author}.
                ?author rdfs:label ?authorName.
                filter(lang(?authorName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $book['authors']=[];
            $author['uri']=$a->author->getUri();
            $author['name']=$a->authorName->getValue();
            array_push($book['authors'],$author);
        }
        $query = 'select distinct ?image where{
                {<'.$uri.'> dbo:imageCaption ?image} union {<'.$uri.'> dbp:imageCaption ?image} union {<'.$uri.'> foaf:depiction ?image}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $book['images']=[];
            $im = (method_exists($a->image,'getUri')) ? $a->image->getUri() : $a->image->getValue();
            array_push($book['images'],$im);
        }

        $query = 'select distinct ?illustrator, ?illustratorName where{
                {<'.$uri.'> dbo:illustrator ?illustrator} union {<'.$uri.'> dbp:illustrator ?illustrator}.
                ?illustrator rdfs:label ?illustratorName.
                filter(lang(?illustratorName)="en")
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $book['illustrators']=[];
            $illustrator['uri']=$a->illustrator->getUri();
            $illustrator['name']=$a->illustratorName->getValue();
            array_push($book['illustrators'],$illustrator);
        }
        $query = 'select distinct ?genre, ?genreName where{
                {<'.$uri.'> dbo:genre ?genre} union {<'.$uri.'> dbp:genre ?genre}.
                ?genre rdfs:label ?genreName.
                filter(lang(?genreName)="en")
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $book['genres']=[];
            $genre['uri']=$a->genre->getUri();
            $genre['name']=$a->genreName->getValue();
            array_push($book['genres'],$genre);
        }
        $query = 'select ?numberOfPages where{
                {<'.$uri.'> dbo:numberOfPages ?numberOfPages} union {<'.$uri.'> dbp:numberOfPages ?numberOfPages}.
            }';
        $a = $sparql->query($query);
        $book['numberOfPages']=null;
        foreach($a as $n){
            $book['numberOfPages']= (method_exists($n->numberOfPages, 'getValue')) ? $n->numberOfPages->getValue() : $n->numberOfPages;
//                dd($book);
        }
        $query = 'select ?numberOfVolumes where{
                {<'.$uri.'> dbo:numberOfVolumes ?numberOfVolumes} union {<'.$uri.'> dbp:numberOfVolumes ?numberOfVolumes}.
            }';
        $a = $sparql->query($query);
        $book['numberOfVolumes']=null;
        foreach($a as $n){
            $book['numberOfVolumes']= (method_exists($n->numberOfVolumes, 'getValue')) ? $n->numberOfVolumes->getValue() : $n->numberOfVolumes;
//                dd($book);
        }





//        foreach($result as $row){
//            $book['title']=$row->label->getValue();
//            if(isset($row->author)){
//                if(method_exists($row->author,'getUri')){
//                    $book['author']=$row->author->getUri();
//                }
//                else{
//                    $book['author']=$row->author->getValue();
//                }
//            }
//            if(isset($row->illustrator)){
//                if(method_exists($row->illustrator,'getUri')){
//                    $book['illustrator']=$row->illustrator->getUri();
//                }
//                else{
//                    $book['illustrator']=$row->illustrator->getValue();
//                }
//            }
//            if(isset($row->genre)){
//                if(method_exists($row->genre,'getUri')){
//                    $book['genre']=$row->genre->getUri();
//                }
//                else{
//                    $book['genre']=$row->genre->getValue();
//                }
//            }
//            if(isset($row->image)){
//                $book['image']=$row->image->getUri();
//            }
//            if(isset($row->releaseDate)){
//                $book['releaseDate']=$row->releaseDate->getValue();
//            }
//            if(isset($row->numberOfPages)){
//                $book['numberOfPages']=$row->numberOfPages->getValue();
//            }
//            if(isset($row->numberOfPages)){
//                $book['numberOfVolumes']=$row->numberOfVolumes->getValue();
//            }
//            array_push($books,$book);
//        }
//        dd($books);
        return $book;
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

        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');

        $query='select distinct ?book where {
                { ?book rdf:type dbo:WrittenWork }
                 union
                { ?book rdf:type <http://dbpedia.org/class/Book> }
                  union
                { ?book rdf:type owl:Thing }.
                ?book rdfs:label ?label.
                optional { {?book dbo:author ?author} union {?book dbp:author ?author} }.
                optional { {?book dbo:illustrator ?illustrator} union {?book dbp:illustrator ?illustrator} }.
                optional { {?book dbo:genre ?genre} union {?book dbp:genre ?genre} }.
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
        $query .= "\n".'filter ( lang(?label) = "en" )';
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
        $query .= '}  limit 10';

        $result = $sparql->query($query);

        $books=[];
        foreach($result as $row){
            $uri = $row->book->getUri();
            $book = $this->getBookData($uri);
            array_push($books,$book);
        }
        return json_encode($books);
    }

    function getBookUri($resourceName){

        $aux = str_replace(" ","_",ucwords(strtolower($resourceName)));
        (new RdfController())->initRdf();
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $uri = 'http://dbpedia.org/resource/'.$resourceName; //dd($uri);

        $result = $sparql->query(
            'select distinct ?book where{
            ?book rdfs:label ?label.
            filter (regex(str(?label)), "^'.$resourceName.'$","i")
        }  limit 10'
        );
        dd($result);
        if(count($result)<=0){
            return null;
        }
        foreach($result as $row){
            $uri = $row->book->getUri();
            if(strtolower($uri) == strtolower("http://dbpedia.org/resource/".$aux)){
                return $uri;
            }
        }
        return null;
    }
    function recommendBooks(){
        $mybooks =  (new RdfController())->getBooks(); //dd($mybooks);
        $books=[];
        foreach($mybooks as $mb){
            try{
                $uri = $this->getBookUri($mb['name']);
                if($uri){
                    dd($uri."\n");
                    $book = $this->getBookData($uri);
                    array_push($books,$book);
                }
            }catch(\Exception $e){
dd($e);
            }

        }
        dd($books);
    }
}
