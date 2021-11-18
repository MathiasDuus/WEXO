<?php
// ['orig-480x334'] for poster image

//foreach ($mov[1]['plprogram$thumbnails'] as $key=>$entry) {
//    echo $entry."<br>";
//    print_r($entry['plprogram$thumbnails'])."<br><br><br><br>";
//}

class Data
{
    /**
     * Gets a number of movies, optional from each genre
     * @param string $type      series|movies
     * @param int $number       How many movies/series, default: 1
     * @param array $genres     The genre(s) of the series/movies, default: no_genre
     * @return array            A number of movies/series
     */
    function getData(string $type, int $number=1, array $genres = [""]): array
    {
        $url = 'https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType='.$type.'&range=1-'.$number;
            
        $result = [];
        $arr = [];
        
        foreach ($genres as $genre) {
            $response = file_get_contents($url.'&byTags='.$genre);
  
            if (isset($response['responseCode']))
                return array(
                    "status"=>"error",
                    "message"=>"Wrong URL".$response);
            
            $response = json_decode($response,true)['entries'];
            
            $i = 0;
            foreach ($response as $content) {
                $arr[$i]['title'] = $content['title'];
                foreach ($content['plprogram$thumbnails'] as $images) {
                    
                    if ($images['plprogram$assetTypes'][0]=="Poster"){
                        $arr[$i]['poster'] = $images['plprogram$url'];
                        break;
                    }
                }
                $i++;
            }
            if($genre == ""){
                $genre = "no_genre";
            }
            $result[$genre] = $arr;
            
        }
        return $result;
    }
    
    /**
     * Count how many in one genre
     * @param string $type movie|series
     * @param mixed $genres Either a string with name of genre
     *                       or an array with genre names
     * @return mixed How many in one genre,
     *               if an array of genres is provided, return associated array
     */
    function getGenreCount(mixed $genres, string $type):mixed
    {
        if (!is_array($genres)){
            $response = file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType='.$type.'&fields=guid&range=0-10000&byTags=genre:'.$genres);
            return json_decode($response,true)['entryCount'];
        }
        else{
            $count = [];
            foreach ($genres as $genre) {
                $response = file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType='.$type.'&fields=guid&range=0-10000&byTags=genre:'.$genre);
                array_push($count, json_decode($response,true)['entryCount']);
            }
            return $count;
        }
    }
}

