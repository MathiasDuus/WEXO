<?php


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
            if ($this->getGenreCount($genre, $type)<=0)
                continue;
            $curl = curl_init($url.'&byTags='.$genre);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            
            if (isset($output['responseCode']))
                return array(
                    "status"=>"error",
                    "message"=>"Wrong URL".$output);
            
            $response = json_decode($output,true)['entries'];
            
            $i = 0;
            foreach ($response as $content) {
                $arr[$i]['title'] = $content['title'];
                foreach ($content['plprogram$thumbnails'] as $images) {
                    foreach ($images['plprogram$assetTypes'] as $image) {
                        if ($image=="Poster"){
                            $arr[$i]['poster'] = $images['plprogram$url'];
                            break;
                        }
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
                $response = json_decode(file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType='.$type.'&fields=guid&range=0-10000&byTags=genre:'.$genre),true)['entryCount'];
                if($response <= 0)
                    continue;
                array_push($count, $response);
            }
            return $count;
        }
    }
    
    function getAllGenre(string $type, string $genre, string $range){
        
        $url = 'https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=da&byProgramType='.$type
            .'&byTags='.$genre.'&range='.$range;
        
        $result = [];
        $arr = [];
        
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        
        if (isset($output['responseCode']))
            return array(
                "status"=>"error",
                "message"=>"Wrong URL".$output);
        
        $response = json_decode($output,true)['entries'];
        
        $i = 0;
        foreach ($response as $content) {
            $arr[$i]['title'] = $content['title'];
            foreach ($content['plprogram$thumbnails'] as $images) {
                foreach ($images['plprogram$assetTypes'] as $image) {
                    if ($image=="Poster"){
                        $arr[$i]['poster'] = $images['plprogram$url'];
                        break;
                    }
                }
            }
            $i++;
        }
        if($genre == "") {
            $genre = "no_genre";
        }
        $result[$genre] = $arr;
        
        
        return $result;
    }
}

