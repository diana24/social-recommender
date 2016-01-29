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
        $startDateMin = $request->get('startDateMin');
        $startDateMax = $request->get('startDateMax');
        $endDateMin = $request->get('endDateMin');
        $endDateMax = $request->get('endDateMax');

        (new RdfController())->initRdf();
        $query='select * where {
                { ?event rdf:type dbo:Event }.
                ?event rdfs:label ?label.
                optional{{?event dbo:wikiPageExternalLink ?wiki} union {?event dbp:wikiPageExternalLink ?wiki}}.
                optional { {?event dbo:location ?location} union {?event dbp:location ?location} }.
                optional { {?event dbo:startDate ?startDate} union {?event dbp:startDate ?startDate} }.
                optional { {?event dbo:endDate ?endDate} union {?event dbp:endDate ?endDate} }.
                optional { {?event dbp:imageCaption ?image} union {?event dbo:imageCaption ?image} union {?event foaf:depiction ?image} }.';
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
            

            if(isset($row->image)){
                $event['image']=(method_exists($row->image, 'getUri')) ? $row->image->getUri() : (
                (method_exists($row->image, 'getValue')) ? $row->image->getValue() : $row->image
                );
            }
            if(isset($row->startDate)){
                $event['startDate']= method_exists($row->startDate, 'getValue') ? $row->startDate->getValue() : $row->startDate;
            }
            if(isset($row->endDate)){
                $event['endDate']= method_exists($row->endDate, 'getValue') ? $row->endDate->getValue() : $row->endDate;
            }
            $events[$uri]=$event;
        }
//        dd($events);
        return json_encode($events);
    }

}
