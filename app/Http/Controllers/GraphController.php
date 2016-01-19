<?php

namespace App\Http\Controllers;

use App\Graph;
use Geocoder\Model\Address;
use Geocoder\Model\AddressCollection;
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
use Ivory\HttpAdapter\CurlHttpAdapter;
use Geocoder\Provider\GoogleMaps;
use Google_Service_Calendar;

class GraphController extends Controller
{
    function makeGraph()
    {
        $filepath = "graphs/".Auth::user()->id.'.xml';
        try{
            $fh = fopen($filepath,'w');
        }catch(\Exception $e){
            return null;
        }

        $client = (new GoogleAuthController())->getGoogleClientS();

        $this->addHeader($fh);

        $this->addPeople($fh, $client);

        $this->addEvents($fh,$client);
        $this->addBooks($fh,$client);

        fwrite($fh, "</rdf:RDF>\n");

        fclose($fh);

//        $g = new Graph($filepath);
//        $g->upload(Auth::user()->id);
    }

    function writeCurrentLocations($fh, $loc, $tabs){
        if(count($loc->all()) > 0){
            foreach($loc->all() as $address){
                if(count($address->getCoordinates()) > 0
                    && count($address->getLatitude()) > 0
                    && count($address->getLongitude()) > 0){
                    fwrite($fh, $tabs."<foaf:based_near geo:lat=\""
                        . $address->getLatitude() . "\" geo:long=\""
                        . $address->getLongitude() ."\"/>\n");
                }
            }
        }
    }

    function uploadGraph($filepath){

    }

    function addEvents($fh, $client){
        $calendarServ = new Google_Service_Calendar($client);
        $calendars = $calendarServ->calendarList->listCalendarList(); //dd($calendars);
        foreach($calendars as $calendar){
            if($calendar->accessRole=='owner'){
                $events = $calendarServ->events->listEvents($calendar->id);
                foreach($events as $event){
                    fwrite($fh, "\t<sch:Event rdf:ID=\"".$event->id."\">\n");
                    fwrite($fh, "\t\t<sch:name>".$event->summary."</sch:name>\n");
                    fwrite($fh, "\t\t<sch:description>"
                        .strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i","",str_replace(array("\r\n", "\r", "\n"), "\t\t\t\t\n",html_entity_decode($event->description))))
                            ."</sch:description>\n");
                    fwrite($fh, "\t\t<sch:startDate>".$event->start['dateTime']."</sch:startDate>\n");
                    fwrite($fh, "\t\t<sch:endDate>".$event->end['dateTime']."</sch:endDate>\n");
                    fwrite($fh, "\t\t<sch:url rdf:resource=\"".$event->htmlLink."\"/>\n");
                    $curl     = new CurlHttpAdapter();
                    $geocoder = new GoogleMaps($curl);

                    try{
                        $loc = $geocoder->geocode($event->location);
                        $this->writeCurrentLocations($fh, $loc, "\t\t");
                    }catch(\Exception $e){
//                            dd($e);
                    }
                    fwrite($fh, "\t\t<sch:organizer>\n");
                    fwrite($fh, "\t\t\t<foaf:Person rdf:ID=\"".$event->organizer['id']."\">\n");
                    fwrite($fh, "\t\t\t\t<foaf:name>".$event->organizer['displayName']."</foaf:name>\n");
                    fwrite($fh, "\t\t\t</foaf:Person>\n");
                    fwrite($fh, "\t\t</sch:organizer>\n");
                    foreach($event->attendees as $attendee){
                        $id = $attendee['id'];
                        if(isset($attendee['self']) && $attendee['self']==true){
                            $id='me';
                        }
                        fwrite($fh, "\t\t<sch:attendee>\n");
                        fwrite($fh, "\t\t\t<foaf:Person rdf:ID=\"".$id."\">\n");
                        fwrite($fh, "\t\t\t\t<foaf:name>".$attendee['displayName']."</foaf:name>\n");
                        fwrite($fh, "\t\t\t</foaf:Person>\n");
                        fwrite($fh, "\t\t</sch:attendee>\n");

                    }
                    fwrite($fh, "\t</sch:Event>\n");
                }
            }

        }
    }

    function addBooks($fh, $client){
        $booksServ = new Google_Service_Books($client);
        $shelves = $booksServ->mylibrary_bookshelves->listMylibraryBookshelves(); //dd($shelves);
        foreach($shelves as $shelf){
            if($shelf['volumeCount']>0 && in_array($shelf['title'], ['Reading now', 'Have read' ])){
                $books = $booksServ->mylibrary_bookshelves_volumes->listMylibraryBookshelvesVolumes($shelf['id']);
                foreach($books as $book) {
                    fwrite($fh, "\t<sch:Book rdf:ID=\"" . $book['íd'] . "\">\n");
                    $info = $book['volumeInfo'];
                    fwrite($fh, "\t\t<sch:name>" . $info['title'] . "</sch:name>\n");
                    foreach ($info['authors'] as $author) {
                        fwrite($fh, "\t\t<sch:author>\n");
                        fwrite($fh, "\t\t\t<foaf:Person>\n");
                        fwrite($fh, "\t\t\t\t<foaf:name>" . $author . "</foaf:name>\n");
                        fwrite($fh, "\t\t\t</foaf:Person>\n");
                        fwrite($fh, "\t\t</sch:author>\n");
                    }
                    if (isset($info['publisher'])) {
                        fwrite($fh, "\t\t<sch:publisher>\n");
                        fwrite($fh, "\t\t\t<foaf:Organization>\n");
                        fwrite($fh, "\t\t\t\t<foaf:name>" . $info['publisher'] . "</foaf:name>\n");
                        fwrite($fh, "\t\t\t</foaf:Organization>\n");
                        fwrite($fh, "\t\t</sch:publisher>\n");
                    }
                    if (isset($info['description'])) {
                        fwrite($fh, "\t\t<sch:description>" .
                            strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i", "", str_replace(array("\r\n", "\r", "\n"), "\t\t\t\t\n", html_entity_decode($info['description']))))
                            . "</sch:description>\n");
                    }
                    foreach ($info['industryIdentifiers'] as $idf) {
                        fwrite($fh, "\t\t<sch:isbn>" . $idf['identifier'] . "</sch:isbn>\n");
                    }
                    fwrite($fh, "\t\t<sch:numberOfPages>" . $info['pageCount'] . "</sch:numberOfPages>\n");
                    fwrite($fh, "\t\t<sch:url rdf:resource=\"" . $info['canonicalVolumeLink'] . "\"/>\n");
                    if (isset($info['imageLinks']) && isset($info['imageLinks']['thumbnail'])) {
                        fwrite($fh, "\t\t<foaf:depiction rdf:resource=\"" . $info['imageLinks']['thumbnail'] . "\"/>\n");
                    }
                    fwrite($fh, "\t\t<sch:aggregateRating>\n");
                    fwrite($fh, "\t\t\t<sch:AggregateRating>\n");
                    fwrite($fh, "\t\t\t\t<sch:ratingCount>".$info['ratingsCount']."</sch:ratingCount>\n");
                    fwrite($fh, "\t\t\t\t<sch:ratingValue>".$info['averageRating']."</sch:ratingValue>\n");
                    fwrite($fh, "\t\t\t</sch:AggregateRating>\n");
                    fwrite($fh, "\t\t</sch:aggregateRating>\n");
                    if(isset($info['categories'])){
                        foreach($info['categories'] as $categ){
                            fwrite($fh, "\t\t<sch:about>".$categ."</sch:about>\n");
                        }
                    }
                    fwrite($fh, "\t</sch:Book>\n");
                }
            }
        }
    }

    function addPeople($fh, $client){
        $plus = new Google_Service_Plus($client);

        $me = $plus->people->get('me');
        $list = $plus->people->listPeople('me', 'visible');
        $nextPageToken = (isset($list->nextPageToken)) ? $list->nextPageToken : null;

        $people = $list->getItems();
        $stop = false;

        fwrite($fh, "\t<foaf:Person rdf:ID=\"me\">\n");

        $this->addMyData($fh, $me);

        do {
            foreach ($people as $person) {
                $gperson = new Google_Service_Plus_Person();
                $gperson = $person;
                $gperson = $plus->people->get($gperson->id)->toSimpleObject();

                if(true /*$gperson->objectType == 'person'*/){
                    $this->addPersonData($fh,$gperson);
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

        fwrite($fh, "\t</foaf:Person>\n");
    }

    function addHeader($fh){
        fwrite($fh, "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n");


        fwrite($fh, "<rdf:RDF\n");
        fwrite($fh, "\txmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n");
        fwrite($fh, "\txmlns:foaf=\"http://xmlns.com/foaf/0.1/\"\n");
        fwrite($fh, "\txmlns:rel=\"http://www.perceive.net/schemas/relationship/\"\n");
        fwrite($fh, "\txmlns:rdfs=\"http://www.w3.org/2000/01/rdf-schema#\"\n");
        fwrite($fh, "\txmlns:owl=\"http://www.w3.org/2002/07/owl#\"\n");
        fwrite($fh, "\txmlns:geo=\"http://www.w3.org/2003/01/geo/wgs84_pos#\"\n");
        fwrite($fh, "\txmlns:dbo=\"http://dbpedia.org/ontology/\"\n");
        fwrite($fh, "\txmlns:dbp=\"http://dbpedia.org/property/\"\n");
        fwrite($fh, "\txmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n");
        fwrite($fh, "\txmlns:sch=\"http://schema.org\"\n");
        fwrite($fh, ">\n");

        fwrite($fh, "\t<foaf:PersonalProfileDocument rdf:about=\"\">\n");
        fwrite($fh, "\t\t<foaf:maker rdf:resource=\"#me\"/>\n");
        fwrite($fh, "\t\t<foaf:primaryTopic rdf:resource=\"#me\"/>\n");
        fwrite($fh, "\t</foaf:PersonalProfileDocument>\n\n");

    }

    function addMyData($fh, $me){
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

        if(isset($me->placesLived)){
            foreach($me->placesLived as $place){
                $curl     = new CurlHttpAdapter();
                $geocoder = new GoogleMaps($curl);

                try{
                    $loc = $geocoder->geocode($place['value']);
                    if(isset($place['primary']) && $place['primary']==true){
                        $this->writeCurrentLocations($fh, $loc, "\t\t");
                    }
                }catch(\Exception $e){
//                            dd($e);
                }
            }
//                    $geocoder->reverse(...);
        }

        if(isset($me->aboutMe)){
            //description
            fwrite($fh, "\t\t<sch:description>" .
                str_replace("\n","\t\t\n",strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i","",html_entity_decode($me->aboutMe))))
                . "</sch:description>\n");
        }
    }

    function addPersonData($fh,$gperson){
        fwrite($fh, "\t\t<foaf:knows>\n");
//                    fwrite($fh, "\t\t\t<foaf:Person rdf:about=\"#" . $gperson->id . "\">\n");
        fwrite($fh, "\t\t\t<foaf:Person rdf:ID=\"" . $gperson->id . "\">\n");

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

        if(isset($gperson->placesLived)){
            foreach($gperson->placesLived as $place){
                $curl     = new CurlHttpAdapter();
                $geocoder = new GoogleMaps($curl);

                try{
                    $loc = $geocoder->geocode($place['value']);
                    if(isset($place['primary']) && $place['primary']==true){
                        $this->writeCurrentLocations($fh, $loc, "\t\t\t\t");
                    }
                }catch(\Exception $e){
//                            dd($e);
                }
            }
//                    $geocoder->reverse(...);
        }

        if(isset($gperson->aboutMe)){
            //description
            fwrite($fh, "\t\t\t\t<sch:description>" .
                strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i","",str_replace(array("\r\n", "\r", "\n"), "\t\t\t\t\n",html_entity_decode($gperson->aboutMe))))
                . "</sch:description>\n");
        }

        fwrite($fh, "\t\t\t</foaf:Person>\n");
        fwrite($fh, "\t\t</foaf:knows>\n");
    }
}
