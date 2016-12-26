<?php
/**
 * User: Zura
 * Date: 12/2/2015
 * Time: 2:41 PM
 */

namespace centigen\base;
use centigen\base\helpers\Html;
use Yii;
use yii\web\RequestParserInterface;


/**
 * Class HtmlToTextParser
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base
 */
class HtmlToTextParser implements RequestParserInterface
{

    /**
     * Parses a HTTP request body.
     *
     * @param string $rawBody     the raw HTTP request body.
     * @param string $contentType the content type specified for the request body.
     * @return array parameters parsed from the request body
     */
    public function parse($rawBody, $contentType)
    {
        return Html::htmlToText($rawBody, false);
    }
}