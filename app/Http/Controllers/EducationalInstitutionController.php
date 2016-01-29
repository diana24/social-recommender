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
        $query='select * where {
                { ?edu rdf:type dbo:EducationalInstitution }.
                ?edu rdfs:label ?label.
                optional{{?edu dbo:wikiPageExternalLink ?wiki} union {?edu dbp:wikiPageExternalLink ?wiki}}.
                optional { {?edu dbo:location ?location} union {?edu dbp:location ?location} }.
                optional { {?edu dbo:country ?country} union {?edu dbp:country ?country} }.
                optional { {?edu dbo:numberOfAcademicStaff ?numberOfAcademicStaff} union {?edu dbp:numberOfAcademicStaff ?numberOfAcademicStaff} }.
                optional { {?edu dbo:principal ?principal} union {?edu dbp:principal ?principal} }.
                optional { {?edu dbo:rector ?rector} union {?edu dbp:rector ?rector} }.
                optional { {?edu dbo:numberOfStudents ?numberOfStudents} union {?edu dbp:numberOfStudents ?numberOfStudents} }.';
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
        if(isset($numberOfAcademicStaffMin) && $numberOfAcademicStaffMin > 0){
            $query .= "\n".'filter (?numberOfAcademicStaff >= '.$numberOfAcademicStaffMin.')';
        }
        if(isset($numberOfAcademicStaffMax) && $numberOfAcademicStaffMax > 0){
            $query .= "\n".'filter (?numberOfAcademicStaff <= '.$numberOfAcademicStaffMax.')';
        }
        if(isset($numberOfStudentsMin) && $numberOfStudentsMin > 0){
            $query .= "\n".'filter (?numberOfStudents >= '.$numberOfStudentsMin.')';
        }
        if(isset($numberOfStudentsMax) && $numberOfStudentsMax > 0){
            $query .= "\n".'filter (?numberOfStudents <= '.$numberOfStudentsMax.')';
        }
        $query .= '} limit 100';

        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        try{
            $result = $sparql->query($query);
        } catch(\Exception $e){
            return json_encode([]);
        }
//
        $edus=[];
        foreach($result as $row){
            $uri = $row->edu->getUri();
            if(!array_has($edus,$uri)){
                $edus[$uri]=[];
            }
            $edu=$edus[$uri];
            if(isset($row->wiki)){
                $edu['link']=(method_exists($row->wiki, 'getUri')) ? $row->wiki->getUri() : (
                (method_exists($row->wiki, 'getValue')) ? $row->wiki->getValue() : $row->wiki
                );
            }
            else{
                $edu['link']=$uri;
            }
            $edu['title']=$row->label->getValue();
//            if(isset($row->type) && method_exists($row->type, 'getUri')){
//                $typeUri = $row->type->getUri();
//                if(!isset($edu['types'])){
//                    $edu['types']=[];
//                }
//                if(!array_has($edu['types'],$typeUri)){
//                    $typeUri = $row->type->getUri();
//                    $query = 'select ?typeName where { <'.$typeUri.'> rdfs:label ?typeName . filter (lang(?typeName)="en")} limit 1';
//                    $r = $sparql->query($query);
//                    foreach($r as $rw){
//                        if(isset($rw->typeName)){
//                            $typeName = $rw->typeName->getValue();
//                            $edu['types'][$typeUri]=$typeName;
//                        }
//                    }
//                }
//
//            }
            if(isset($row->country) && method_exists($row->country, 'getUri')){
                $countryUri = $row->country->getUri();
                if(!isset($edu['countries'])){
                    $edu['countries']=[];
                }
                if(!array_has($edu['countries'],$countryUri)){
                    $countryUri = $row->country->getUri();
                    $query = 'select ?countryName where { <'.$countryUri.'> rdfs:label ?countryName . filter (lang(?countryName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->countryName)){
                            $countryName = $rw->countryName->getValue();
                            $edu['countries'][$countryUri]=$countryName;
                        }
                    }
                }

            }
            if(isset($row->rector) && method_exists($row->rector, 'getUri')){
                $rectorUri = $row->rector->getUri();
                if(!isset($edu['countries'])){
                    $edu['countries']=[];
                }
                if(!array_has($edu['countries'],$rectorUri)){
                    $rectorUri = $row->rector->getUri();
                    $query = 'select ?rectorName where { <'.$rectorUri.'> rdfs:label ?rectorName . filter (lang(?rectorName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->rectorName)){
                            $rectorName = $rw->rectorName->getValue();
                            $edu['countries'][$rectorUri]=$rectorName;
                        }
                    }
                }

            }
            if(isset($row->principal) && method_exists($row->principal, 'getUri')){
                $principalUri = $row->principal->getUri();
                if(!isset($edu['countries'])){
                    $edu['countries']=[];
                }
                if(!array_has($edu['countries'],$principalUri)){
                    $principalUri = $row->principal->getUri();
                    $query = 'select ?principalName where { <'.$principalUri.'> rdfs:label ?principalName . filter (lang(?principalName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->principalName)){
                            $principalName = $rw->principalName->getValue();
                            $edu['countries'][$principalUri]=$principalName;
                        }
                    }
                }

            }
            if(isset($row->location) && method_exists($row->location, 'getUri')){
                $locationUri = $row->location->getUri();
                if(!isset($edu['countries'])){
                    $edu['countries']=[];
                }
                if(!array_has($edu['countries'],$locationUri)){
                    $locationUri = $row->location->getUri();
                    $query = 'select ?locationName where { <'.$locationUri.'> rdfs:label ?locationName . filter (lang(?locationName)="en")} limit 1';
                    $r = $sparql->query($query);
                    foreach($r as $rw){
                        if(isset($rw->locationName)){
                            $locationName = $rw->locationName->getValue();
                            $edu['countries'][$locationUri]=$locationName;
                        }
                    }
                }

            }
            if(isset($row->numberOfAcademicStaff)){
                $edu['numberOfAcademicStaff']= method_exists($row->numberOfAcademicStaff, 'getValue') ? $row->numberOfAcademicStaff->getValue() : $row->numberOfAcademicStaff;
            }
            if(isset($row->numberOfStudents)){
                $edu['numberOfStudents']= method_exists($row->numberOfStudents, 'getValue') ? $row->numberOfStudents->getValue() : $row->numberOfStudents;
            }
            $edus[$uri]=$edu;
        }
//        dd($edus);
        return json_encode($edus);
    }

    public function recommendSchools(){
        (new RdfController())->initRdf();
        $myschools = (new RdfController())->getSchools();
//        dd($myschools);
        #schools=[];
        $i=0;

        shuffle($myschools);

        $n=5;
        while($n>count($myschools)){
            $n--;
        }
        $results=[];
        $sparql = new \App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
        $myschools = array_slice($myschools, 0, $n);
        foreach($myschools as $mb){
            try{
                $query = 'select distinct ?edu, ?label, MIN(?image) as ?img, MIN(?wiki) as ?site where {

                ?edu rdf:type dbo:EducationalInstitution .

                ?edu rdfs:label ?label.
                    optional{{?edu dbo:wikiPageExternalLink ?wiki} union {?edu dbp:wikiPageExternalLink ?wiki}}.
                filter ( lang(?label) = "en") filter regex(str(?label), "'.$mb['name'].'", "i")
                 } limit 5';

                $result = $sparql->query($query);
                array_push($results,$result);


            }catch (\Exception $e){
            }
        }

        $eduResults=[];

        foreach($results as $result){
            foreach($result as $row){
                $uri = $row->edu->getUri();
                $query = 'select distinct ?edu, ?label, MIN(?image) as ?img, MIN(?wiki) as ?site where{
                    ?edu rdf:type dbo:EducationalInstitution.
                    ?edu rdfs:label ?label.

                    optional{{?edu dbo:wikiPageExternalLink ?wiki} union {?edu dbp:wikiPageExternalLink ?wiki}}.

                    {
                    {?edu dbo:country ?x} union {?edu dbo:country ?x}.
                    {<'.$uri.'> dbo:country ?x} union {<'.$uri.'> dbp:country ?x}.
                    }


                    union

                    {
                    {?edu dbo:educationSystem ?x} union {?edu dbo:educationSystem ?x}.
                    {<'.$uri.'> dbo:educationSystem ?x} union {<'.$uri.'> dbp:educationSystem ?x}.
                    }

                    union

                    {
                    <'.$uri.'> dct:subject ?x.
                    ?edu dct:subject ?x.
                    }.
                    filter(lang(?label)="en")                               
                } limit 50';
                try{
                    $x = $sparql->query($query);
                    array_push($eduResults,$x);
                }catch(\Exception $e){

                }
            }
        }

        $results=array_merge($results,$eduResults);
        $edus=[];
        foreach($results as $eduResult){
            foreach($eduResult as $row){
                $uri = $row->edu->getUri();
                if(!array_has($edus,$uri)){
                    $edus[$uri]=[];
                }
                $edu=$edus[$uri];
                $edu['name']=$row->label->getValue();

                if(isset($row->site)){
                    $edu['link']=(method_exists($row->site, 'getUri')) ? $row->site->getUri() : (
                    (method_exists($row->site, 'getValue')) ? $row->site->getValue() : $row->site
                    );
                }
                else{
                    $edu['link']=$uri;
                }
                $edus[$uri]=$edu;
            }
        }

        return json_encode($edus);
    }

}
