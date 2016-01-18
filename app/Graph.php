<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    public $filepath;

    public function __construct($path_to_file){
        $this->filepath = $path_to_file;
    }

    public function parse(){

    }

    public function upload($uid){
        $data = array("-X" => "Content-Type:rdf/xml",
            "-T" => $this->filepath,
            "-G" => "http://localhost:3030/ds/data",
            "--data-urlencode" => "graph=http://social-recommender.ro/graphs/".$uid);
        $ch = curl_init('http://localhost:3030/ds/data');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

        $response = curl_exec($ch);

        dd($response);

        if (!$response)
        {
            return false;
        }
    }
}
