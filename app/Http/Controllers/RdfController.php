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

class RdfController extends Controller
{
    function initRdf(){
        \App\Http\EasyRdf\EasyRdf_Namespace::set('postcode', 'http://data.ordnancesurvey.co.uk/ontology/postcode/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('sr', 'http://data.ordnancesurvey.co.uk/ontology/spatialrelations/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('eg', 'http://statistics.data.gov.uk/def/electoral-geography/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('ag', 'http://statistics.data.gov.uk/def/administrative-geography/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('osag', 'http://data.ordnancesurvey.co.uk/ontology/admingeo/');

        \App\Http\EasyRdf\EasyRdf_Namespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('rel', 'http://www.perceive.net/schemas/relationship/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('owl', 'http://www.w3.org/2002/07/owl#');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('dbo', 'http://dbpedia.org/ontology/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('dbr', 'http://dbpedia.org/resource/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('dbp', 'http://dbpedia.org/property/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('dbc', 'http://dbpedia.org/class/');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('sch', 'http://schema.org');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('dct', 'http://purl.org/dc/terms/');
//        EasyRdf_Namespace::set('bif', 'http://www.openlinksw.com/schemas/bif#');
        // http://bnb.data.bl.uk/sparql
    }

    public function getDBPediaUri($resourceName="J. K. Rowling"){
        $resourceName = str_replace(" ","_",ucwords(strtolower($resourceName)));
        $this->initRdf();
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $uri = 'http://dbpedia.org/resource/'.$resourceName; //dd($uri);
        $result = $sparql->query(
            'select ?uri ?id { values ?uri { <'.$uri.'> } ?uri <http://dbpedia.org/ontology/wikiPageID> ?id }'
        );
        $result = $sparql->query(
            'select ?uri ?id { values ?uri { <'.$uri.'> } ?uri <http://dbpedia.org/ontology/wikiPageID> ?id }'
        );
        if(count($result)<=0){
            return null;
        }
        return $result[0]->uri->getUri();
    }

    public function getResourceInfo($resourceName="The Lord of the Rings"){
//        $resourceName = str_replace(" ","_",ucwords(strtolower($resourceName)));
        $this->initRdf();
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
//        $uri = 'http://dbpedia.org/resource/'.$resourceName; //dd($uri);
        $query = 'describe ?book where { ?book dbp:name \''.$resourceName.'\'@en }';
//        $query = 'select * where { ?book rdf:type dbo:Book; dbp:name \''.$resourceName.'\'@en }';
        $result = $sparql->query($query);

        return $result;
    }

    public function getMyData(){
        $path = Auth::user()->getGraphPath();
        $this->initRdf();
        $graph = \App\Http\EasyRdf\EasyRdf_Graph::newAndLoad($path, 'rdfxml');
        $person = $graph;

        if ($graph->type() == 'foaf:PersonalProfileDocument') {
            $person = $graph->primaryTopic();
        } elseif ($graph->type() == 'foaf:Person') {
            $person = $graph->resource();
        }
        $me=[];
        if($person->get('foaf:name')){
            $me['name']=$person->get('foaf:name')->getValue();
        }
        if($person->get('foaf:givenname')){
            $me['givenname']=$person->get('foaf:givenname')->getValue();
        }
        if($person->get('foaf:family_name')){
            $me['family_name']=$person->get('foaf:family_name')->getValue();
        }
        if($person->get('foaf:depiction')){
            $me['depiction']=$person->get('foaf:depiction')->getUri();
        }
        if($person->get('sch:description')){
            $me['description']=$person->get('sch:description')->getValue();
        }
        if($person->get('foaf:homepage')){
            $me['homepage']=$person->get('foaf:homepage')->getUri();
        }
        if($person->get('foaf:gender')){
            $me['gender']=$person->get('foaf:gender')->getValue();
        }
        if($person->get('dbo:occupation')){
            $me['occupation']=$person->get('dbo:occupation')->getValue();
        }
        $me['schools']=[];
        if( $person->all('dbo:school') ){
            foreach($person->all('dbo:school') as $school){
                array_push($me['schools'],$school->get('dbp:name')->getValue());
            }
        }
        $me['pages']=[];
        if( $person->all('foaf:page') ){
            foreach($person->all('foaf:page') as $school){
                array_push($me['pages'],$school->getUri());
            }
        }
        $me['websites']=[];
        if( $person->all('foaf:websites') ){
            foreach($person->all('foaf:websites') as $school){
                array_push($me['websites'],$school->getUri());
            }
        }
        $me['countries']=[];
        if( $person->all('dbo:country') ){
            foreach($person->all('dbo:country') as $school){
                array_push($me['countries'],$school->get('dbo:name')->getValue());
            }
        }
        return $me;
    }

    public function getEvents(){
        $path = Auth::user()->getGraphPath();
        $this->initRdf();
        $graph = \App\Http\EasyRdf\EasyRdf_Graph::newAndLoad($path, 'rdfxml');
        $events=[];
        foreach($graph->resources() as $resource){
            if($resource->type() == 'sch:Event'){
                $event=[];
                if($resource->get('sch:name')){
                    $event['name'] = $resource->get('sch:name')->getValue();
                }
                if($resource->get('sch:description')){
                    $event['description'] = $resource->get('sch:description')->getValue();
                }
                if($resource->get('sch:startDate')){
                    $event['startDate'] = $resource->get('sch:startDate')->getValue();
                }
                if($resource->get('sch:endDate')){
                    $event['endDate'] = $resource->get('sch:endDate')->getValue();
                }
                if($resource->get('sch:url')){
                    $event['url'] = $resource->get('sch:url')->getUri();
                }
                if($resource->get('foaf:based_near')){
                    $event['based_near']['lat'] = $resource->get('foaf:based_near')->get('geo:lat')->getValue();
                    $event['based_near']['long'] = $resource->get('foaf:based_near')->get('geo:long')->getValue();
                }
                array_push($events,$event);
            }
        }
        return $events;
    }

    public function getBooks(){
        $path = Auth::user()->getGraphPath();
        $this->initRdf();
        $graph = \App\Http\EasyRdf\EasyRdf_Graph::newAndLoad($path, 'rdfxml');
        $books=[];
        foreach($graph->resources() as $resource){
            if($resource->type() == 'sch:Book'){
                $book=[];
                if($resource->get('sch:name')){
                    $book['name'] = $resource->get('sch:name')->getValue();
                }
                $book['authors']=[];
                foreach($resource->all('sch:author') as $author){
                    array_push($book['authors'], $author->get('foaf:name')->getValue());
                }
                if($resource->get('sch:description')){
                    $book['description'] = $resource->get('sch:description')->getValue();
                }
                $book['isbn']=[];
                foreach($resource->all('sch:isbn') as $isbn){
                    array_push($book['isbn'], $isbn->getValue());
                }
                $book['publishers']=[];
                foreach($resource->all('sch:publisher') as $publisher){
                    array_push($book['publishers'], $publisher->get('foaf:name')->getValue());
                }
                if($resource->get('sch:numberOfPages')){
                    $book['numberOfPages'] = $resource->get('sch:numberOfPages')->getValue();
                }

                if($resource->get('sch:genre')){
                    $book['genre'] = $resource->get('sch:genre')->getValue();
                }

                if($resource->get('sch:aggregateRating')){
                    $agr = $resource->get('sch:aggregateRating');
                    $count = $agr->get('sch:ratingCount')->getValue();
                    $value = $agr->get('sch:ratingValue')->getValue();
                    $book['ratingCount']=$count;
                    $book['ratingValue']=$value;
                }

                array_push($books,$book);
            }
        }
        return $books;
    }
    public function getSchools(){
        $path = Auth::user()->getGraphPath();
        $this->initRdf();
        $graph = \App\Http\EasyRdf\EasyRdf_Graph::newAndLoad($path, 'rdfxml');
        $books=[];
        foreach($graph->resources() as $resource){
            if($resource->type() == 'dbo:EducationalInstitution'){
                $book=[];
                if($resource->get('dbp:name')){
                    $book['name'] = $resource->get('dbp:name')->getValue();
                }
                array_push($books,$book);
            }
        }
        return $books;
    }

    public function getPeople(){
        $path = Auth::user()->getGraphPath();
        $this->initRdf();
        $graph = \App\Http\EasyRdf\EasyRdf_Graph::newAndLoad($path, 'rdfxml');
        $pp=[];
        if ($graph->type() == 'foaf:PersonalProfileDocument') {
            $person = $graph->primaryTopic();
        } elseif ($graph->type() == 'foaf:Person') {
            $person = $graph->resource();
        }
        foreach($person->all('foaf:knows') as $resource){ //dd($resource);
            
            
            $me=[];
            if($resource->get('foaf:name')){
                $me['name']=$resource->get('foaf:name')->getValue();
            }
            if($resource->get('foaf:givenname')){
                $me['givenname']=$resource->get('foaf:givenname')->getValue();
            }
            if($resource->get('foaf:family_name')){
                $me['family_name']=$resource->get('foaf:family_name')->getValue();
            }
            if($resource->get('sch:description')){
                $me['description']=$resource->get('sch:description')->getValue();
            }
            if($resource->get('foaf:depiction')){
                $me['depiction']=$resource->get('foaf:depiction')->getUri();
            }
            if($resource->get('foaf:homepage')){
                $me['homepage']=$resource->get('foaf:homepage')->getUri();
            }
            if($resource->get('foaf:gender')){
                $me['gender']=$resource->get('foaf:gender')->getValue();
            }
            if($resource->get('dbo:occupation')){
                $me['occupation']=$resource->get('dbo:occupation')->getValue();
            }
            $me['schools']=[];
            if( $resource->all('dbo:school') ){
                foreach($resource->all('dbo:school') as $school){
                    array_push($me['schools'],$school->get('dbp:name')->getValue());
                }
            }
            $me['pages']=[];
            if( $resource->all('foaf:page') ){
                foreach($resource->all('foaf:page') as $school){
                    array_push($me['pages'],$school->getUri());
                }
            }
            $me['websites']=[];
            if( $resource->all('foaf:websites') ){
                foreach($resource->all('foaf:websites') as $school){
                    array_push($me['websites'],$school->getUri());
                }
            }
            $me['countries']=[];
            if( $resource->all('dbo:country') ){
                foreach($resource->all('dbo:country') as $school){
                    array_push($me['countries'],$school->get('dbo:name')->getValue());
                }
            }

                array_push($pp,$me);
            }
    
        return $pp;
    }


    function getAutoRec($graphUri=""){

        $books = (new BookRdfController())->getBooks();
//        $me = $this->getMyData($graph);
//        $events = $this->getEvents($graph);

        foreach($books as $book){
            (new BookRdfController())->getBookRec($book);
        }

//        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
//        $result = $sparql->query(
//            'SELECT * WHERE {'.
//            '  ?book rdf:type dbo:Book .'.
//            '  ?book rdfs:label ?label .'.
//            '  ?book dbp:name ?name .'.
//            '  ?book dbo:author ?author .'.
//            '  ?book dbo:literaryGenre ?literaryGenre .'.
//            '  ?book dbo:numberOfPages ?numberOfPages .'.
//            '  ?book dbo:isbn ?isbn .'.
//            '  FILTER ( lang(?label) = "en" )'.
//            '} ORDER BY ?label '.
//            'LIMIT 10'
//        );

    }






































    function test(){
        $this->initRdf();
        $docuri = url("/")."/graphs/2.xml";
        $graph = \App\Http\EasyRdf\EasyRdf_Graph::newAndLoad($docuri, 'rdfxml');
//        return $graph->dump('html');

//        dd(json_decode($graph->serialise('json')));


//        $books = $person->resource('sch:Book');
//        dd($person->get('foaf:name'));







        \App\Http\EasyRdf\EasyRdf_Namespace::set('category', 'http://dbpedia.org/property/category:');
        \App\Http\EasyRdf\EasyRdf_Namespace::set('dbpedia', 'http://dbpedia.org/resource/');

        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'SELECT ?name, ?nr WHERE {'.
            '  ?book rdf:type dbo:Book .'.
            '  ?book rdfs:label ?label .'.
            '  ?book dbp:name ?name .'.
            '  ?book dbo:numberOfPages ?nr .'.
            '  ?book dbo:isbn ?isbn .'.
//            '  ?country dc:subject category:Fiction .'.
            '  FILTER ( lang(?label) = "en" )'.
            '} ORDER BY ?label '.
            'LIMIT 50'
        );
dd($result);
//        foreach($result as $row){
//            dd($row);
//        }
    }
}
