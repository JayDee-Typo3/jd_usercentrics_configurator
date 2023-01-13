<?php


namespace JD\JdUsercentricsConfigurator\Services;


use DOMDocument;
use DOMElement;

/**
 * Class HTMLParseService
 *
 * @package JD\JdUsercentricsConfigurator\Services
 * @author Johannes Delesky, Developer
 */
class HTMLParseService
{
    /**
     * @var string $youtubeRegExp
     */
    private static $youtubeRegExp = "/(https?\:\/\/)?(www\.youtube\.com|youtu\.be)/";

    /**
     * @var string $vimeoRegExp
     */
    private static $vimeoRegExp = "/(?:http|https)?:?\/?\/?(?:www\.)?(?:player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|video\/|)(\d+)(?:|\/\?)/";

    /**
     * Checks the html string and prepare the iframe for usercentrics.
     *
     * @param string $html
     *
     * @return string
     */
    public static function checkHtmlElementContent(string $html): string
    {
        if (preg_match(self::$youtubeRegExp, $html))
            return self::parseIframeForUsercentrics($html, 'YouTube Video');

        if (preg_match(self::$vimeoRegExp, $html))
            return self::parseIframeForUsercentrics($html, 'Vimeo');

        return $html;
    }

    /**
     * Change the iframe html string to get a usercentrics conform iframe integration.
     *
     * @param string $html
     * @param string $ucService
     *
     * @return string
     */
    private static function parseIframeForUsercentrics(string $html, string $ucService): string
    {
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        /** @var DOMElement $iframe */
        if ($iframe = $dom->getElementsByTagName('iframe')->item(0)) {
            $replaceStr = '';

            if ($src = $iframe->getAttribute('src')) {
                $replaceStr = 'uc-src="' . $src . '" ';
                $dataUc = $iframe->getAttribute('data-usercentrics');
                if (empty($dataUc))
                    $replaceStr .= 'data-usercentrics="' . $ucService . '"';
            }
            if (empty($replaceStr))
                return $html;

            return str_replace(
                'src="' . $src . '"',
                $replaceStr,
                $html
            );
        }

        return $html;
    }
}