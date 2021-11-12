<?php

class Data
{
    /**
     * @param $year
     * @return false|string
     */
    function getMoviesByYear($year)
    {
        $response = file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&fields=thumbnails,title&byTags=genre:action&byYear=2017&byProgramType=movie');
        $response = json_decode($response,true)['entries'];
        return $response;
    }
}