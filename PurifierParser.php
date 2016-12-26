<?php
/**
 * User: Zura
 * Date: 12/2/2015
 * Time: 12:41 PM
 */

namespace centigen\base;
use yii\helpers\HtmlPurifier;
use yii\web\RequestParserInterface;



/**
 * Class PurifierParser
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base
 */
class PurifierParser implements RequestParserInterface
{

    /**
     * Parses a HTTP request body.
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param string $rawBody     the raw HTTP request body.
     * @param string $contentType the content type specified for the request body.
     * @return array parameters parsed from the request body
     */
    public function parse($rawBody, $contentType)
    {
        return HtmlPurifier::process($rawBody);
    }
}