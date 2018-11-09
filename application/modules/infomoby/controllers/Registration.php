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

        if(is_array($json_object))
        {
            if(count($json_object) > 0)
            {
                foreach($json_object as $row)
                {
                    $data = array(
                        "incident_date" => date("Y-m-d H:i:s", intval($row->incident_date)),
                        "incident_station" => $row->incident_station,
                        "incident_reporting_person_ssa" => $row->incident_reporting_person_ssa,
                        "incident_reporting_person_co_no" => $row->incident_reporting_person_co_no,
                        "incident_reporting_person_name" => $row->incident_reporting_person_name,
                        "incident_reporting_person_phone" => $row->incident_reporting_person_phone,
                        "incident_lat" => $location->lt,
                        "incident_long" => $location->lg,
                        "incident_person_injured" => $row->incident_person_injured,
                        "incident_designation" => $row->incident_designation,
                        "incident_permit_order_no" => $row->incident_permit_order_no,
                        "incident_classification" => $row->incident_classification,
                        "incident_other_classification" => $row->incident_other_classification,
                        "incident_summary" => $row->incident_summary,
                        "incident_results" => $row->incident_results,
                        "incident_action" => $row->incident_action,
                        "incident_image" => $row->incident_image,
                        "incident_submitted_date" => date("Y-m-d H:i:s", intval($row->incident_submitted_date))
                    );
                    // var_dump($data); die();
                    if($this->db->insert("incident", $data)){
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
