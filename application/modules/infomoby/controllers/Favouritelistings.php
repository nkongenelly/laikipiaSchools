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

    public function getFavoriteListings()
    {
		// $json_string = '[{"incident_date":1541005320000,"incident_station":"Hjhj","incident_reporting_person_ssa":"Vjfu","incident_reporting_person_co_no":"Gshj","incident_reporting_person_name":"Alvaro","incident_reporting_person_phone":"+254726149351","location":{"lt":-1.3159008,"lg":36.8220986,"n":"-1.3159008, 36.8220986","acc":16.0},"incident_person_injured":"Fhgjvh","incident_designation":"Shvhj","incident_permit_order_no":"Fbcb","incident_classification":"Product Spillage","incident_other_classification":"Chvb","incident_summary":"Vhfb","incident_results":"Vbcg","incident_action":"Chvh","incident_image":"https://cdn.ins-000.kms.osi.office.net/att/08d223f69a4fe1b5ee215af86c244c7edc418705f450f370c8bc365c18045969.jpg?sv=2015-12-11&sr=b&sig=iB5a%2BgUFAQnBna6jgl4ZWQdMzFUF%2F7ltZjmBIw102TE%3D&st=2018-10-31T16:03:30Z&se=2292-08-15T17:03:30Z&sp=r","incident_submitted_date":1541005409150}]';
		// $json_string = file_get_contents("php://input");
		// // var_dump($json_string); die();
		// $json_object = json_decode($json_string);
        // var_dump($json_object); die();

        $url = "https://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/getfavouriteresults/user_id/-1.28333/36.81667/0/300";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            // 'Content-Type: application/json',
            // 'Content-Length: ' . strlen($data_string),
            'Authorization:0c9e64ab66a28f5576e24c3b21614e88 '
        ));

        $result = curl_exec($ch);
        dd($result);
        curl_close($ch);
    }


}
