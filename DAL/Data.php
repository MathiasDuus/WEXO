<?php
include "Connect.php";

class Data
{
    /**
     * Gets movies/series within a range, with a given genre
     * @param string $type      series|movies
     * @param int $number       How many movies/series, default: 1
     * @param array $genres     The genre(s) of the series/movies, default: no_genre
     * @return array            A number of movies/series
     */
    function getData(string $type, int $number=1, array $genres = [""]): array
    {
        $url = 'https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=en&byProgramType='.$type.'&range=1-'.$number;
        
        $result = [];
        $arr = [];
        
        foreach ($genres as $genre) {
            if ($this->getGenreCount($genre, $type)<=0)
                continue;
            $curl = curl_init($url.'&byTags='.$genre);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            
            // checks for error
            if (isset($output['responseCode']))
                return array(
                    "status"=>"error",
                    "message"=>"Wrong URL".$output);
    
            // converts the response to an array
            $response = json_decode($output,true)['entries'];
            
            // Get id, title and poster
            $arr =  $this->filterContent($response);
            
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
            $response = file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=en&byProgramType='.$type.'&fields=guid&range=0-10000&byTags=genre:'.$genres);
            return json_decode($response,true)['entryCount'];
        }
        else{
            $count = [];
            foreach ($genres as $genre) {
                $response = json_decode(file_get_contents('https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=en&byProgramType='.$type.'&fields=guid&range=0-10000&byTags=genre:'.$genre),true)['entryCount'];
                if($response <= 0)
                    continue;
                array_push($count, $response);
            }
            return $count;
        }
    }
    
    /**
     * Gets movies/series of a given genre, within a given range.
     * @param string $type
     * @param string $genre
     * @param string $range
     * @return array
     * Array containing title of movie and img link to poster
     */
    function getAllGenre(string $type, string $genre, string $range): array
    {        
        $url = 'https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas?form=json&lang=en&byProgramType='.$type
            .'&byTags='.$genre.'&range='.$range;
        
        $result = [];
        $arr = [];
        
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        
        // Checks for error
        if (isset($output['responseCode']))
            return array(
                "status"=>"error",
                "message"=>"Wrong URL".$output);
        
        // converts the response to an array
        $response = json_decode($output,true)['entries'];
        
        // Get id, title and poster
        $arr =  $this->filterContent($response);
    
    
        if($genre == ""){
            $genre = "no_genre";
        }
        $result[$genre] = $arr;
        
        return $result;
    }
    
    /**
     * Filters the data and returns title, id, poster
     * @param array $response   The response 
     * @return array            title, id and poster
     */
    private function filterContent(array $response):array
    {
        $arr = [];
        $i = 0;
        foreach ($response as $content) {
            $arr[$i]['title'] = $content['title'];
            $arr[$i]['url'] = $content['id'];
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
    
    
    
        return $arr;
    }
    
    /**
     * Gets a program based on its id
     * @param int $id       id of movie
     * @param int $userID   id of user (Optional)
     * @return array        Assoc array with All relevant info about the movie
     */
    function getProgram(int $id, int $userID = -1): array
    {
        $url = 'https://feed.entertainment.tv.theplatform.eu/f/jGxigC/bb-all-pas/'.$id.'?form=json&lang=en';
    
        $result = [];
        
        // Checks if userID was given
        if ($userID != -1) {
            // Check if the program is on the users wishlist
            global $conn;
            $stmt = $conn->prepare("SELECT id FROM wishlist WHERE program=? AND userID = ?");
            $stmt->bind_param("ii", $id, $userID);
            if ($stmt->execute()) {
                $db = $stmt->get_result();
                if (mysqli_num_rows($db) > 0) {
                    $result['wishlist'] = true;
                } else {
                    $result['wishlist'] = false;
                }
            }
        }else{
            $result['wishlist'] = "login";            
        }
    
        $curl = curl_init($url);
    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        
        // Check for error
        if (isset($output['responseCode']))
            return array(
                "status"=>"error",
                "message"=>"Wrong URL".$output);
        
        // Converts the response to an array
        $output = json_decode($output,true);
        
        
        $result['title'] = $output['title'];
        $result['description'] = $output['description'];
        $result['year'] = $output['plprogram$year'];
        
        // Finds the backdrop and poster 
        foreach ($output['plprogram$thumbnails'] as $images) {
            foreach ($images['plprogram$assetTypes'] as $image) {
                if ($image=="Backdrop"){
                    $result['backdrop'] = $images['plprogram$url'];
                }
                if ($image=="Poster"){
                    $result['poster'] = $images['plprogram$url'];
                }
            }
        }
        
        // Finds the genres
        $j = 0;
        foreach ($output['plprogram$tags'] as $tag) {
            if ($tag['plprogram$scheme'] =="genre"){
                $result['genre'][$j] = $tag['plprogram$title'];
            }
            $j++;
        }
        
        // Finds the director(s) and actor(s)
        $i = 0;
        $first = true;
        foreach ($output['plprogram$credits'] as $person) {
            // When the first actor is found reset i to 0
            if ($person['plprogram$creditType'] == "actor" && $first){
                $i = 0;
                $first = false;
            }
            $result[$person['plprogram$creditType']][$i] = $person['plprogram$personName'];
            $i++;
        }
        
        return $result;
    }
    
}

