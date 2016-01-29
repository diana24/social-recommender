<?php

namespace App\Http\EasyRdf\Parser;
/**
 * EasyRdf
 *
 * LICENSE
 *
 * Copyright (c) 2009-2013 Nicholas J Humfrey.  All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 3. The name of the author 'Nicholas J Humfrey" may be used to endorse or
 *    promote products derived from this software without specific prior
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    EasyRdf
 * @copyright  Copyright (c) 2009-2013 Nicholas J Humfrey
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * Class to parse RDF using the 'rapper' command line tool.
 *
 * @package    EasyRdf
 * @copyright  Copyright (c) 2009-2013 Nicholas J Humfrey
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */

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
use App\Http\EasyRdf\Http\EasyRdf_Http_Exception;
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
use App\Http\EasyRdf\Parser\EasyRdf_Parser_RdfPhp;
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


class EasyRdf_Parser_Rapper extends EasyRdf_Parser_Json
{
    private $rapperCmd = null;

    const MINIMUM_RAPPER_VERSION = '1.4.17';

    /**
     * Constructor
     *
     * @param string $rapperCmd Optional path to the rapper command to use.
     * @return object EasyRdf_Parser_Rapper
     */
    public function __construct($rapperCmd = 'rapper')
    {
        $result = exec("$rapperCmd --version 2>/dev/null", $output, $status);
        if ($status != 0) {
            throw new EasyRdf_Exception(
                "Failed to execute the command '$rapperCmd': $result"
            );
        } elseif (version_compare($result, self::MINIMUM_RAPPER_VERSION) < 0) {
            throw new EasyRdf_Exception(
                "Version ".self::MINIMUM_RAPPER_VERSION." or higher of rapper is required."
            );
        } else {
            $this->rapperCmd = $rapperCmd;
        }
    }

    /**
      * Parse an RDF document into an EasyRdf_Graph
      *
      * @param object EasyRdf_Graph $graph   the graph to load the data into
      * @param string               $data    the RDF document data
      * @param string               $format  the format of the input data
      * @param string               $baseUri the base URI of the data being parsed
      * @return integer             The number of triples added to the graph
      */
    public function parse($graph, $data, $format, $baseUri)
    {
        parent::checkParseParams($graph, $data, $format, $baseUri);

        $json = EasyRdf_Utils::execCommandPipe(
            $this->rapperCmd,
            array(
                '--quiet',
                '--input', $format,
                '--output', 'json',
                '--ignore-errors',
                '--input-uri', $baseUri,
                '--output-uri', '-', '-'
            ),
            $data
        );

        // Parse in the JSON
        return parent::parse($graph, $json, 'json', $baseUri);
    }
}
