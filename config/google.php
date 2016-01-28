<?php
/**
 * Created by PhpStorm.
 * User: Diana
 * Date: 17.01.2016
 * Time: 18:39
 */
return [
    "apiKey" => "AIzaSyBKQCKCCDKSdXlisk9p4kMZ5XtdL9hlSWI", // works only for certain IP's
    "clientId" => "87678962547-15qq200s2nt48nv3e9t1quldd5eno07b.apps.googleusercontent.com",
    "clientSecret" => "F853OLdhxuLXkWKlN5-bW2h9",
    "scopes" => [
        'https://www.googleapis.com/auth/plus.me',
        'https://www.googleapis.com/auth/plus.login',
//        'https://gdata.youtube.com',
        'https://www.googleapis.com/auth/plus.circles.read',
        'https://www.googleapis.com/auth/books',
        'https://www.googleapis.com/auth/coordinate.readonly',
        'https://maps.google.com/maps/feeds/',
        'https://www.google.com/calendar/feeds/',
//        'https://www.google.com/m8/feeds/',
    ],
    "redirectUri" => "http://localhost:8080/oauth2callback",
    "appName" => "SoR",
    "refreshToken" => '1/ewyRiRwFzUuNfGz90FsBVD-FumS63-Vo_XZykE3eNLtIgOrJDtdun6zK6XiATCKT',
];