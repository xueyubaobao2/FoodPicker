<?php
/**
 * Yelp API v2.0 code sample.
 *
 * This program demonstrates the capability of the Yelp API version 2.0
 * by using the Search API to query for businesses by a search term and location,
 * and the Business API to query additional information about the top result
 * from the search query.
 * 
 * Please refer to http://www.yelp.com/developers/documentation for the API documentation.
 * 
 * This program requires a PHP OAuth2 library, which is included in this branch and can be
 * found here:
 *      http://oauth.googlecode.com/svn/code/php/
 * 
 * Sample usage of the program:
 * `php sample.php --term="bars" --location="San Francisco, CA"`
 */
// Enter the path that the oauth library is in relation to the php file

require_once('lib/OAuth.php');
// Set your OAuth credentials here  
// These credentials can be obtained from the 'Manage API Access' page in the
// developers documentation (http://www.yelp.com/developers)
$CONSUMER_KEY = "WBN1aUkuRcqDoQGqHyOuAg";
$CONSUMER_SECRET = "jWq2RY8ZslALsC_Lkj9TX-EtR6k";
$TOKEN = "bV68O-6ekTvEGGyLVUUb7NBIUwm46gCa";
$TOKEN_SECRET = "yoZSIlSToGuhqKUmA_VFgGGf_MQ";
$API_HOST = 'api.yelp.com';
$DEFAULT_TERM = 'dinner';
$DEFAULT_LOCATION = 'city avenue, Philadelphia, PA';
$SEARCH_LIMIT = '';
$SEARCH_PATH = '/v2/search/';
$BUSINESS_PATH = '/v2/business/';
$offset = 0;
/** 
 * Makes a request to the Yelp API and returns the response
 * 
 * @param    $host    The domain host of the API 
 * @param    $path    The path of the APi after the domain
 * @return   The JSON response from the request      
 */
function request($host, $path) {
    $unsigned_url = "https://" . $host . $path;
	echo $unsigned_url;
    // Token object built using the OAuth library
    $token = new OAuthToken($GLOBALS['TOKEN'], $GLOBALS['TOKEN_SECRET']);
    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer($GLOBALS['CONSUMER_KEY'], $GLOBALS['CONSUMER_SECRET']);
    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();
    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer, 
        $token, 
        'GET', 
        $unsigned_url
    );
    
    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);
    
    // Get the signed URL
    $signed_url = $oauthrequest->to_url();
    
    // Send Yelp API Call
    try {
        $ch = curl_init($signed_url);
        if (FALSE === $ch)
            throw new Exception('Failed to initialize');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        if (FALSE === $data)
            throw new Exception(curl_error($ch), curl_errno($ch));
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($data, $http_status);
        curl_close($ch);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }
    
    return $data;
}
/**
 * Query the Search API by a search term and location 
 * 
 * @param    $term        The search term passed to the API 
 * @param    $location    The search location passed to the API 
 * @return   The JSON response from the request 
 */
function search($term, $location,$offset) {
    $url_params = array();
    
    $url_params['term'] = $term ?: $GLOBALS['DEFAULT_TERM'];
    $url_params['location'] = $location?: $GLOBALS['DEFAULT_LOCATION'];
	$url_params['offset'] =$offset;
    
    $search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
	
    
    return request($GLOBALS['API_HOST'], $search_path);
}
/**
 * Query the Business API by business_id
 * 
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request 
 */
function get_business($business_id) {
    $business_path = $GLOBALS['BUSINESS_PATH'] . urlencode($business_id);
    
    return request($GLOBALS['API_HOST'], $business_path);
}
/**
 * Queries the API by the input values from the user 
 * 
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
function query_api($term, $location,$offset) {     
	require 'database/connect.php';
	ini_set('max_execution_time', 300);
    $response = json_decode(search($term, $location,$offset));
    /*$business_id = $response->businesses[0]->id;
    
    print sprintf(
        "%d businesses found, querying business info for the top result \"%s\"\n\n",         
        count($response->businesses),
        $business_id
    );
    
    $response = get_business($business_id);
    
    print sprintf("Result for business \"%s\" found:\n", $business_id);
    print "$response\n";*/
	$businesses=$response->businesses;
	
	/*echo "<pre>";
	print_r($businesses);
	echo "</pre>";*/
	
	foreach($businesses as $items)
    {
		echo "name: ".$name = $items->name;
		echo "<br/>";
		$categories =$items->categories;
		echo "categories: ";
		$cate="";
		foreach($categories as $category){
			$cate=$cate.$category[0]." ";
		}
		echo $cate;
		echo "<br/>";
		echo "phone: ".$phone=$items->phone;
		echo "<br/>";
		echo "snippet text: ".$snippet_text=$items->snippet_text;
		echo "<br/>";
		echo "profile image url: ".$profile_image_url = str_replace("ms.jpg","o.jpg",$items->snippet_image_url);
		echo "<br/>";
		echo "post image url: ".$post_image_url=str_replace("ms.jpg","o.jpg",$items->image_url);
		echo "<br/>";
		$address = $items->location->display_address;
		$finaladd = "";
		echo "address: ";
		foreach($address as $addr){
			$finaladd =$finaladd.$addr." ";
		}
		echo $finaladd;
		echo "<br/>";
		echo "litidute: ".$litidute=$items->location->coordinate->latitude;
		echo "<br/>";
		echo "longitude: ".$longitude=$items->location->coordinate->longitude;
		echo "<br/>";
		echo "rating image: ".$rating = $items->rating_img_url_large;
		echo "<hr/>";
		$snippet_text= str_replace("'"," ",$snippet_text);
		$result = mysqli_query($conn,"insert into yelpdata values(\"$name\",'$cate','$phone','$snippet_text','$profile_image_url','$post_image_url','$finaladd','$litidute','$longitude','$rating')");
		if (!$result)
          echo "Error: ". $conn->error;
	}
	
}
/**
 * User input is handled here 
 */
$longopts  = array(
    "term::",
    "location::",
);
    
$options = getopt("", $longopts);
$term = $options['term'] ?: '';
$location = $options['location'] ?: '';
for($i=0;$i<50;$i++){
	
	query_api($term, $location,$offset);
	$offset = $offset+20;
}
?>