<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyRdf_Graph;
use EasyRdf_Namespace;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;

class EducationalInstitutionController extends Controller
{
    public function searchEdu(Request $request=null){
        if(!$request){
            return json_encode([]);
        }
        $name = $request->get('name');
        $eduTypeUri = $request->get('eduTypeUri');
        $locationUri = $request->get('locationUri');
        $countryUri = $request->get('countryUri');
        $principalUri = $request->get('principalUri');
        $rectorUri = $request->get('rectorUri');
        $numberOfAcademicStaffMin = $request->get('nrOfAcademicStaffMin');
        $numberOfAcademicStaffMax = $request->get('nrOfAcademicStaffMax');
        $numberOfStudentsMin = $request->get('nrOfStudentsMin');
        $numberOfStudentsMax = $request->get('nrOfStudentsMax');

        (new RdfController())->initRdf();
        $query='select distinct ?edu where {
                { ?edu rdf:type dbo:EducationalInstitution }.
                ?edu rdfs:label ?label.
                optional { {?edu dbo:location ?location} union {?edu dbp:location ?location} }.
                optional { {?edu dbo:location ?location} union {?edu dbp:location ?location} }.
                optional { {?edu dbo:principal ?principal} union {?edu dbp:principal ?principal} }.
                optional { {?edu dbo:rector ?rector} union {?edu dbp:rector ?rector} }.
                optional { {?edu dbo:numberOfStudents ?endDate} union {?edu dbp:numberOfStudents ?numberOfStudents} }.
                optional { {?edu dbp:imageCaption ?image} union {?edu dbo:imageCaption ?image} union {?edu foaf:depiction ?image} }.';
        if(isset($locationUri)){
            $query .= "\n".' {?edu dbo:location <'.$locationUri.'>} union {?edu dbp:location <'.$locationUri.'>} .';
        }
        if(isset($countryUri)){
            $query .= "\n".' {?edu dbo:country <'.$countryUri.'>} union {?edu dbp:country <'.$countryUri.'>} .';
        }
        if(isset($principalUri)){
            $query .= "\n".' {?edu dbo:principal <'.$principalUri.'>} union {?edu dbp:principal <'.$principalUri.'>} .';
        }
        if(isset($rectorUri)){
            $query .= "\n".' {?edu dbo:rector <'.$rectorUri.'>} union {?edu dbp:rector <'.$rectorUri.'>} .';
        }
        if(isset($eduTypeUri)){
            $query .= "\n".' ?edu rdf:type <'.$eduTypeUri.'> .';
        }
        $query .= "\n".'filter ( lang(?label) = "en" )';
        if(isset($name) && strlen($name)){
            $query .= "\n".'filter regex(str(?label), "'.$name.'"^^xsd:string, "i")';
        }
        if(isset($numberOfAcademicStaffMin)){
            $query .= "\n".'filter (?numberOfAcademicStaff >= '.$numberOfAcademicStaffMin.')';
        }
        if(isset($numberOfAcademicStaffMax)){
            $query .= "\n".'filter (?numberOfAcademicStaff <= '.$numberOfAcademicStaffMax.')';
        }
        if(isset($numberOfStudentsMin)){
            $query .= "\n".'filter (?numberOfStudents >= '.$numberOfStudentsMin.')';
        }
        if(isset($numberOfStudentsMax)){
            $query .= "\n".'filter (?numberOfStudents <= '.$numberOfStudentsMax.')';
        }
        $query .= '} limit 10';

        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $result = $sparql->query($query);
//        dd($result);
//
        $eds=[];
        foreach($result as $row){
            $uri = $row->edu->getUri();
            $edu = $this->getEduData($uri);
            array_push($eds,$edu);
        }
        return json_encode($eds);
    }
    
    function getEduData($uri){
        $edu=[];
        $edu['uri']=$uri;
        $query = 'select ?label where{
                <'.$uri.'> rdfs:label ?label.
                filter(lang(?label)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $edu['name']=$a->label->getValue();
        }
        $query = 'select distinct ?principal, ?principalName where{
                {<'.$uri.'> dbo:principal ?principal} union {<'.$uri.'> dbp:principal ?principal}.
                ?principal rdfs:label ?principalName.
                filter(lang(?principalName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $edu['principals']=[];
            $principal['uri']=$a->principal->getUri();
            $principal['name']=$a->principalName->getValue();
            array_push($edu['principals'],$principal);
        }
        $query = 'select distinct ?rector, ?rectorName where{
                {<'.$uri.'> dbo:rector ?rector} union {<'.$uri.'> dbp:rector ?rector}.
                ?rector rdfs:label ?rectorName.
                filter(lang(?rectorName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $edu['rectors']=[];
            $rector['uri']=$a->rector->getUri();
            $rector['name']=$a->rectorName->getValue();
            array_push($edu['rectors'],$rector);
        }
        $query = 'select distinct ?country, ?countryName where{
                {<'.$uri.'> dbo:country ?country} union {<'.$uri.'> dbp:country ?country}.
                ?country rdfs:label ?countryName.
                filter(lang(?countryName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $edu['countries']=[];
            $location['uri']=$a->country->getUri();
            $location['name']=$a->countryName->getValue();
            array_push($edu['countries'],$location);
        }
        $query = 'select distinct ?type, ?typeName where{
                <'.$uri.'> rdf:type ?type.
                ?type rdfs:label ?typeName.
                filter(lang(?typeName)="en")
            } limit 10';
        $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $r = $sparql->query($query);

        foreach($r as $a){
            $edu['types']=[];
            $location['uri']=$a->type->getUri();
            $location['name']=$a->typeName->getValue();
            array_push($edu['types'],$location);
        }
        $query = 'select distinct ?image where{
                {<'.$uri.'> dbo:imageCaption ?image} union {<'.$uri.'> dbp:imageCaption ?image} union {<'.$uri.'> foaf:depiction ?image}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $edu['images']=[];
            $im = (method_exists($a->image,'getUri')) ? $a->image->getUri() : $a->image->getValue();
            array_push($edu['images'],$im);
        }
        $query = 'select distinct ?numberOfAcademicStaff where{
                {<'.$uri.'> dbo:numberOfAcademicStaff ?numberOfAcademicStaff} union {<'.$uri.'> dbp:numberOfAcademicStaff ?numberOfAcademicStaff}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $edu['numberOfAcademicStaff']=0;
            $im = (method_exists($a->numberOfAcademicStaff,'getValue')) ? $a->numberOfAcademicStaff->getValue() : $a->numberOfAcademicStaff;
            $edu['numberOfAcademicStaff']=$im;
        }
        $query = 'select distinct ?endDate where{
                {<'.$uri.'> dbo:endDate ?endDate} union {<'.$uri.'> dbp:endDate ?endDate}.
            } limit 10';
        $r = $sparql->query($query);

        foreach($r as $a){
            $edu['numberOfStudents']=0;
            $im = (method_exists($a->numberOfStudents,'getValue')) ? $a->numberOfStudents->getValue() : $a->numberOfStudents;
            $edu['numberOfStudents']=$im;
        }


        return $edu;
    }
}
