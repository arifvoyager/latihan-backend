<?php

class Home extends CI_Controller{
	public function index()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/home");
		$this->load->view("depan/footer");
	}

	public function program()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/program");
		$this->load->view("depan/footer");
	}

	public function kabar()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/kabar");
		$this->load->view("depan/footer");
	}


	public function khazanah()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/khazanah");
		$this->load->view("depan/footer");
	}

	public function pfi()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/pfi");
		$this->load->view("depan/footer");
	}

	public function registrasi()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/registrasi");
		$this->load->view("depan/footer");
	}

	public function login()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/login");
		$this->load->view("depan/footer");
	}

	public function acara()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/acara");
		$this->load->view("depan/footer");
	}

	public function berita()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/berita");
		$this->load->view("depan/footer");
	}

	public function keanggotaan()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/keanggotaan");
		$this->load->view("depan/footer");
	}

	public function luar()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/luar");
		$this->load->view("depan/footer");
	}

	public function sejarah()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/sejarah");
		$this->load->view("depan/footer");
	}

	public function siapakami()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/siapakami");
		$this->load->view("depan/footer");
	}

	public function tujuan()
	{
		$this->load->view("depan/header");
		$this->load->view("depan/tujuan");
		$this->load->view("depan/footer");
	}
}

