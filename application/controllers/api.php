<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    private $status = array(
        array('code' => 0, 'message' => 'Success'), // 0
        array('code' => 1, 'message' => 'Failed'), // 1
        array('code' => -1, 'message' => 'Bad Credential'), // 2
        array('code' => -2, 'message' => 'Bad Request'), // 3
        array('code' => 2, 'message' => 'Non Exist User'), // 4
        array('code' => 3, 'message' => 'Wrong Password'), // 5
        array('code' => 4, 'message' => 'You haven\'t permission'), // 6
        array('code' => 5, 'message' => 'Can\'t open file'), // 7
        array('code' => 6, 'message' => 'Unknown Device'), // 8
    );

    public function __construct() {
        parent::__construct();
        $this->load->library('uuid');

        $this->load->model('user_model');
        $this->load->model('utility_model');
        $this->load->model('edu_model');
    }

    // version 1.0
    public function v1($method = '', $param = '', $kind = '') {
        $response = array(
            'status' => $this->status[1],
            'request' => array(
                'method' => $method,
                'param' => $param,
                'kind' => $kind,
                'data' => array()
            ),
            'response' => array(
            )
        );

        $request_data = array();
        $result_data = array();

        if ($method == 'quotes') {
            $size = 21;
            $page = 0;

            $category = $this->input->get_post('category');
            $user_id = $this->input->get_post('user_id');
            $page = $this->input->get_post('page');
            $size = $this->input->get_post('size');

            $t = mdate('%Y%m%d%H%i%s', time() - 60 * 60 * 24 * 5);
            $request_data['time'] = $t;

            $order_by = " ";
            if ($category == "0") {
                $order_by = " where a.updated_at>='" . $t . "' and a.rv>0 order by a.updated_at desc ";
            }

            if ($category == "1") {
                $order_by = " order by a.created_at desc ";
            }
            if ($category == "2") {
                $order_by = " order by a.rv desc ";
            }

            if ($category == "3") {     // fav
                $order_by = " , fq_likes b where a.id=b.quotes_id and b.user_id='" . $user_id . "' and b.rv>0 order by a.rv desc  ";
            }

            if ($size !== false) {
                
            } else {
                $size = 21;
            }

            if ($page !== false) {
                
            } else {
                $page = 0;
            }

            $total = $this->utility_model->get_count__by_sql(" select a.* from fq_quotes a " . $order_by . " ");
            $pages = intval($total / intval($size));
            if ($total % $size != 0) {
                $pages += 1;
            }

            $result_data['total_page'] = $pages;
            $result_data['total_num_rows'] = $total;
            $result_data['page'] = intval($page);
            $result_data['size'] = intval($size);

            $offset = (intval($page)) * intval($size);
            $r_data = $this->utility_model->get_list__by_sql(" select a.* from fq_quotes a " . $order_by . " limit $offset , $size ");
            $result_data['list'] = $r_data;
            $response['status'] = $this->status[0];
        } else if ($method == 'like') {
            $user_id = $this->input->get_post('user_id');
            $quotes_id = $this->input->get_post('quotes_id');
            $t = mdate('%Y%m%d%H%i%s', time());

            if ($user_id && $quotes_id) {
                $quotes = $this->utility_model->get('fq_quotes', array('id' => $quotes_id));

                if ($quotes) {
                    if ($this->utility_model->update('fq_quotes', array('rv' => intval($quotes['rv']) + 1, 'updated_at' => $t), array('id' => $quotes_id))) {
                        $result_data['rv'] = intval($quotes['rv']) + 1;
                        $likes = $this->utility_model->get('fq_likes', array('quotes_id' => $quotes_id, 'user_id' => $user_id));

                        if ($likes) {
                            $this->utility_model->update('fq_likes', array('rv' => intval($likes['rv']) + 1), array('quotes_id' => $quotes_id, 'user_id' => $user_id));
                            $result_data['rate'] = intval($likes['rv']) + 1;
                            $response['status'] = $this->status[0];
                        } else {
                            if ($this->utility_model->insert('fq_likes', array('quotes_id' => $quotes_id, 'user_id' => $user_id, 'rv' => 1))) {
                                $result_data['rate'] = 1;
                                $response['status'] = $this->status[0];
                            } else {
                                $response['status'] = $this->status[1];
                            }
                        }
                    } else {
                        $response['status'] = $this->status[1];
                    }
                } else {
                    $response['status'] = $this->status[1];
                }
            } else {
                $response['status'] = $this->status[3];
            }
        } else if ($method == 'dislike') {
            $user_id = $this->input->get_post('user_id');
            $quotes_id = $this->input->get_post('quotes_id');
            $t = mdate('%Y%m%d%H%i%s', time());

            if ($user_id && $quotes_id) {
                $quotes = $this->utility_model->get('fq_quotes', array('id' => $quotes_id));
                if ($quotes) {
                    if ($this->utility_model->update('fq_quotes', array('rv' => intval($quotes['rv']) - 1, 'updated_at' => $t), array('id' => $quotes_id))) {
                        $result_data['rv'] = intval($quotes['rv']) - 1;
                        $likes = $this->utility_model->get('fq_likes', array('quotes_id' => $quotes_id, 'user_id' => $user_id));
                        if ($likes) {
                            $this->utility_model->update('fq_likes', array('rv' => intval($likes['rv']) - 1), array('quotes_id' => $quotes_id, 'user_id' => $user_id));
                            $result_data['rate'] = intval($likes['rv']) - 1;
                            $response['status'] = $this->status[0];
                        } else {
                            if ($this->utility_model->insert('fq_likes', array('quotes_id' => $quotes_id, 'user_id' => $user_id, 'rv' => -1))) {
                                $result_data['rate'] = -1;
                                $response['status'] = $this->status[0];
                            } else {
                                $response['status'] = $this->status[1];
                            }
                        }
                    } else {
                        $response['status'] = $this->status[1];
                    }
                } else {
                    $response['status'] = $this->status[1];
                }
            } else {
                $response['status'] = $this->status[3];
            }
        } else if ($method == 'admob') {
            $result_data = $this->utility_model->get_list('fq_admob', array());
            $response['status'] = $this->status[0];
        } else if ($method == 'push') {

            if ($param == 'register') {
                $user_id = $this->input->get_post('user_id');
                $android_id = $this->input->get_post('android_id');
                $ios_id = $this->input->get_post('ios_id');

                if ($user_id === false) {
                    $response['status'] = $this->status[3];
                } else {
                    if ($android_id !== false || $ios_id !== false) {

                        if ($android_id !== false) {
                            $user = $this->utility_model->get('fq_notify', array('android_id' => $android_id));
                            if ($user) {
                                if ($user_id == $user['user_id']) {
                                    $response['status'] = $this->status[0];
                                } else {
                                    $this->utility_model->delete('fq_notify', array('android_id' => $android_id));
                                    if ($this->utility_model->insert('fq_notify', array('user_id' => $user_id, 'android_id' => $android_id))) {
                                        $response['status'] = $this->status[0];
                                    }
                                }
                            } else {
                                if ($this->utility_model->insert('fq_notify', array('user_id' => $user_id, 'android_id' => $android_id))) {
                                    $response['status'] = $this->status[0];
                                }
                            }
                        } else {
                            $user = $this->utility_model->get('fq_notify', array('ios_id' => $ios_id));
                            if ($user) {
                                if ($user_id == $user['user_id']) {
                                    $response['status'] = $this->status[0];
                                } else {
                                    $this->utility_model->delete('fq_notify', array('ios_id' => $ios_id));
                                    if ($this->utility_model->insert('fq_notify', array('user_id' => $user_id, 'ios_id' => $ios_id))) {
                                        $response['status'] = $this->status[0];
                                    }
                                }
                            } else {
                                if ($this->utility_model->insert('fq_notify', array('user_id' => $user_id, 'ios_id' => $ios_id))) {
                                    $response['status'] = $this->status[0];
                                }
                            }
                        }
                    } else {
                        $response['status'] = $this->status[3];
                    }
                }
            } 
            else if ($param == 'send') {
                $c = $this->input->get_post('count');
                $count = "1";
                if ($c != false) {
                    $count = "" . $c;
                }

                $user = $this->utility_model->get_list__by_sql("select a.* from fq_notify a where (a.android_id<>'' and a.android_id is not null)");
                $devices = array();
                foreach ($user as $row) {
                    array_push($devices, $row['android_id']);
                }

                $this->send_push_android($devices, $count);

                $user = $this->utility_model->get_list__by_sql("select a.* from fq_notify a where (a.ios_id<>'' and a.ios_id is not null)");
//                $ios_device = array();
                foreach ($user as $row) {
//                    array_push($ios_device, $row['ios_id']);
                    array_push($result_data, $this->send_push_ios($row['ios_id'], intval($count)));
                }
                
                $response['status'] = $this->status[0];
            } else {
                $response['status'] = $this->status[2];
            }
        } else {
            $response['status'] = $this->status[2];
        }

        $response['request']['data'] = $request_data;
        $response['response'] = $result_data;

        print_r(json_encode($response, JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG));
    }

    // version 2.0
    public function v2($method = '', $param = '', $detail = '') {
        
    }

    public function upload($version = '') {
        $msg = array('errCode' => 1, 'errMsg' => 'Failed!', 'url' => '', 'path' => '');
        $dir_name = "resource/upload/";
        $upload_count = 0;

        if ($version == 'v1') {
            $uu_id = $this->uuid->v4();
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            $fname = mdate('%Y%m%d%H%i%s', time()) . "_" . $uu_id . "." . $ext;
            $new_name = $dir_name . $fname;

            move_uploaded_file($_FILES['file']['tmp_name'], $new_name);

            $msg['url'] = base_url() . $new_name;
            $msg['path'] = $fname;
            $msg['errCode'] = 0;
            $msg['errMsg'] = "Success!";
        }

        if ($version == 'v2') {
            if (is_array($_FILES['files']['name'])) {

                foreach ($_FILES['files']['name'] as $row => $row2) {
                    $uu_id = $this->uuid->v4();
                    $ext = pathinfo($_FILES['files']['name'][$row], PATHINFO_EXTENSION);

                    $fname = mdate('%Y%m%d%H%i%s', time()) . "_" . $uu_id . "." . $ext;
                    $new_name = $dir_name . $fname;

                    if (move_uploaded_file($_FILES['files']['tmp_name'][$row], $new_name)) {
                        $t = mdate('%Y%m%d%H%i%s', time());

                        $data = array('url' => $fname, 'rv' => 0);
                        $data['created_at'] = $t;
                        $data['updated_at'] = $t;

                        if ($this->utility_model->insert('fq_quotes', $data)) {
                            $upload_count++;
                        }
                    }
                }

                $msg['errCode'] = 0;
                $msg['errMsg'] = "Success!";
            } else {
                $uu_id = $this->uuid->v4();
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

                $fname = mdate('%Y%m%d%H%i%s', time()) . "_" . $uu_id . "." . $ext;
                $new_name = $dir_name . $fname;

                move_uploaded_file($_FILES['file']['tmp_name'], $new_name);

                $msg['url'] = base_url() . $new_name;
                $msg['path'] = $fname;
                $msg['errCode'] = 0;
                $msg['errMsg'] = "Success!";
            }
        }

        $msg['upload_count'] = $upload_count;
        print_r(json_encode($msg));
    }

    private function send_push_android($device_id = '', $count) {
        $serverApiKey = "AIzaSyB5NaZAxcDVkZLj4-au0L8RyIsdcONPJNo";

        $headers = array(
            'Authorization: key=' . $serverApiKey,
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => $device_id,
            'data' => array("message" => $count),
        );

        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Avoids problem with https certificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;
    }

    private function send_push_ios($device_id = '', $count) {
        usleep(100000);
        
        $message = "";
        if ($count==1) {
            $message = "new image was uploaded";
        } else {
            $message = $count . " new images were uploaded";
        }
        
        
        $payload = array();
        $payload['aps'] = array('alert' => $message, 'sound' => 'default');
        $data = json_encode($payload);

        // Create a Stream
        $ctx = stream_context_create();
        // Define the certificate to use 
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'resource/aps_develop.pem');
        // Passphrase to the certificate
        stream_context_set_option($ctx, 'ssl', 'passphrase', 'jokesapp cert');

        $fp = stream_socket_client('ssl://' . APNS_GATEWAY . ':' . APNS_PORT, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        // Check that we've connected
        if (!$fp) {
            return "Failed to connect: $err $errstr";
        }

        // Ensure that blocking is disabled
        stream_set_blocking($fp, 0);

        // Send it to the server
        $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $device_id)) . chr(0) . chr(strlen($data)) . $data;
        $result = fwrite($fp, $apnsMessage);

        // Close the connection to the server
        fclose($fp);
        
        return $result;
    }

}
