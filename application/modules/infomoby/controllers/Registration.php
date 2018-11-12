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
        // $json_string = file_get_contents("php://input");
        $json_string = '[{"busname":"Palace Restaurant","cat":"Service","phone":"0734567890","logo":"https://cdn.ins-000.kms.osi.office.net/att/d16d1d14aea759eff7824213db58c9b8f5f01b0dd898951240e2082851e7146a.jpg?sv=2015-12-11&sr=b&sig=F73wJRZeEKq%2FaEuVlzIa6lLr7biTK98%2BZYYSgJBOLhA%3D&st=2018-11-12T05:06:50Z&se=2292-08-27T06:06:50Z&sp=r","location":"Parklands Road, Nairobi, Kenya"}]';
        // $resultString = array();
        $pureresultString = array();
        // array_push($pureresultString, $json_string);
        // echo json_encode($pureresultString);
        // var_dump($json_string);
        $json_object = json_decode($json_string);
        var_dump($json_object);
        // $response = array();
        // $response["start"]=$json_string;
        $count =0;

        if(is_array($json_object))
        {
            // $response["result"] = $json_object;
            // var_dump("is array");
            if(count($json_object) > 0)
            {
                // $response["result"] = $json_object;
                foreach($json_object as $row)
                {
                    // $busname = $chat[0]["busname"];
                    // $cat = $chat[0]["cat"];
                    // $phone = $chat[0]["phone"];
                    //  $logo = $chat[0]["logo"];
                    // $locoation = $chat[0]["locoation"];
                    // array_push($resultString,$row->busname);
                    // var_dump($resultString);
                    $data = array(
                        "id"=>$count++,
                        "business_name" => $row->busname,
                        "category" => $row->cat,
                        "phone_number" => $row->phone,
                        "logo" => $row->logo,
                        "location" => $row->location
                        // "id"=>"1",
                        // "business_name" => "Queens Resturant",
                        // "category" => "Service",
                        // "phone_number" => "0737892340",
                        // "logo" => "https://cdn.ins-000.kms.osi.office.net/att/59f2786d190dd388acd91ec6a7c1a791a19be4f3beb089867303d71b6a98811b.jpg?sv=2015-12-11&sr=b&sig=0fQ30eS8SsngxAWYgJAo7K1d92viRotqoV8phGUdB1c%3D&st=2018-11-09T05:55:12Z&se=2292-08-24T06:55:12Z&sp=r",
                        // "location" => "Westlands, Nairobi, Kenya"
                    );
                    var_dump($data);
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
        // getData();

        // echo $this->db->count_all('register_businesses');
        // echo json_encode($json_object);
        echo json_encode($response);
    }
    // public function getData(){
    //    $contents = $this->db->count_all('register_businesses');
    //    echo json_encode($contents);
    // }
}
