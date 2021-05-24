<?php

namespace BeeBots\ScheduledCacheFlush\Utilities;

/**
 * Class ConvertMultilineTextToArray
 *
 * @package BeeBots\ScheduledCacheFlush\Utilities
 */
class ConvertMultilineTextToArray
{
    /**
     * Function: execute
     *
     * @param string|null $stringToConvert
     *
     * @return array
     */
    public function execute(?string $stringToConvert): array
    {
        $stringToConvert = trim($stringToConvert);
        if (strlen($stringToConvert) === 0) {
            return [];
        }

        // Split on new lines (Mac, Windows, or Linux)
        $array = preg_split("/\r\n|\n|\r/", $stringToConvert);
        // Remove and white space
        $array = array_map('trim', $array);
        // Remove empty array elements
        $array = array_filter($array);
        return array_values($array);
    }
}
