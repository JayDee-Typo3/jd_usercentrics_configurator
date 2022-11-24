<?php
namespace JD\JdUsercentricsConfigurator\Services;

class DeAndEncodeService
{

    /**
     * Decode the given json into an array.
     *
     * @param string $jsonString
     *
     * @return array
     */
    public static function decodeJsonString(string $jsonString): array
    {
        return json_decode($jsonString, TRUE);
    }
}