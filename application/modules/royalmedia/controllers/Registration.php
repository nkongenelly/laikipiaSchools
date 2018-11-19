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

<<<<<<< HEAD
    public function index(){
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();

        $this->load->view('royalMediaServices/searchView',$response);
    }

    public function get_category_id($category){
        $this->db->where("category", $category);
        $query = $this->db->get("categories");
        $category_id = NULL;
        if($query->num_rows() > 0){
            $row = $query->row();
            $category_id = $row->category_id;
        }

        return $category_id;
    }

    public function user_exists($userId){
        $this->db->where("user_id", $userId);
        $query = $this->db->get("users");
        
        if($query->num_rows() > 0){
            return TRUE;
        }

        else {
            return FALSE;
        }
    }

=======
>>>>>>> 6a446e27c45886319c946fe6ca434f04ac501454
    public function register_services()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();
        //fetch all users from db table users
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
<<<<<<< HEAD
                        "location" => $row->location,
                        "category_id" => $this->get_category_id($row->category),
                    );

                    //Check if user exists
                    if($this->user_exists($userId) == FALSE){
                        $dataUser = array(
                            "name" => $row->name,
                            "phone_number" => $row->phone,
                            "user_id" => $userId,
                            "time_modified" => $response_time,
                        );

                        $this->db->insert("users", $dataUser);
=======
                    );

                    $dataUser = array(
                        "name" => $row->name,
                        "phone_number" => $row->phone,
                        "user_id" => $userId,
                        "time_modified" => $response_time,
                    );
                    //check if there is anything in users table
                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            //check if the phone number already exists in db
                            if ($user->user_id == $userId) {
                                // if yes
                                $temp_phone = "anything";
                                break;
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
>>>>>>> 6a446e27c45886319c946fe6ca434f04ac501454
                    }

                    if ($this->db->insert("items", $dataItem)) {
                        $response["result"] = "true";
                        $response["message"] = "Request saved successfully";
                    } else {
                        $response["result"] = "false";
                        $response["message"] = "Unable to save item";
                    }
                    break;
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
<<<<<<< HEAD
=======
        // foreach()
        //$sam = $this->db->get('users')->result();
        // var_dump(count($users));
>>>>>>> 6a446e27c45886319c946fe6ca434f04ac501454
    }

    public function services_search()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();

        //params to search with
        $category = '';
        $item = '';
        $units = '';

        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                foreach ($json_object as $row) {
                    $category = $row->category;
                    $item = $row->item;
                    $units = $row->units;
                }
            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }

        // $category = "Cereals";
        // $item = "Bean";
        // $units = "kg";
        if ($category != '' && $item != '' && $units != '') {

            $this->db->select('*');
            $this->db->from('items');
            $this->db->join('users', 'items.user_id = users.user_id');
            $this->db->where('category', $category);
            $this->db->where('item', $item);
            $this->db->where('units', $units);
            // $this->db->where('category', 'Cereals');
            // $this->db->where('item', 'Hotel');
            // $this->db->where('units', 'grams');
            $items = $this->db->get();

            //$items = $this->db->get('items');
            echo json_encode($items->result());
        }

    }
    public function items_search()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();
<<<<<<< HEAD
        
        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                $row = $json_object[0];
                $item = $row->item;
                $location = $row->location;
                
                $this->db->select('items.*, users.name, users.phone_number');
                $this->db->from('items, users');
                $this->db->order_by("category", "ASC");
                $this->db->order_by("time_modified", "DESC");
                $this->db->where("items.item LIKE '%".$item."%' AND items.location LIKE '%".$location."%' AND items.user_id = users.user_id");
                $items = $this->db->get();

                $response["result"] = "true";
                $response["message"] = $items->result();
                
            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }
        echo json_encode($response);
    }

    public function categories(){
        $this->db->select('*');
        $this->db->from("categories");
        $categories = $this->db->get();  
        echo json_encode($categories->result());
    }

    public function items(){
        $this->db->select('*');
        $this->db->from("items");
        $items = $this->db->get();  
        echo json_encode($items->result());
    }

    public function category_items(){
        $this->db->select('*');
        $this->db->from("category_items");
        $category_items = $this->db->get();  
        echo json_encode($category_items->result());
    }

    public function units(){
        $this->db->select('*');
        $this->db->from("units");
        $units = $this->db->get();  
        echo json_encode($units->result());
    }

    public function purchase_items()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();
        
        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                $row = $json_object[0];
                $data['quantity'] = $row->quantity;
                $data['item_id'] = $row->item_id;
                $data['customer_name'] = $row->customer_name;
                $data['customer_phone'] = $row->customer_phone;
                
                if($this->db->insert("orders", $data)){
                    $response["result"] = "true";
                }
                
                else{
                    $response["result"] = "false";
                    $response["message"] = "Unable to save";
                }
                
=======

        //params to search with
        $category = '';

        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                foreach ($json_object as $row) {
                    $category = $row->category;
                }
>>>>>>> 6a446e27c45886319c946fe6ca434f04ac501454
            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }
<<<<<<< HEAD
        echo json_encode($response);
=======

        // $category = "Cereals";
        // $item = "Bean";
        // $units = "kg";
        if ($category != '') {
            $this->db->select('item');
            $this->db->from('items');
            $this->db->where('category', $category);
            $items = $this->db->get();
            //$items = $this->db->get('items');
            echo json_encode($items->result());
        }else{
            echo "Category is null";
        }
>>>>>>> 6a446e27c45886319c946fe6ca434f04ac501454
    }
}
