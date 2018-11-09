<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends MX_Controller
{
    /**
     * Constructor for this controller.
     *
     * Tasks:
     *         Checks for an active advertiser login session
     *    - and -
     *         Loads models required
     */
    public function __construct()
    {
        parent::__construct();
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
    }

    public function register_services()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();

        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                foreach ($json_object as $row) {
                    $response_time = $row->response_time;
                    $dataItem = array(
                        "time_modified" => date("Y-m-d H:i:s", intval($response_time)),
                        "category" => $row->category,
                        "item" => $row->item,
                        "quantity" => $row->quantity,
                        "units" => $row->units,
                        "price" => $row->price,
                        "user_id" => $row->userId,
                        "image" => $row->image,
                    );

                    // $dataUser = array(
                    //     "time_modified" => date("Y-m-d H:i:s", intval($response_time)),
                    //     "name" => $row->category,
                    //     "phone_number" => $row->phone,
                    // );
                    // var_dump($data); die();
                    if (($this->db->insert("items", $dataItem))) {
                        $response["result"] = "true";
                        $response["message"] = "Request saved successfully";
                    } else {
                        $response["result"] = "false";
                        $response["message"] = "Unable to save item";
                    }
                }
            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }

        echo json_encode($response);
        echo json_encode($this->db->select('users'));
    }
}
