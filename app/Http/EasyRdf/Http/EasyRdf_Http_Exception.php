<?php



namespace App\Http\EasyRdf\Http;
use App\Http\EasyRdf\EasyRdf_Namespace;
use App\Http\EasyRdf\EasyRdf_Http;
use App\Http\EasyRdf\EasyRdf_Collection;
use App\Http\EasyRdf\EasyRdf_Container;
use App\Http\EasyRdf\EasyRdf_Exception;
use App\Http\EasyRdf\EasyRdf_Format;
use App\Http\EasyRdf\EasyRdf_Graph;
use App\Http\EasyRdf\EasyRdf_GraphStore;
use App\Http\EasyRdf\EasyRdf_Isomorphic;
use App\Http\EasyRdf\EasyRdf_Literal;
use App\Http\EasyRdf\EasyRdf_ParsedUri;
use App\Http\EasyRdf\EasyRdf_Parser;
use App\Http\EasyRdf\EasyRdf_Resource;
use App\Http\EasyRdf\EasyRdf_Serialiser;
use App\Http\EasyRdf\EasyRdf_TypeMapper;
use App\Http\EasyRdf\EasyRdf_Utils;

use App\Http\EasyRdf\Http\EasyRdf_Http_Client;
use App\Http\EasyRdf\Http\EasyRdf_Http_Response;

use App\Http\EasyRdf\Literal\EasyRdf_Literal_Boolean;
use App\Http\EasyRdf\Literal\EasyRdf_Literal_Date;
use App\Http\EasyRdf\Literal\EasyRdf_Literal_DateTime;
use App\Http\EasyRdf\Literal\EasyRdf_Literal_Decimal;
use App\Http\EasyRdf\Literal\EasyRdf_Literal_HexBinary;
use App\Http\EasyRdf\Literal\EasyRdf_Literal_Integer;
use App\Http\EasyRdf\Literal\EasyRdf_Literal_XML;

use App\Http\EasyRdf\Parser\EasyRdf_Parser_Arc;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_Exception;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_Json;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_JsonLd;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_Ntriples;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_Rapper;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_Rdfa;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_RdfXml;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_Redland;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_Turtle;

use App\Http\EasyRdf\Serialiser\EasyRdf_Serialiser_Arc;
use App\Http\EasyRdf\Serialiser\EasyRdf_Serialiser_GraphViz;
use App\Http\EasyRdf\Serialiser\EasyRdf_Serialiser_Json;
use App\Http\EasyRdf\Serialiser\EasyRdf_Serialiser_JsonLd;
use App\Http\EasyRdf\Serialiser\EasyRdf_Serialiser_Ntriples;
use App\Http\EasyRdf\Serialiser\EasyRdf_Serialiser_Rapper;
use App\Http\EasyRdf\Serialiser\EasyRdf_Serialiser_RdfXml;
use App\Http\EasyRdf\Serialiser\EasyRdf_Serialiser_Turtle;

use App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Client;
use App\Http\EasyRdf\Sparql\EasyRdf_Sparql_Result;
use App\Http\EasyRdf\Parser\EasyRdf_Parser_RdfPhp;
class EasyRdf_Http_Exception extends EasyRdf_Exception
{
    private $body;

    public function __construct($message = "", $code = 0, \Exception $previous = null, $body = '')
    {
        parent::__construct($message, $code, $previous);
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}
