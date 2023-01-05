<?php


namespace JD\JdUsercentricsConfigurator\Services;


use DOMDocument;

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

    private static function parseIframeForUsercentrics(string $html, string $ucService): string
    {
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        /** @var \DOMElement $iframe */
        $iframe = $dom->getElementsByTagName('iframe')->item(0);
        $src = $iframe->getAttribute('src');
        return str_replace(
            'src="' . $src . '"',
            'uc-src="' . $src . '" data-usercentrics="' . $ucService . '"',
            $html
        );
    }
}