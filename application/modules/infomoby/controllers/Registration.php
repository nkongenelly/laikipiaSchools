<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends MX_Controller {
	/**
	 * Constructor for this controller.
	 *
	 * Tasks:
	 * 		Checks for an active advertiser login session
	 *	- and -
	 * 		Loads models required
	 */
    function __construct() {
		parent:: __construct();
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

    public function register_business()
    {
        $json_string = file_get_contents("php://input");

        $json_object = json_decode($json_string);
        $response = array();
        $response["start"]=$json_string;
        // var_dump($json_string);
        if(is_array($json_object))
        {
            if(count($json_object) > 0)
            {
                foreach($json_object as $row)
                {
                    
                    $data = array(
                        "business_name" => $row->busname,
                        "category" => $row->cat,
                        "phone_number" => $row->phone,
                        "logo" => $row->logo,
                        "location" => $row->locoation
                    );
                    // var_dump($data); die();
                    if($this->db->insert("register_businesses", $data)){
                        $response["result"] = "true";
                        $response["message"] = "Request saved successfully";
                    }

                    else{
                        $response["result"] = "false";
                        $response["message"] = "Unable to save item";
                    }
                }
            }
            else{
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        }
        else{
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }

        echo json_encode($response);
    }
}
