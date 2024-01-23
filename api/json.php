<?php
require ("../mainconfig.php");
header("Content-Type: application/json");

if (isset($_POST['key']) and isset($_POST['action']))
{
    $post_key = mysqli_real_escape_string($db, trim($_POST['key']));
    $post_action = $_POST['action'];
    if (empty($post_key) || empty($post_action))
    {
        $array = array(
            "error" => "Incorrect request"
        );
    }
    else
    {
        $check_user = mysqli_query($db, "SELECT * FROM users WHERE api_key = '$post_key'");
        $data_user = mysqli_fetch_assoc($check_user);
        if (mysqli_num_rows($check_user) == 1)
        {
            $username = $data_user['username'];
            $user_id = $data_user['id'];
            if ($post_action == "order")
            {
                if (isset($_POST['service']) and isset($_POST['target']) and isset($_POST['quantity']))
                {
                    $post_service = $_POST['service'];
                    $post_target = $_POST['target'];
                    if (isset($_POST['custom_comments']))
                    {
                        $post_quantity = count(explode("\n", $_POST['custom_comments']));
                        $post_comments = $_POST['custom_comments'];
                    }
                    else
                    {
                        $post_quantity = $_POST['quantity'];
                    }
                    if (empty($post_service) || empty($post_target) || empty($post_quantity))
                    {
                        $array = array(
                            "error" => "Incorrect request"
                        );
                    }
                    else
                    {
                        $check_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_service' AND status = 'Active'");
                        $data_service = mysqli_fetch_assoc($check_service);
                        if (mysqli_num_rows($check_service) == 0)
                        {
                            $array = array(
                                "error" => "Layanan tidak ditemukan."
                            );
                        }
                        else
                        {
                            
                            $rate = $data_service['price'] / 1000;
                            $price = $rate * $post_quantity;
                            $total_profit = ($data_service['profit'] / 1000) * $_POST['quantity'];
                            $service = $data_service['service'];
                            $provider = $data_service['provider'];
                            $pid = $data_service['pid'];
                            if ($post_quantity < $data_service['min'])
                            {
                                $array = array(
                                    "error" => "Quantity inccorect"
                                );
                            }
                            else if ($post_quantity > $data_service['max'])
                            {
                                $array = array(
                                    "error" => "Quantity inccorect"
                                );
                            }
                            else if ($data_user['balance'] < $price)
                            {
                                $array = array(
                                    "error" => "Low balance"
                                );
                            }
                            else
                            {
                                $check_provider = mysqli_query($db, "SELECT * FROM provider WHERE name = '$provider'");
                                $data_provider = mysqli_fetch_assoc($check_provider);
                                $api_key = $data_provider['api_key'];
                                $api_link = $data_provider['api_url_order'];
                                $api_id = $data_provider['api_id'];

                                if ($provider == "MANUAL")
                                {
                                    $api_postdata = "";
                                }
                                else if ($provider == "IRVANKEDE")
                                {
                                    if (isset($_POST['custom_comments']))
                                    {
                                        $postdata = "api_id=4242&api_key=93a30a-ab0d6b-0ba6f4-7f590f-9859af&service=$pid&target=$post_target&custom_comments=" . $_POST['custom_comments'];
                                    }
                                    else if (isset($_POST['target']))
                                    {
                                        $postdata = "api_id=4242&api_key=93a30a-ab0d6b-0ba6f4-7f590f-9859af&service=$pid&target=$post_target&custom_link=$post_link&quantity=$post_quantity";
                                    }
                                    else
                                    {
                                        $postdata = "api_id=4242&api_key=93a30a-ab0d6b-0ba6f4-7f590f-9859af&service=$pid&target=$post_target&quantity=$post_quantity";
                                    }
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, "https://api.irvankede-smm.co.id/order");
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    $chresult = curl_exec($ch);
                                    curl_close($ch);
                                    $json_result = json_decode($chresult);
                                    $poid = $json_result
                                        ->data->id;
                                }
                                else if ($provider == "JAP")
                                {
                                    if (isset($_POST['custom_comments']))
                                    {
                                        $api_postdata = "key=$api_key&action=add&service=$pid&link=$post_target&comments=" . $_POST['custom_comments'];
                                    }
                                    else
                                    {
                                        $api_postdata = "key=$api_key&action=add&service=$pid&link=$post_target&quantity=$post_quantity";
                                    }
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $api_link);
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    $chresult = curl_exec($ch);
                                    curl_close($ch);
                                    $json_result = json_decode($chresult);
                                    $poid = $json_result->order;
                                }
                                
                                else if ($provider == "WSTORE")
                                {
                                    if (isset($_POST['custom_comments']))
                                    {
                                        $postdata = "api_id=6634&api_key=42b891-02faf0-3330d0-2ae822-1b3d7a&service=$pid&target=$post_target&custom_comments=" . $_POST['custom_comments'];
                                    }
                                    else
                                    {
                                        $postdata = "api_id=6634&api_key=42b891-02faf0-3330d0-2ae822-1b3d7a&service=$pid&target=$post_target&quantity=$post_quantity";
                                    }
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, "https://v1.wstore.co.id/order");
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    $chresult = curl_exec($ch);
                                    curl_close($ch);
                                    $json_result = json_decode($chresult);
                                }
                                
                                else if ($provider == "MEDANPEDIA")
                                {
                                    if (isset($_POST['custom_comments']))
                                    {
                                        $postdata = "api_id=9151&api_key=a9a4b3-aee91b-657e89-95d844-3065dd&service=$pid&target=$post_target&custom_comments=" . $_POST['custom_comments'];
                                    }
                                    else
                                    {
                                        $postdata = "api_id=9151&api_key=a9a4b3-aee91b-657e89-95d844-3065dd&service=$pid&target=$post_target&quantity=$post_quantity";
                                    }
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, "https://medanpedia.co.id/api/order");
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    $chresult = curl_exec($ch);
                                    curl_close($ch);
                                    $json_result = json_decode($chresult);
                                }

                                else
                                {
                                    die("System Error!");
                                }

                                if ($provider == "IRVANKEDE" and $json_result->status == false)
                                {
                                    $msg_type = "error";
                                    $msg_content = "<b>Failed:</b> " . $json_result->data . " .";
                                }
                                else if ($provider == "WSTORE" and $json_result->status == false)
                                {
                                    $msg_type = "error";
                                    $msg_content = "<b>Failed:</b>" . $json_result->data . " .";
                                }
                                else if ($provider == "MEDANPEDIA" and $json_result->status == false)
                                {
                                    $msg_type = "error";
                                    $msg_content = "<b>Failed:</b>" . $json_result->data . ".";

                                }
                                else
                                {
                                    if ($provider == "IRVANKEDE")
                                    {
                                        $poid = $json_result->data->id;
                                    }
                                    else if ($provider == "JAP")
                                    {
                                        $poid = $json_result->order;
                                    }
                                    else if ($provider == "RF")
                                    {
                                        $poid = $json_result['id'];
                                    }
                                    else if ($provider == "MEDANPEDIA")
                                    {
                                        $poid = $json_result->data->id;
                                    }
                                    else if ($provider == "WSTORE")
                                    {
                                        $poid = $json_result->data->id;
                                    }
                                    if (empty($poid))
                                    {
                                        $msg_type = "error";
                                        $array = array(
                                            "error" => "System maintance (1)"
                                        );
                                    }
                                    else
                                    {
                                        $oid = random_number(5);
                                        $update_user = mysqli_query($db, "UPDATE users SET balance = balance-$price WHERE username = '$username'");
                                        if ($update_user == true)
                                        {
                                            $insert_order = mysqli_query($db, "INSERT INTO orders (id, user_id, service_name, data, quantity, price, profit, status, created_at, provider, provider_order_id, is_api) VALUES ('$oid','$user_id', '$service', '$post_target', '$post_quantity', '$price', '$total_profit', 'Pending', '".date('Y-m-d H:i:s')."', '$provider', '$poid', '1')");
                                            if ($insert_order == true)
                                            {
                                                $array = array("id" => "$oid");
                                            }
                                            else
                                            {
                                                $array = array(
                                                    "error" => "System error (1)"
                                                );

                                            }
                                        }
                                        else
                                        {
                                            $array = array(
                                                "error" => "System error(2)"
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    $array = array(
                        "error" => "Action Post Salah"
                    );
                }
            }
            else
            {
                $array = array(
                    "error" => "Wrong action"
                );
            }
        }
        else
        {
            $array = array(
                "error" => "Invalid API key"
            );
        }
    }
}
else
{
    $array = array(
        "error" => "Incorrect request (!)"
    );
}

$print = json_encode($array);
print_r($print);

