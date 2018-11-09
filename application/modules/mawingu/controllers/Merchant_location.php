<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant_location extends MX_Controller {
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

    public function generate_bucket_names()
    {
        $query = $this->db->get("merchant_locations");

        if($query->num_rows() > 0){
            foreach($query->results() as $res){
                $bucket_name = '';
                $bucket_name_ip = '';

                $merchant_location_id = $res->merchant_location_id;
                $district = preg_replace('/\s+/', '', $res->district);
                $BS_Name = preg_replace('/\s+/', '', $res->BS_Name);
                $Equipment = preg_replace('/\s+/', '', $res->Equipment);
                $Client_type = preg_replace('/\s+/', '', $res->Client_type);
                $First_Name = preg_replace('/\s+/', '', $res->First_Name);
                $Second_name = preg_replace('/\s+/', '', $res->Second_name);
                $Address = preg_replace('/\s+/', '', $res->Address);
                $Equipment1 = preg_replace('/\s+/', '', $res->Equipment1);
                $IP_Address = preg_replace('/\s+/', '', $res->IP_Address);
                
                $IP_Address = str_replace('(', '', $IP_Address);
                $IP_Address = str_replace(')', '', $IP_Address);

                if(!empty($district)){
                    $bucket_name = $district;
                }

                if(!empty($BS_Name)){
                    $bucket_name .= "_".$BS_Name;
                }

                if(!empty($Equipment)){
                    $bucket_name .= "_".$Equipment;
                }

                if(!empty($Client_type)){
                    $bucket_name .= "_".$Client_type;
                }

                if(!empty($First_Name)){
                    $bucket_name .= "_".$First_Name;
                }

                if(!empty($Second_name)){
                    $bucket_name .= "_".$Second_name;
                }

                if(!empty($Address)){
                    $bucket_name .= "_".$Address;
                }

                if(!empty($Equipment1)){
                    $bucket_name .= "_".$Equipment1;
                }

                if(!empty($IP_Address)){
                    $bucket_name_ip .= " (".$IP_Address.")";
                }

                $data = array();
                if(!empty($bucket_name)){
                    $data['bucket_name'] = $bucket_name;
                }

                if(!empty($bucket_name_ip)){
                    $data['bucket_name_ip'] = $bucket_name_ip;
                }
                
                if(count($data) > 0){
                    $this->db->where("merchant_location_id", $merchant_location_id);
                    $this->db->update("merchant_location", $data);
                }
            }
        }
    }
}
