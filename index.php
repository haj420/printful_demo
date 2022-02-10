<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;
$apikey = base64_encode('77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7');
$client = new Client();
$body = '
{
	"recipient": {
		"address1": "11025Westlake Dr",
		"city": "Charlotte",
		"country_code": "US",
		"state_code": "NC",
		"zip": 28273
	},
	"items": [
		{
			"quantity": 2,
			"variant_id": 7679
		}
	]
}
';
try {
$response = $client->post('https://api.printful.com/shipping/rates',
    array(
        'body' => $body,
		'headers' => array(
			'Authorization' => ['Basic '.$apikey],
		    'Content-Type' => 'application/xml',
)
    )
);
} catch (RequestException $e) {
var_dump($e->getResponse()->getBody()->getContent());
}
$body = $response->getBody();
echo $body."<br>";


interface CacheInterface
{
    public function set(string $key, $value, int $duration);
    public function get(string $key);
}



class CacheController
{
    private $cache;

    public function __construct(CacheInterface $cache) {
        $this->cache = $cache;
    }
}

class Cache implements CacheInterface
{
    private $duration;

    public function set(string $key, $value, int $duration)
    {


        $this->duration = $duration;
        file_put_contents($key, $value);
    }


    public function get(string $key)
   {

        if (file_exists($key)) {
			echo "file exists<br>";
			if(time() - filemtime($key) < 300) {
				echo "file has not expired.<br>";
            	$fileContents = file_get_contents($key) or die('cannot get contents.');
				echo $fileContents;
        	} else {
	            echo 'cache expired<br>';
				echo 'time :'.time()."<br>";
				echo 'filemtime : '.filemtime($key).'<br>';
				echo 'cached time: '.((time() - filemtime($key))).'<br>';
				echo 'cache allowed time: 300';
	            return null;
	        }
	    } else {
		echo 'File does not exist.';
		}

	}


}


$file = new Cache;

  //$file->set('result', $body, 60*5);

$file->get('result');
?>
