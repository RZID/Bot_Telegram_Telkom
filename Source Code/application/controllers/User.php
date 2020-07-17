<?php
defined('BASEPATH') or exit('No direct script access allowed');
ignore_user_abort(true);

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata("status") != "log") {
            redirect("home/index");
        }
        $this->load->model("md_additional");
    }
    function index()
    {
        $data = ["dis" => $this];
        $this->load->view("user/index", $data);
    }
    function manage()
    {
        $data = ["dis" => $this];
        $this->load->view("user/manage", $data);
    }
    function pelanggan()
    {
        if (!$this->input->get("id_pelanggan")) {
            redirect("user/index");
        } else {
            if ($this->db->get_where("pelanggan_images", ["id_pelanggan" => $this->input->get("id_pelanggan")])->num_rows() < 1) {
                redirect("user/index");
            } else {
                $data = ["dis" => $this];
                $this->load->view("user/pelanggan", $data);
            }
        }
    }
    function deletephoto()
    {
        if (!$this->input->post("idphoto")) {
            redirect("user/index");
        } else {
            $foto = $this->db->get_where("tbphoto_images", ["id_tbphoto" => $this->input->post("idphoto")]);
            unlink("assets/uploaded_photo/" . $foto->row_array()["photo_tbphoto"]);
            $deleted = $this->db->delete("tbphoto_images", ["id_tbphoto" => $foto->row_array()["id_tbphoto"]]);
            if ($deleted) {
                $result = ["result" => "OK"];
            } else {
                $result = ["result" => "GAGAL"];
            }
            echo json_encode($result);
        }
    }
    function deleteevidence()
    {
        if (!$this->input->post("idpelanggan")) {
            redirect("user/index");
        } else {
            $rowfromimg = $this->db->where_in("mediagr_id", $this->md_additional->count($this->input->post("idpelanggan")))->get("tbphoto_images")->result();

            foreach ($rowfromimg as $r) {
                if (file_exists("assets/uploaded_photo/" . $r->photo_tbphoto)) {
                    unlink("assets/uploaded_photo/" . $r->photo_tbphoto);
                }
                $this->db->delete("tbphoto_images", ["id_tbphoto" => $r->id_tbphoto]);
            }

            $this->db->delete("caption_images", ["caption_cap" => $this->input->post("idpelanggan")]);
            $del = $this->db->delete("pelanggan_images", ["id_pelanggan" => $this->input->post("idpelanggan")]);

            if ($del) {
                $result = ["result" => "OK"];
            }
            echo json_encode($result);
        }
    }
    function register()
    {
        $arr = [
            "nama_user" => $this->input->post("nama"),
            "email_user" => $this->input->post("unem"),
            "pass_user" => $this->input->post("pw1"),
            "pass2_user" => $this->input->post("pw2"),
        ];
        if ($this->db->get_where("user_images", ["email_user" => $arr["email_user"]])->num_rows() > 0) {
            $result = "unem_exist";
        } else {
            if ($arr["pass_user"] != $arr["pass2_user"]) {
                $result = "pass_no_match";
            } else {
                $this->db->insert(
                    "user_images",
                    [
                        "nama_user" => $arr["nama_user"],
                        "email_user" => $arr["email_user"],
                        "pass_user" => password_hash($arr["pass_user"], PASSWORD_DEFAULT),
                    ]
                );
                $result = "ALL_OK";
            }
        }
        $resultjson = array("resulted" => $result);
        echo json_encode($resultjson);
    }
    function deluser()
    {
        $email = $this->input->post("email");
        $del = $this->db->delete("user_images", ["email_user" => $email]);
        if ($del) {
            $result = "ALL_OK";
        } else {
            $result = "error_uncaught";
        }
        $res_arr = ["log" => $result];
        echo json_encode($res_arr);
    }
}
