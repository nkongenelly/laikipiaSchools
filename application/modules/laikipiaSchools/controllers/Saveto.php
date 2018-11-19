<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saveto extends MX_Controller {
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

    public function savetodb()
    {
        $json_string = file_get_contents("php://input");
        //$json_string = '[{"\"busname\":Palace Restaurant,\n\"cat\":Service,\n\"phone\":0734567890,\n\"logo\":https:\/\/cdn.ins-000.kms.osi.office.net\/att\/d16d1d14aea759eff7824213db58c9b8f5f01b0dd898951240e2082851e7146a.jpg?sv=2015-12-11&sr=b&sig=F73wJRZeEKq%2FaEuVlzIa6lLr7biTK98%2BZYYSgJBOLhA%3D&st=2018-11-12T05:06:50Z&se=2292-08-27T06:06:50Z&sp=r,\n\"location\":Parklands Road, Nairobi, Kenya"}]';
        $pureresultString = array();
        $json_object = json_decode($json_string);
        $count =0;

        if(is_array($json_object))
        {
            if(count($json_object) > 0)
            {
                foreach($json_object as $row)
                {
                    $data = array(
                        "school_name" => $row->school_name,
                        "boys" => $row->boys,
                        "girls" => $row->girls,
                        "about" => $row->about,
                        "logo" => $row->logo,
                        "latitude" => $row->latitude,
                        "longitude" => $row->longitude
                    );
                    if($this->db->insert("laikipia_schools", $data)){
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
            $response["string"] = $json_string;
            $response["object"] = json_encode($json_object);
            $response["array"] = is_array($json_object);
        }
        echo json_encode($response);
    }
}
