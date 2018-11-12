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
        $card = "";
        $url = "http://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/nearmeredesign/8.957046/38.763025/10/0/10";
        // $url = "https://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/getfavouriteresults/user_id/-1.28333/36.81667/0/300";
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
        $json_object = json_decode($result);
        $error = json_last_error();
        // var_dump($json_object);
        $companies = $json_object->companies;
        // var_dump($companies);
        for ($i = 0; $i < count($companies); $i++) {
            // $comp = $companies[0]->company_name;
            $companyname = $companies[$i]->company_name_en;
            $companyaddress = $companies[$i]->city_name_en;
            $company[] = "Company Name:" . $companyname . "," . "City Name:" . $companyaddress;
            
            // array_push($company, $companies[$i]->company_name);
        }
        $company_name = $company;
        // var_dump($company_name);
        // $company_name = $company;
        foreach ($company_name as $comp) {
            // var_dump($comp);
            // $card = "<ul><li>" . $comp . "</li></ul>";
            echo "<ol><li>" . $comp . "</li></ol>";
            // echo $card;
        }
        
        // var_dump($company_name);
        // echo $company_name;


    }


}
