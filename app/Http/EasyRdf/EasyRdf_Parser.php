<?php

namespace App\Http\EasyRdf;
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


/**
 * Parent class for the EasyRdf parsers
 *
 * @package    EasyRdf
 * @copyright  Copyright (c) 2009-2013 Nicholas J Humfrey
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
class EasyRdf_Parser
{
    /** Mapping from source to graph bnode identifiers */
    private $bnodeMap = array();

    /** The current graph to insert triples into */
    protected $graph = null;

    /** The format of the document currently being parsed */
    protected $format = null;

    /** The base URI for the document currently being parsed */
    protected $baseUri = null;


    protected $tripleCount = 0;

    /**
     * Create a new, unique bnode identifier from a source identifier.
     * If the source identifier has previously been seen, the
     * same new bnode identifier is returned.
     * @ignore
     */
    protected function remapBnode($name)
    {
        if (!isset($this->bnodeMap[$name])) {
            $this->bnodeMap[$name] = $this->graph->newBNodeId();
        }
        return $this->bnodeMap[$name];
    }

    /**
     * Delete the bnode mapping - to be called at the start of a new parse
     * @ignore
     */
    protected function resetBnodeMap()
    {
        $this->bnodeMap = array();
    }

    /**
     * Check, cleanup parameters and prepare for parsing
     * @ignore
     */
    protected function checkParseParams($graph, $data, $format, $baseUri)
    {
        if ($graph == null or !is_object($graph) or
            !($graph instanceof EasyRdf_Graph)) {
            throw new InvalidArgumentException(
                "\$graph should be an EasyRdf_Graph object and cannot be null"
            );
        } else {
            $this->graph = $graph;
        }

        if ($format == null or $format == '') {
            throw new InvalidArgumentException(
                "\$format cannot be null or empty"
            );
        } elseif (is_object($format) and $format instanceof EasyRdf_Format) {
            $this->format = $format = $format->getName();
        } elseif (!is_string($format)) {
            throw new InvalidArgumentException(
                "\$format should be a string or an EasyRdf_Format object"
            );
        } else {
            $this->format = $format;
        }

        if ($baseUri) {
            if (!is_string($baseUri)) {
                throw new InvalidArgumentException(
                    "\$baseUri should be a string"
                );
            } else {
                $this->baseUri = new EasyRdf_ParsedUri($baseUri);
            }
        } else {
            $this->baseUri = null;
        }

        // Prepare for parsing
        $this->resetBnodeMap();
        $this->tripleCount = 0;
    }

    /**
     * Sub-classes must follow this protocol
     * @ignore
     */
    public function parse($graph, $data, $format, $baseUri)
    {
        throw new EasyRdf_Exception(
            "This method should be overridden by sub-classes."
        );
    }

    /**
     * Add a triple to the current graph, and keep count of the number of triples
     * @ignore
     */
    protected function addTriple($resource, $property, $value)
    {
        $count = $this->graph->add($resource, $property, $value);
        $this->tripleCount += $count;
        return $count;
    }
}
