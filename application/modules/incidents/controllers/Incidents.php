<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incidents extends MX_Controller {
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
	public function index()
	{
		$this->db->order_by("incident_timestamp", "DESC");
		$incidents = $this->db->get("incident");
		$v_data = array(
			"incidents" => $incidents
		);
		$data = array(
			"nav" => FALSE,
			"body_class" => "",
			"title" => "Incidents",
			"content" => $this->load->view('all_incidents', $v_data, TRUE),
		);
		$this->load->view('master', $data);
	}

	public function save_incident()
	{
		// $json_string = '[{"incident_date":1541005320000,"incident_station":"Hjhj","incident_reporting_person_ssa":"Vjfu","incident_reporting_person_co_no":"Gshj","incident_reporting_person_name":"Alvaro","incident_reporting_person_phone":"+254726149351","location":{"lt":-1.3159008,"lg":36.8220986,"n":"-1.3159008, 36.8220986","acc":16.0},"incident_person_injured":"Fhgjvh","incident_designation":"Shvhj","incident_permit_order_no":"Fbcb","incident_classification":"Product Spillage","incident_other_classification":"Chvb","incident_summary":"Vhfb","incident_results":"Vbcg","incident_action":"Chvh","incident_image":"https://cdn.ins-000.kms.osi.office.net/att/08d223f69a4fe1b5ee215af86c244c7edc418705f450f370c8bc365c18045969.jpg?sv=2015-12-11&sr=b&sig=iB5a%2BgUFAQnBna6jgl4ZWQdMzFUF%2F7ltZjmBIw102TE%3D&st=2018-10-31T16:03:30Z&se=2292-08-15T17:03:30Z&sp=r","incident_submitted_date":1541005409150}]';
		$json_string = file_get_contents("php://input");
		// var_dump($json_string); die();
		$json_object = json_decode($json_string);
		// var_dump($json_object); die();
		foreach($json_object as $row){
			// var_dump($row->incident_date);die();
			// echo date("Y-m-d H:i:s", intval($row->incident_date));
			$location = $row->location;
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
				echo "saved";
			}

			else{
				echo "error";
			}
		}
	}

	public function get_regions(){
		$query = $this->db->get("safaricom_regions");
		echo json_encode($query->result());
	}

	public function save_sso()
	{
		$json_string = file_get_contents("php://input");
		
		$json_object = json_decode($json_string);
		
		foreach($json_object as $row){
			$location = $row->location;
			$data = array(
				"outlet_name" => $row->outlet_name,
				"channel_type" => $row->channel_type,
				"region" => $row->region,
				"sales_area" => $row->sales_area,
				"cluster" => $row->cluster
			);
			
			if($this->db->insert("sso", $data)){
				echo "saved";
			}

			else{
				echo "error";
			}
		}
	}

	public function get_mawingu_customer($phone_number){
		$conn_string = "host=pg.net-service.cz port=5432 dbname=mawingu_production user=mawingu_stat password=Mawingu2891872";
		$conn = pg_connect($conn_string);
		if (!$conn) {
			echo "Unable to connect";
			exit;
		}

		$phone_number = "+".$phone_number;
		echo $phone_number; die();

		$result = pg_query($conn, "SELECT * FROM customers WHERE username = '".$phone_number."'");
		if (!$result) {
			echo "Customer not found";
			exit;
		}

		while ($row = pg_fetch_row($result)) {
			echo json_encode($row);
		}
	}
}
