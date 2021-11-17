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
     * @param int $number
     * @param array $genres
     * @return array
     */
    function getMovies(int $number=1, array $genres = []): array
    {
        if (empty($genres))
            $genres = array_push($genres, "");
            
        $result = [];
        $arr = [];
        
        foreach ($genres as $genre) {
            $response = file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType=movie&byTags=genre:'.$genre.'&range=1-'.$number);
//            $response = file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType=movie&fields=guid&range=0-10000&byTags=genre:'.$genre);
    
            if (isset($response['responseCode']))
                return array(
                    "status"=>"error",
                    "message"=>"Wrong URL".$response);
            
            $response = json_decode($response,true)['entries'];
//            return $response;
            $i = 0;
            foreach ($response as $movie) {
                $arr[$i]['title'] = $movie['title'];
                foreach ($movie['plprogram$thumbnails'] as $images) {
                    
                    if ($images['plprogram$assetTypes'][0]=="Poster"){
                        $arr[$i]['poster'] = $images['plprogram$url'];
                        break;
                    }
                }
                $i++;
            }
            
            $result[$genre] = $arr;
            
        }
        return $result;
    }
    
    /**
     * Count how many in one genre
     * @param mixed $genres Either a string with name of genre
     *                       or an array with genre names
     * @return mixed How many in one genre, 
     *               if an array of genres is provided, return associated array
     */
    function getGenreCount(mixed $genres):mixed
    {
        if (!is_array($genres)){
            $response = file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType=movie&fields=guid&range=0-10000&byTags=genre:'.$genres);
            return json_decode($response,true)['entryCount'];
        }
        else{
            $count = [];
            foreach ($genres as $genre) {
                $response = file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType=movie&fields=guid&range=0-10000&byTags=genre:'.$genre);
                $count[$genre]= json_decode($response,true)['entryCount'];
            }
            return $count;
        }
    }
}

