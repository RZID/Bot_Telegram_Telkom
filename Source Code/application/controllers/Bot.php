<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("HTTP/1.1 200 OK");
set_time_limit(0);
ignore_user_abort(true);
define('BOT_TOKEN', '1310546667:AAGw8feJqAvJy-mRuWWXx9p4Yu99x39-egk');
define('BOT_UNEM', '@telecomselbot_bot');

use Jenssegers\ImageHash\Hash;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;

class Bot extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("md_additional");
    }
    function kirimTelegram($pesan, $chat_id)
    {
        $API = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendmessage?chat_id=" . $chat_id . "&text=$pesan";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $API);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function kirimFotoTelegram($pesan, $chat_id)
    {
        $API = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendphoto?chat_id=" . $chat_id . "&photo=$pesan";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $API);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function senderapi($file_id, $chatid, $groupid, $capt, $name)
    {
        $this->imageHandler($file_id, $chatid, $groupid, $capt, $name);
    }

    function get_file($file, $local_path)
    {
        $err_msg = '';
        if (!file_exists($local_path)) {
            $out = fopen($local_path, "wb");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_FILE, $out);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_URL, $file);

            curl_exec($ch);
            curl_close($ch);
        } else {
        }
        //fclose($handle); 

    }
    function imageHandler($uri, $chat_id, $mdgroup_id, $capt, $unemtele)
    {
        $my_img_jeson = 'https://api.telegram.org/bot' . BOT_TOKEN . '/getFile?file_id=' . $uri;
        $arr2json_img = file_get_contents($my_img_jeson);
        $jeson_dari_uri = json_decode($arr2json_img, true);
        $foto = $jeson_dari_uri["result"]["file_path"];
        $my_img = 'https://api.telegram.org/file/bot' . BOT_TOKEN . '/' . $foto;
        $fullpath = "assets/uploaded_photo";
        $nm = str_replace('photos/', '', $foto);
        $name = $chat_id . "_" . time() . $nm;
        if ($fullpath != "" && $fullpath) {
            $fullpath = $fullpath . "/" . $name;
        }
        $this->get_file($my_img, $fullpath);

        //Image Validation If Exist on Database (Difference Hashing With Image Hash)
        $hasher = new ImageHash(new DifferenceHash());
        $hasheeed = $hasher->hash("assets/uploaded_photo/" . $name);
        if ($res = $this->db->get_where("tbphoto_images", ['hash_tbphoto' => $hasheeed])) {
            if ($res->num_rows() > 0) {
                $this->kirimTelegram("File Yang Anda Upload Sudah Ada! Mohon masukkan file yang berbeda. File sama pada id : " . $this->db->get_where("caption_images", ["mediagr_id" => $res->row_array()["mediagr_id"]])->row_array()["caption_cap"] . "", $chat_id);
                unlink("assets/uploaded_photo/" . $name);
            } else {
                $kueri_ok = $this->db->query("select * from tbphoto_images where BIT_COUNT('$hasheeed' ^ tbphoto_images.hash_tbphoto) < 3");
                if ($kueri_ok->num_rows() >= 1) {
                    $hasheeed2 = $hasher->hash("assets/uploaded_photo/" . $kueri_ok->row_array()["photo_tbphoto"]);
                    if ($hasheeed->distance($hasheeed2) < 5) {

                        $this->kirimTelegram("File yang diupload mirip dengan id : " . $this->db->get_where("caption_images", ["mediagr_id" => $kueri_ok->row_array()["mediagr_id"]])->row_array()["caption_cap"] . "! Mohon untuk mengambil foto kembali.", $chat_id);

                        unlink("assets/uploaded_photo/" . $name);
                    } else {
                        $this->db->insert("tbphoto_images", [
                            "intcaption_tbphoto" => $unemtele,
                            "uploadtime_tbphoto" => time(),
                            "from_tbphoto" => $chat_id,
                            "photo_tbphoto" => $name,
                            "mediagr_id" => $mdgroup_id,
                            "hash_tbphoto" => $hasheeed
                        ]);
                    }
                } else {
                    $this->db->insert("tbphoto_images", [
                        "intcaption_tbphoto" => $unemtele,
                        "uploadtime_tbphoto" => time(),
                        "from_tbphoto" => $chat_id,
                        "photo_tbphoto" => $name,
                        "mediagr_id" => $mdgroup_id,
                        "hash_tbphoto" => $hasheeed
                    ]);
                }
            }
        }
    }
    public function webhook()
    {
        $update = file_get_contents('php://input');
        $update = json_decode($update, TRUE);
        if (!$update) {
            exit;
        }
        if (!array_key_exists('message', $update)) {
            if (!array_key_exists('edited_message', $update)) {
                die;
            } else {
                if (!array_key_exists('caption', $update["edited_message"])) {
                    $this->kirimTelegram("Mohon Masukkan Order ID!", $update["edited_message"]["chat"]["id"]);
                } else {
                    $this->edited_telegram($update["edited_message"], $update["edited_message"]["chat"]["id"]);
                }
            }
        } else {
            $message_data = $update["message"];
        }
        $get_input = $message_data;

        $i = count($get_input["photo"]);
        $file_id = $get_input["photo"][($i - 1)]["file_id"];

        if (!$file_id) {
            $this->kirimTelegram("Format pengiriman evidence salah! Mohon masukkan foto beserta Order ID-nya", $get_input["chat"]["id"]);
        } else {
            if ($get_input["caption"] != NULL) {
                if (!is_numeric($get_input["caption"])) {
                    $this->kirimTelegram("Format pengiriman evidence salah! Mohon masukkan foto beserta Order ID-nya", $get_input["chat"]["id"]);
                } else {
                    if (!$get_input["media_group_id"]) {
                        if ($get_input["caption"] != NULL) {
                            $caption = $get_input["caption"];
                            if ($this->db->get_where("pelanggan_images", ["id_pelanggan" => $caption])->num_rows() < 1) {
                                $this->db->insert("pelanggan_images", [
                                    "id_pelanggan" => $caption,
                                ]);
                            }
                            if ($this->db->get_where("caption_images", ["caption_cap" => $caption])->num_rows() < 1) {

                                $this->db->insert("caption_images", [
                                    "mediagr_id" => $caption,
                                    "caption_cap" => $caption
                                ]);

                                $this->kirimTelegram("Sukses upload data. Data akan tersedia pada link berikut " . base_url("user/pelanggan?id_pelanggan=") . $caption . " . Jika terjadi kesalahan maka akan diinformasikan pada balasan selanjutnya.", $get_input["chat"]["id"]);
                            } else {

                                $this->kirimTelegram("Sukses upload data. Data akan tersedia pada link berikut " . base_url("user/pelanggan?id_pelanggan=") . $caption . " . Jika terjadi kesalahan maka akan diinformasikan pada balasan selanjutnya.", $get_input["chat"]["id"]);
                            }
                            if ($update) {

                                $this->senderapi($file_id, $get_input["chat"]["id"], $caption, $caption, $get_input['chat']['username']);
                            }
                        } else {
                            $this->kirimTelegram("Masukkan Order ID!", $get_input["chat"]["id"]);
                            exit;
                        }
                    } else {
                        $caption = $get_input["caption"];
                        if ($caption) {
                            if ($this->db->get_where("pelanggan_images", ["id_pelanggan" => $caption])->num_rows() < 1) {
                                $this->db->insert("pelanggan_images", [
                                    "id_pelanggan" => $caption,
                                ]);
                            }
                        }
                        if ($this->db->get_where("caption_images", ["mediagr_id" => $get_input["media_group_id"]])->num_rows() < 1) {
                            $this->db->insert("caption_images", [
                                "mediagr_id" => $get_input["media_group_id"],
                                "caption_cap" => $caption
                            ]);

                            $this->kirimTelegram("Sukses upload data. Data akan tersedia pada link berikut " . base_url("user/pelanggan?id_pelanggan=") . $caption . " . Jika terjadi kesalahan maka akan diinformasikan pada balasan selanjutnya.", $get_input["chat"]["id"]);
                        } else {


                            $this->kirimTelegram("Sukses upload data. Data akan tersedia pada link berikut " . base_url("user/pelanggan?id_pelanggan=") . $caption . " . Jika terjadi kesalahan maka akan diinformasikan pada balasan selanjutnya.", $get_input["chat"]["id"]);
                        }
                        if ($update) {
                            $this->senderapi($file_id, $get_input["chat"]["id"], $get_input["media_group_id"], $get_input["caption"], $get_input['chat']['username']);
                        }
                    }
                }
            } else {
                if ($get_input["media_group_id"]) {
                    if ($this->db->get_where("caption_images", ["mediagr_id" => $get_input["media_group_id"]])->num_rows() < 1) {
                        $this->db->insert(
                            "noncapted_images",
                            [
                                "mediagr_id" => $get_input["media_group_id"],
                                "file_on" => $get_input["photo"][($i - 1)]["file_id"],
                                "time_noncapted" => time()
                            ]
                        );
                        $this->kirimTelegram("Mohon Masukkan Order ID!", $get_input["chat"]["id"]);
                    } else {
                        $getdasd = $this->db->get_where("caption_images", ["mediagr_id" => $get_input["media_group_id"]])->row_array()["caption_cap"];
                        $this->senderapi($file_id, $get_input["chat"]["id"], $get_input["media_group_id"], $getdasd["caption_cap"], $get_input['chat']['username']);
                    }
                } else {
                    $this->kirimTelegram("Mohon Masukkan Order ID!", $get_input["chat"]["id"]);
                }
            }
        }
    }
    public function edited_telegram($edited_msg, $chat_id)
    {
        if ($this->db->get_where("noncapted_images", ["mediagr_id" => $edited_msg["media_group_id"]])->num_rows() > 0) {

            //Isi Tabel Pelanggan
            if ($this->db->get_where("pelanggan_images", ["id_pelanggan" => $edited_msg["caption"]])->num_rows() < 1) {
                $this->db->insert("pelanggan_images", [
                    "id_pelanggan" => $edited_msg["caption"],
                ]);
            }
            //Isi Tabel Caption
            if ($this->db->get_where("caption_images", ["mediagr_id" => $this->db->get_where("noncapted_images", ["mediagr_id" => $edited_msg["media_group_id"]])->row_array()["mediagr_id"]])->num_rows() < 1) {
                $this->db->insert("caption_images", [
                    "mediagr_id" => $edited_msg["media_group_id"],
                    "caption_cap" => $edited_msg["caption"]
                ]);
                $file = $this->db->get_where("noncapted_images", ["mediagr_id" => $edited_msg["media_group_id"]]);
                $this->kirimTelegram("File Sukses Diubah pada link berikut " . base_url("user/pelanggan?id_pelanggan=") . $edited_msg["caption"] . ", Jika ada kesalahan akan dikirimkan melalu pesan berikutnya!", $chat_id);

                //Isi Tabel Photo
                foreach ($file->result() as $f) {
                    $this->senderapi($f->file_on, $chat_id, $edited_msg["media_group_id"], $edited_msg["caption"], $edited_msg['chat']['username']);
                }
            } else {
                $this->db->set(["caption_cap" => $edited_msg["caption"]]);
                $this->db->where('mediagr_id', $edited_msg["media_group_id"]);
                $this->db->update('caption_images');
            }
        } else {
            $this->kirimTelegram("Galat!", $chat_id);
        }
    }
}
