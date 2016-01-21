<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyRdf_Graph;
use EasyRdf_Namespace;
use EasyRdf_Sparql_Client;

class RdfController extends Controller
{
    function initRdf(){
        EasyRdf_Namespace::set('postcode', 'http://data.ordnancesurvey.co.uk/ontology/postcode/');
        EasyRdf_Namespace::set('sr', 'http://data.ordnancesurvey.co.uk/ontology/spatialrelations/');
        EasyRdf_Namespace::set('eg', 'http://statistics.data.gov.uk/def/electoral-geography/');
        EasyRdf_Namespace::set('ag', 'http://statistics.data.gov.uk/def/administrative-geography/');
        EasyRdf_Namespace::set('osag', 'http://data.ordnancesurvey.co.uk/ontology/admingeo/');

        EasyRdf_Namespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
        EasyRdf_Namespace::set('rel', 'http://www.perceive.net/schemas/relationship/');
        EasyRdf_Namespace::set('owl', 'http://www.w3.org/2002/07/owl#');
        EasyRdf_Namespace::set('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
        EasyRdf_Namespace::set('dbo', 'http://dbpedia.org/ontology/');
        EasyRdf_Namespace::set('dbp', 'http://dbpedia.org/property/');
        EasyRdf_Namespace::set('sch', 'http://schema.org');
    }

    public function getMyData(EasyRdf_Graph $graph){
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
        if($person->get('foaf:homepage')){
            $me['homepage']=$person->get('foaf:homepage')->getUri();
        }
        if($person->get('foaf:gender')){
            $me['gender']=$person->get('foaf:gender')->getValue();
        }
        if($person->get('dbo:occupation')){
            $me['occupation']=$person->get('dbo:occupation')->getValue();
        }
//        $me['schools']=[];dd($person->get('dbo:school'));
//        foreach($person->get('dbo:school') as $school){dd($school);
//            array_add($me['schools'],$school->get('dbp:name')->getValue());
//        }
//        dd($me);
        return $me;
    }

    public function getEvents(EasyRdf_Graph $graph){
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
        dd($events);
        return $events;
    }

    public function getBooks(EasyRdf_Graph $graph){
        $books=[];
        foreach($graph->resources() as $resource){
            if($resource->type() == 'sch:Book'){
                $book=[];
                if($resource->get('sch:name')){
                    $book['name'] = $resource->get('sch:name')->getValue();
                }

                if($resource->get('sch:description')){
                    $book['description'] = $resource->get('sch:description')->getValue();
                }

                if($resource->get('sch:isbn')){
                    $book['isbn'] = $resource->get('sch:isbn')->getValue();
                }

                if($resource->get('sch:numberOfPages')){
                    $book['numberOfPages'] = $resource->get('sch:numberOfPages')->getValue();
                }

                if($resource->get('sch:genre')){
                    $book['genre'] = $resource->get('sch:genre')->getValue();
                }

                array_push($books,$book);
            }
        }
        dd($books);
        return $books;
    }

    function test(){
        $this->initRdf();
        $docuri = url("/")."/graphs/2.xml";
        $graph = EasyRdf_Graph::newAndLoad($docuri, 'rdfxml');

        $this->getBooks($graph);

//        dd(json_decode($graph->serialise('json')));
//        return $graph->dump('html');


//        $books = $person->resource('sch:Book');
        dd($person->get('foaf:name'));

        EasyRdf_Namespace::set('category', 'http://dbpedia.org/resource/Category:');
        EasyRdf_Namespace::set('dbpedia', 'http://dbpedia.org/resource/');

        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query(
            'SELECT * WHERE {'.
            '  ?country rdf:type dbo:Book .'.
            '  ?country rdfs:label ?label .'.
            '  ?country dc:subject category:Fiction .'.
            '  FILTER ( lang(?label) = "en" )'.
            '} ORDER BY ?label '.
            'LIMIT 20'
        );

        foreach($result as $row){
            dd($row);
        }
    }
}
