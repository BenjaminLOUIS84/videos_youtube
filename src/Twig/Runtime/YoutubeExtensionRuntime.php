<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;
use RicardoFiorani\Matcher\VideoServiceMatcher;

class YoutubeExtensionRuntime implements RuntimeExtensionInterface
{
    private $youtubeParser;

    public function __construct()
    {
        $this->youtubeParser = new VideoServiceMatcher();
    }

    public function youtubeThumbnail($value)
    {
        $video = $this->youtubeParser->parse($value);
        return $video->getLargestThumbnail();
    }
}
