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
        //fetch all users
        $users = $this->db->get('users')->result();
        $temp_phone = 'temp_phone';

        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                foreach ($json_object as $row) {
                    $response_time = date("Y-m-d H:i:s");
                    $userId = $row->userId;
                    $dataItem = array(
                        "time_modified" => $response_time,
                        "category" => $row->category,
                        "item" => $row->item,
                        "quantity" => $row->quantity,
                        "units" => $row->units,
                        "price" => $row->price,
                        "user_id" => $userId,
                        "image" => $row->image,
                    );

                    $dataUser = array(
                        "name" => $row->name,
                        "phone_number" => $row->phone,
                        "user_id" => $userId,
                        "time_modified" => $response_time,
                    );

                    if ($this->db->insert("items", $dataItem)) {
                        $response["result"] = "true";
                        $response["message"] = "Request saved successfully";
                    } else {
                        $response["result"] = "false";
                        $response["message"] = "Unable to save item";
                    }
                    //check if there is anything in users table
                    if (count($users) > 0) {
                        foreach (json_encode($users) as $user) {
                            //check if the phone number already exists in db
                            if ($user['phone_number'] == $row->phone) {
                                // if yes
                                $temp_phone = $row->phone;
                            }
                        }

                        //if phone number in the db abd the incoming do not match
                        if ($temp_phone == 'temp_phone') {
                            if ($this->db->insert("users", $dataUser)) {
                                $response["result"] = "true";
                                $response["message"] = "Request saved successfully";
                            } else {
                                $response["result"] = "false";
                                $response["message"] = "Unable to save item";
                            }
                        }
                    } else {
                        // var_dump($data); die();
                        if ($this->db->insert("users", $dataUser)) {
                            $response["result"] = "true";
                            $response["message"] = "Request saved successfully";
                        } else {
                            $response["result"] = "false";
                            $response["message"] = "Unable to save item";
                        }
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
        // echo json_encode($response);
        // foreach()
        $sam = $this->db->get('users')->result();

        //var_dump($sam[0]["id"]);
        var_dump($sam[0]->id);
    }
}
