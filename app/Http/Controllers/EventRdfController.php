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
        $locationUri = $request->get('locationUri');
        $startDateMin = $request->get('startDateMin');
        $startDateMax = $request->get('startDateMax');
        $endDateMin = $request->get('endDateMin');
        $endDateMax = $request->get('endDateMax');

        (new RdfController())->initRdf();
        $query='select distinct ?event where {
                { ?event rdf:type dbo:Event }
                  union
                { ?event rdf:type owl:Thing }.
                ?event rdfs:label ?label.';
        $query .= '} limit 10';

        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query($query);
        dd($result);
    }
}
