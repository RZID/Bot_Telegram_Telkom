<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		if ($this->session->userdata("status") == "log") {
			redirect("user");
		}
		$this->load->view("login");
	}
	function login()
	{
		$unem = $this->input->post("unem");
		$pass = $this->input->post("pass");
		if ($this->db->get_where("user_images", ["email_user" => $unem])->num_rows() != 1) {
			$this->session->set_flashdata("error", "<script>alert('Username yang anda masukkan tidak terdaftar')</script>");
			redirect(base_url("home/index"));
		} else {
			if (!password_verify($pass, $this->db->get_where("user_images", ["email_user" => $unem])->row_array()["pass_user"])) {
				$this->session->set_flashdata("error", "<script>alert('Password yang anda masukkan salah')</script>");
				redirect(base_url("home/index"));
			} else {
				$this->session->set_userdata(
					[
						"status" => "log",
						"unem" => $unem,
						"nama" => $this->db->get_where("user_images", ["email_user" => $unem])->row_array()["nama_user"]
					]
				);
				redirect(base_url("user/"));
			}
		}
	}
	function destroy()
	{
		$this->session->sess_destroy();
		redirect($this->index());
	}
}
