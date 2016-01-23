<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Graph extends Model
{
    protected $table = 'graphs';
    protected $fillable = ['user_id','filepath'];

    public function __construct($path_to_file=null){
        $this->filepath = $path_to_file;
        $this->user_id = Auth::user()->id;
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

    public function user(){
        return $this->belongsTo('\App\User');
    }
}
