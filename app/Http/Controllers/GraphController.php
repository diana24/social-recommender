<?php

namespace App\Http\Controllers;

use App\Graph;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Google_Service_Plus;
use Google_Service_Plus_Person;
use Google_Service_YouTube;
use Google_Service_YouTube_Channel;
use Google_Service_Coordinate_Location;
use Google_Service_Books;
use Illuminate\Support\Facades\Auth;
use Google_Service_MapsEngine;

class GraphController extends Controller
{
    function makeGraph()
    {
        $client = (new GoogleAuthController())->getGoogleClientS();
        $booksServ = new Google_Service_Books($client);
        $books = $booksServ->volumes_mybooks->listVolumesMybooks();
//        dd($books);

        $locationsServ = new Google_Service_Coordinate_Location($client);
        $locations = $locationsServ;
//        dd($locations);

        $mapsServ = new Google_Service_MapsEngine($client);
        $maps = $mapsServ->maps;
//        dd($maps->listMaps());

        $plus = new Google_Service_Plus($client);
        $me = $plus->people->get('me');
//        dd($me->toSimpleObject());
        $list = $plus->people->listPeople('me', 'visible');
        $nextPageToken = (isset($list->nextPageToken)) ? $list->nextPageToken : null;

        $people = $list->getItems();
        $stop = false;
//        dd($people);

        $filepath = "graphs/".Auth::user()->id.'.xml';
        try{
            $fh = fopen($filepath,'w');
        }catch(\Exception $e){
            return null;
        }


        fwrite($fh, "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n");


        fwrite($fh, "<rdf:RDF\n");
        fwrite($fh, "\txmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n");
        fwrite($fh, "\txmlns:foaf=\"http://xmlns.com/foaf/0.1/\"\n");
        fwrite($fh, "\txmlns:rel=\"http://www.perceive.net/schemas/relationship/\"\n");
        fwrite($fh, "\txmlns:rdfs=\"http://www.w3.org/2000/01/rdf-schema#\"\n");
        fwrite($fh, "\txmlns:owl=\"http://www.w3.org/2002/07/owl#\"\n");
        fwrite($fh, "\txmlns:dbo=\"http://dbpedia.org/ontology/\"\n");
        fwrite($fh, "\txmlns:dbp=\"http://dbpedia.org/property/\"\n");
        fwrite($fh, "\txmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n");
        fwrite($fh, "\txmlns:sch=\"http://schema.org\"\n");
        fwrite($fh, "\txmlns:sp=\"http://schema.org/Person\"\n");
        fwrite($fh, ">\n");

        fwrite($fh, "\t<foaf:PersonalProfileDocument rdf:about=\"\">\n");
        fwrite($fh, "\t\t<foaf:maker rdf:resource=\"#me\"/>\n");
        fwrite($fh, "\t\t<foaf:primaryTopic rdf:resource=\"#me\"/>\n");
        fwrite($fh, "\t</foaf:PersonalProfileDocument>\n\n");

        fwrite($fh, "\t<foaf:Person rdf:ID=\"me\">\n");

        if(isset($me->displayName)){
            // foaf:name
            fwrite($fh, "\t\t<foaf:name>" . $me->displayName. "</foaf:name>\n");
        }
        if(method_exists($me, 'getName') && isset($me->getName()['givenName'])){
            // foaf:givenname
            fwrite($fh, "\t\t<foaf:givenname>" . $me->getName()['givenName'] ."</foaf:givenname>\n");
        }
        if(method_exists($me, 'getName') && isset($me->getName()['familyName'])){
            // foaf:family_name
            fwrite($fh, "\t\t<foaf:family_name>" . $me->getName()['familyName'] . "</foaf:family_name>\n");
        }
        //photo
        fwrite($fh, "\t\t<foaf:depiction rdf:resource=\"" . $me->image['url'] . "\"/>\n");

        //homepage
        fwrite($fh, "\t\t<foaf:homepage rdf:resource=\"" . $me->url . "\"/>\n");
        //sites
        if(isset($me->urls) && count($me->urls)>0){
            foreach($me->urls as $url){
                if($url['type']=='website' || $url['type']=='contributor'){
                    fwrite($fh, "\t\t\t\t<dbp:website dc:name=\"".$url['label']
                        ."\" rdf:resource=\"".$url['value']."\"/>\n");
                }
                else{
                    fwrite($fh, "\t\t\t\t<foaf:page dc:name=\"".$url['label']
                        ."\" rdf:resource=\"".$url['value']."\"/>\n");
                }
            }
        }
        if(isset($me->gender)){
            //gender
            fwrite($fh, "\t\t<foaf:gender>" . $me->gender . "</foaf:gender>\n");
        }
        if(isset($me->occupation)){
            //occupation
            fwrite($fh, "\t\t<dbo:occupation>" . $me->occupation . "</dbo:occupation>\n");
        }

        if(isset($me->organizations) && count($me->organizations)>0){
            foreach($me->organizations as $org){
             if($org['type']=='school'){
                 fwrite($fh, "\t\t<dbo:school>\n");
                 fwrite($fh, "\t\t\t<dbo:EducationalInstitution>\n");
                 fwrite($fh, "\t\t\t\t<dbp:name>");
                 fwrite($fh, $org['name']);
                 fwrite($fh, "</dbp:name>\n");
                 fwrite($fh, "\t\t\t</dbo:EducationalInstitution>\n");
                 fwrite($fh, "\t\t</dbo:school>\n");
             }
            }
            }

        if(isset($me->aboutMe)){
            //description
            fwrite($fh, "\t\t<sp:description>" .
                str_replace("\n","\t\t\n",strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i","",html_entity_decode($me->aboutMe))))
                . "</sp:description>\n");
        }

        do {
            foreach ($people as $person) { // identified by url https://plus.google.com/userId
                $gperson = new Google_Service_Plus_Person();
                $gperson = $person;
                $gperson = $plus->people->get($gperson->id)->toSimpleObject();
//                dd($gperson);

//                if($gperson->displayName == 'HALIDONMUSIC'){
//                    dd($gperson);
//                }

                if(true /*$gperson->objectType == 'person'*/){
                    fwrite($fh, "\t\t<foaf:knows>\n");
                    fwrite($fh, "\t\t\t<foaf:Person rdf:about=\"#" . $gperson->id . "\">\n");

                    if(isset($gperson->displayName)){
                        // foaf:name
                        fwrite($fh, "\t\t\t\t<foaf:name>" . $gperson->displayName. "</foaf:name>\n");
                    }
                    if(method_exists($gperson, 'getName') && isset($gperson->getName()['givenName'])){
                        // foaf:givenname
                        fwrite($fh, "\t\t\t\t<foaf:givenname>" . $gperson->getName()['givenName'] ."</foaf:givenname>\n");
                    }
                    if(method_exists($gperson, 'getName') && isset($gperson->getName()['familyName'])){
                        // foaf:family_name
                        fwrite($fh, "\t\t\t\t<foaf:family_name>" . $gperson->getName()['familyName'] . "</foaf:family_name>\n");
                    }
                    //photo
                    fwrite($fh, "\t\t\t\t<foaf:depiction rdf:resource=\"" . $gperson->image['url'] . "\"/>\n");
                    //homepage
                    fwrite($fh, "\t\t\t\t<foaf:homepage rdf:resource=\"" . $gperson->url . "\"/>\n");
                    //sites
                    if(isset($gperson->urls) && count($gperson->urls)>0){
                        foreach($gperson->urls as $url){
                            if($url['type']=='website' || $url['type']=='contributor'){
                                fwrite($fh, "\t\t\t\t<dbp:website dc:name=\"".$url['label']
                                    ."\" rdf:resource=\"".$url['value']."\"/>\n");
                            }
                            else{
                                fwrite($fh, "\t\t\t\t<foaf:page dc:name=\"".$url['label']
                                    ."\" rdf:resource=\"".$url['value']."\"/>\n");
                            }
                        }
                    }
                    if(isset($gperson->gender)){
                        //gender
                        fwrite($fh, "\t\t\t\t<foaf:gender>" . $gperson->gender . "</foaf:gender>\n");
                    }
                    if(isset($gperson->occupation)){
                        //occupation
                        fwrite($fh, "\t\t\t\t<dbo:occupation>" . $gperson->occupation . "</dbo:occupation>\n");
                    }

                    if(isset($gperson->organizations) && count($gperson->organizations)>0){
                        foreach($gperson->organizations as $org){
                            if($org['type']=='school'){
                                fwrite($fh, "\t\t\t\t<dbo:school>\n");
                                fwrite($fh, "\t\t\t\t\t<dbo:EducationalInstitution>\n");
                                fwrite($fh, "\t\t\t\t\t\t<dbp:name>");
                                fwrite($fh, $org['name']);
                                fwrite($fh, "<dbp:name>\n");
                                fwrite($fh, "\t\t\t\t\t</dbo:EducationalInstitution>\n");
                                fwrite($fh, "\t\t\t\t</dbo:school>\n");
                            }
                        }
                    }

                    if(isset($gperson->aboutMe)){
                        //description
                        fwrite($fh, "\t\t\t\t<sp:description>" .
                            strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i","",str_replace(array("\r\n", "\r", "\n"), "\t\t\t\t\n",html_entity_decode($gperson->aboutMe))))
                            . "</sp:description>\n");
                    }

                    fwrite($fh, "\t\t\t</foaf:Person>\n");
                    fwrite($fh, "\t\t</foaf:knows>\n");
                }

            }

            if (isset($nextPageToken)) {
                $list = $plus->people->listPeople('me', 'visible', $nextPageToken);
                $nextPageToken = (isset($list->nextPageToken)) ? $list->nextPageToken : null;
                $people = $list->getItems();
            } else {
                $stop = true;
            }
        } while ($stop == false);


//        $this->addYoutubeData($client, $fh);

        fwrite($fh, "\t</foaf:Person>\n");
        fwrite($fh, "</rdf:RDF>\n");

        fclose($fh);
//
//        $g = new Graph($filepath);
//        $g->upload(Auth::user()->id);
    }

    function addYoutubeData($client,$fh){
        $youtube = new Google_Service_YouTube($client);
        $channelsResponse = $youtube->channels->listChannels('contentDetails', array(
            'mine' => 'true',
        ));
//        dd($channelsResponse);
        $subscriptions = $youtube->subscriptions->listSubscriptions('snippet', array(
            'mine' => 'true',
        ));

        $subscriptions = $subscriptions->getItems();
        dd($subscriptions);
//        $channel = new Google_Service_YouTube_Channel();
////        $channel->
    }

    function uploadGraph($filepath){

    }
}
