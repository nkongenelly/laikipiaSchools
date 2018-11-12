<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Favouritelistings extends MX_Controller
{
    /**
     * Constructor for this controller.
     *
     * Tasks:
     * 		Checks for an active advertiser login session
     *	- and -
     * 		Loads models required
     */
    function __construct()
    {
        parent::__construct();
		// Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
	
		// Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function favorite_listings()
    {
        $company = array();
        $url = "https://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/getfavouriteresults/user_id/-1.28333/36.81667/0/300";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:0c9e64ab66a28f5576e24c3b21614e88 '
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        // foreach ($result as $oneresult) {
        //     $company_name = $oneresult["company_name"];
        //     var_dump($company_name);
        // }
        // var_dump($result);
        // echo $result;
        // echo "Serena Hotel";
        // $result2 = preg_replace('/\s+/', '', $result);
        // $result = str_replace('&quot;', '"', $result);
        $result2 = '{"error":false,"success":200,"companies":[{"company_id":"258410","company_name":"Africa Inland Church-Upperhill","display_address":null,"website":"http://www.aickenya.org","logo":"","contact_number":"0722889901","category_id":"15500","category_name":"Churches & Church Organisations","latitude":"-1.295749","longitude":"36.816003","verified":"1","hours":"2-6:0800-1700","city_id":"275","city_name":"Dagoreti North","region_id":"47","region_name":"Nairobi","area_name":"Kilimani","rating_num":null,"review_count":"0","price_range":null,"price_value":null,"totalvisit":null,"distance":"0.8592647070211619"},{"company_id":"258472","company_name":"Asal Health","display_address":null,"website":"http://www.asalhealth.com/","logo":"20160621_160851_asal.png","contact_number":"708433347","category_id":"37780","category_name":"Health Centres","latitude":"-1.298498","longitude":"36.811524","verified":"1","hours":"2-1:0000-2359","city_id":"275","city_name":"Dagoreti North","region_id":"47","region_name":"Nairobi","area_name":"Kilimani","rating_num":null,"review_count":"0","price_range":null,"price_value":null,"totalvisit":null,"distance":"1.106596866818243"},{"company_id":"258459","company_name":"Hemingways Expeditions","display_address":null,"website":"http://www.hemingways-expeditions.com/","logo":null,"contact_number":"202295000","category_id":"70820","category_name":"Safaris","latitude":"-1.3261531","longitude":"36.709369899999956","verified":"1","hours":"2-1:0800-1800","city_id":"277","city_name":"Langata","region_id":"47","region_name":"Nairobi","area_name":"Karen","rating_num":null,"review_count":"0","price_range":null,"price_value":null,"totalvisit":null,"distance":"7.980167000416598"},{"company_id":"164649","company_name":"Maanzoni Lodge Ltd","display_address":"Mombasa Rd, near Machakos Turn Off Athi River","website":"http://maanzonilodge.co.ke/","logo":"2017-09-15-Maanzoni-Logo-300x156.png","contact_number":"0000","category_id":"39300","category_name":"Hotels","latitude":"-1.506005","longitude":"37.096764","verified":"1","hours":"1-7:0000-2359","city_id":"80","city_name":"Mavoko","region_id":"16","region_name":"Machakos","area_name":"Athi River","rating_num":"4","review_count":"0","price_range":null,"price_value":null,"totalvisit":null,"distance":"24.717446542181403"},{"company_id":"258433","company_name":"Shiks Auto Accessories","display_address":null,"website":"","logo":"","contact_number":"0721884566","category_id":"52595","category_name":"Motorvehicle Accessories","latitude":"-1.280752","longitude":"36.827936","verified":"1","hours":"2-6:0800-1700,7-7:0800-1500","city_id":"289","city_name":"Starehe","region_id":"47","region_name":"Nairobi","area_name":"Nairobi Central","rating_num":null,"review_count":"0","price_range":null,"price_value":null,"totalvisit":null,"distance":"0.798296912277439"}]}';
        $json_object = json_decode($result2);
        $error = json_last_error();
        // var_dump($json_object);
        $companies = $json_object->companies;
        // var_dump($companies);
        for ($i = 0; $i < count($companies); $i++) {
            // $comp = $companies[0]->company_name;
            $company[] = $companies[$i]->company_name;
            // array_push($company, $companies[$i]->company_name);
            echo $company;

        }

    }


}
