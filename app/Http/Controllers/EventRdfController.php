<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyRdf_Graph;
use EasyRdf_Namespace;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;

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
        $query='select distinct ?event where {
                { ?event rdf:type dbo:Event }.
                ?event rdfs:label ?label.
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
        if(isset($startDateMin)){
            $query .= "\n".'filter (?startDate >= "'.$startDateMin.'"^^xsd:dateTime)';
        }
        if(isset($startDateMax)){
            $query .= "\n".'filter (?startDate <= "'.$startDateMax.'"^^xsd:dateTime)';
        }
        if(isset($endDateMin)){
            $query .= "\n".'filter (?endDate >= "'.$endDateMin.'"^^xsd:dateTime)';
        }
        if(isset($endDateMax)){
            $query .= "\n".'filter (?endDate <= "'.$endDateMax.'"^^xsd:dateTime)';
        }
        $query .= '} limit 10';

        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query($query);
//        dd($result);
//
        $events=[];
        foreach($result as $row){
            $uri = $row->event->getUri();
            $event = $this->getEventData($uri);
            array_push($events,$event);
        }
        return json_encode($events);
    }

    public function getEventData($uri){
        $event=[];
        $event['uri']=$uri;
        $query = 'select ?label where{
                <'.$uri.'> rdfs:label ?label.
                filter(lang(?label)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $event['name']=$a->label->getValue();
        }
        $query = 'select distinct ?location, ?locationName where{
                {<'.$uri.'> dbo:location ?location} union {<'.$uri.'> dbp:location ?location}.
                ?location rdfs:label ?locationName.
                filter(lang(?locationName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $event['locations']=[];
            $location['uri']=$a->location->getUri();
            $location['name']=$a->locationName->getValue();
            array_push($event['locations'],$location);
        }
        $query = 'select distinct ?type, ?typeName where{
                <'.$uri.'> rdf:type ?type.
                ?type rdfs:label ?typeName.
                filter(lang(?typeName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $event['types']=[];
            $location['uri']=$a->type->getUri();
            $location['name']=$a->typeName->getValue();
            array_push($event['types'],$location);
        }
        $query = 'select distinct ?image where{
                {<'.$uri.'> dbo:imageCaption ?image} union {<'.$uri.'> dbp:imageCaption ?image} union {<'.$uri.'> foaf:depiction ?image}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $event['images']=[];
            $im = (method_exists($a->image,'getUri')) ? $a->image->getUri() : $a->image->getValue();
            array_push($event['images'],$im);
        }
        $query = 'select distinct ?startDate where{
                {<'.$uri.'> dbo:startDate ?startDate} union {<'.$uri.'> dbp:startDate ?startDate}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $event['startDates']=[];
            $im = (method_exists($a->startDate,'getValue')) ? $a->startDate->getValue() : $a->startDate;
            array_push($event['startDates'],$im);
        }
        $query = 'select distinct ?endDate where{
                {<'.$uri.'> dbo:endDate ?endDate} union {<'.$uri.'> dbp:endDate ?endDate}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $event['endDates']=[];
            $im = (method_exists($a->endDate,'getValue')) ? $a->endDate->getValue() : $a->endDate;
            array_push($event['endDates'],$im);
        }


        return $event;
    }
}
