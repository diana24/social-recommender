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

class EventRdfController extends Controller
{
    public function searchEvents(Request $request=null){
        if(!$request){
            return json_encode([]);
        }
        $name = $request->get('name');
        $eventTypeUri = $request->get('eventTypeUri');
        $locationUri = $request->get('locationUri');
        $startDateMin = str_replace("/", "-", $request->get('startDateMin'));
        $startDateMax = str_replace("/", "-", $request->get('startDateMax'));
        $endDateMin = str_replace("/", "-", ('endDateMin'));
        $endDateMax = str_replace("/", "-", $request->get('endDateMax'));

        (new RdfController())->initRdf();
        $query='select * where {
                { ?event rdf:type dbo:Event }.
                ?event rdfs:label ?label.
                optional{{?event dbo:wikiPageExternalLink ?wiki} union {?event dbp:wikiPageExternalLink ?wiki}}.
                optional { {?event dbo:location ?location} union {?event dbp:location ?location} }.
                optional { {?event dbo:startDate ?startDate} union {?event dbp:startDate ?startDate} }.
                optional { {?event dbo:endDate ?endDate} union {?event dbp:endDate ?endDate} }.';
        if(isset($locationUri)){
            $query .= "\n".' {?event dbo:location <'.$locationUri.'>} union {?event dbp:location <'.$locationUri.'>} .';
        }
        if(isset($eventTypeUri)){
            $query .= "\n".' ?event rdf:type <'.$eventTypeUri.'> .';
        }
        $query .= "\n".'filter ( lang(?label) = "en" )';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?label), "'.$name.'"^^xsd:string, "i")';
        }
        if(isset($startDateMin) && strlen($startDateMin)){
            $query .= "\n".'filter (?startDate >= "'.$startDateMin.'"^^xsd:dateTime)';
        }
        if(isset($startDateMax) && strlen($startDateMax)){
            $query .= "\n".'filter (?startDate <= "'.$startDateMax.'"^^xsd:dateTime)';
        }
        if(isset($endDateMin) && strlen($endDateMin)){
            $query .= "\n".'filter (?endDate >= "'.$endDateMin.'"^^xsd:dateTime)';
        }
        if(isset($endDateMax) && strlen($endDateMax)){
            $query .= "\n".'filter (?endDate <= "'.$endDateMax.'"^^xsd:dateTime)';
        }
        $query .= '} limit 50';

        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');

        try{
            $result = $sparql->query($query);
        } catch(\Exception $e){
            return json_encode([]);
        }
//
        $events=[];
        foreach($result as $row){
            $uri = $row->event->getUri();
            if(!array_has($events,$uri)){
                $events[$uri]=[];
            }
            $event=$events[$uri];
            if(isset($row->wiki)){
                $event['link']=(method_exists($row->wiki, 'getUri')) ? $row->wiki->getUri() : (
                (method_exists($row->wiki, 'getValue')) ? $row->wiki->getValue() : $row->wiki
                );
            }
            else{
                $event['link']=$uri;
            }
            $event['title']=$row->label->getValue();
            if(isset($row->type) && method_exists($row->type, 'getUri')){
                $typeUri = $row->type->getUri();
                if(!isset($event['types'])){
                    $event['types']=[];
                }
                if(!array_has($event['types'],$typeUri)){
                    $typeUri = $row->type->getUri();
                    $query = 'select ?typeName where { <'.$typeUri.'> rdfs:label ?typeName . filter (lang(?typeName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->typeName)){
                            $typeName = $rw->typeName->getValue();
                            $event['types'][$typeUri]=$typeName;
                        }
                    }
                }

            }
            $event['title']=$row->label->getValue();
            if(isset($row->location) && method_exists($row->location, 'getUri')){
                $locationUri = $row->location->getUri();
                if(!isset($event['locations'])){
                    $event['locations']=[];
                }
                if(!array_has($event['locations'],$locationUri)){
                    $locationUri = $row->location->getUri();
                    $query = 'select ?locationName where { <'.$locationUri.'> rdfs:label ?locationName . filter (lang(?locationName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->locationName)){
                            $locationName = $rw->locationName->getValue();
                            $event['locations'][$locationUri]=$locationName;
                        }
                    }
                }

            }
            if(isset($row->startDate)){
                $event['startDate']= method_exists($row->startDate, 'getValue') ? $row->startDate->getValue() : $row->startDate;
            }
            if(isset($row->endDate)){
                $event['endDate']= method_exists($row->endDate, 'getValue') ? $row->endDate->getValue() : $row->endDate;
            }
            $events[$uri]=$event;
        }

        return json_encode($events);
    }


    public function recommendEvents()
    {
        $coords = [];
        $path = Auth::user()->getGraphPath();
        (new RdfController())->initRdf();
        $graph = \App\Http\EasyRdf\EasyRdf_Graph::newAndLoad($path, 'rdfxml');
        $person = $graph;

        if ($graph->type() == 'foaf:PersonalProfileDocument') {
            $person = $graph->primaryTopic();
        } elseif ($graph->type() == 'foaf:Person') {
            $person = $graph->resource();
        }
        $c = $person->get('foaf:based_near');
        if (isset($c)) {
            $mycoord['lat'] = $c->get('geo:lat')->getValue();
            $mycoord['long'] = $c->get('geo:long')->getValue();
            array_push($coords, $mycoord);
        }
        foreach ($person->all('foaf:knows') as $p) {
            $c = $p->get('foaf:based_near');
            if (isset($c)) {
                $mycoord['lat'] = $c->get('geo:lat')->getValue();
                $mycoord['long'] = $c->get('geo:long')->getValue();
                array_push($coords, $mycoord);
            }
        }
        $i = 0;

        shuffle($coords);

        $n = 5;
        while ($n > count($coords)) {
            $n--;
        }

        $events = [];

        foreach ($coords as $c) {
            $lat = $c['lat'];
            $long = $c['long'];

            $query = 'select ?event, ?label, MIN(?location) as ?loc, ?locationLabel, ?startDate, ?endDate, ?wiki where {
                { ?event rdf:type dbo:Event }.
                ?event rdfs:label ?label.
                optional{{?event dbo:wikiPageExternalLink ?wiki} union {?event dbp:wikiPageExternalLink ?wiki}}.
                {?event dbo:location ?location} union {?event dbp:location ?location}.
                ?location rdf:type dbo:Place.
                ?location rdfs:label ?locationLabel.
                ?location geo:lat ?lat.
                ?location geo:long ?long.
                optional { {?event dbo:startDate ?startDate} union {?event dbp:startDate ?startDate} }.
                optional { {?event dbo:endDate ?endDate} union {?event dbp:endDate ?endDate} }.';


            $query .= "\n" . 'filter ( lang(?label) = "en" && lang(?locationLabel) = "en")';
            $query .= "\n" . 'filter ( ?long > ' . $long . ' - 2 && ?long < ' . $long . ' + 2 && ?lat > ' . $lat . ' - 2 && ?lat < ' . $lat . ' + 2)';

            $query .= '} limit 50';

            $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');

            try {
                $result = $sparql->query($query); //dd($result);
                foreach($result as $row){
                    $uri = $row->event->getUri();
                    if(!array_has($events,$uri)){
                        $events[$uri]=[];
                    }
                    $event=$events[$uri];
                    if(isset($row->wiki)){
                        $event['link']=(method_exists($row->wiki, 'getUri')) ? $row->wiki->getUri() : (
                        (method_exists($row->wiki, 'getValue')) ? $row->wiki->getValue() : $row->wiki
                        );
                    }
                    else{
                        $event['link']=$uri;
                    }
                    $event['title']=$row->label->getValue();

                    if(isset($row->loc) && method_exists($row->loc, 'getUri')){
                        $event['location']['uri']=$row->loc->getUri();
                    }
                    if(isset($row->locationLabel) && method_exists($row->locationLabel, 'getValue')){
                        $event['location']['name']=$row->locationLabel->getValue();
                    }
                if(isset($row->startDate)){
                    $event['startDate']= method_exists($row->startDate, 'getValue') ? $row->startDate->getValue() : $row->startDate;
                }
                if(isset($row->endDate)){
                    $event['endDate']= method_exists($row->endDate, 'getValue') ? $row->endDate->getValue() : $row->endDate;
                }
                $events[$uri]=$event;
            }
            } catch (\Exception $e) { //dd($e);
                return json_encode([]);
            }
        }

        return json_encode($events);
    }

}
