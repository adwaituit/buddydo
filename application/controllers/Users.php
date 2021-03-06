<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends BaseController {

	public function __construct(){
		parent::__construct();
		$this->load->model('users_model');
	}

	private $module_name = 'user'; // Sigular
	private $module_name_p = 'users'; // Plural

	public function index(){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-admin') ){
			show_404();
		}
		$data["header"] = $this->makeHeader('users_list');
		$data["assets"] = $this->getAssets('users_list');
		$data['title'] = ucfirst($this->module_name_p);
		$data['dtUrl'] = base_url('users/getusers');
		$this->loadview("admin/$this->module_name_p/list", $data);
	}

	public function add(){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-admin') ){
			show_404();
		}
		$data["header"] = $this->makeHeader('users_add');
		$data["assets"] = $this->getAssets('users_add');
		$data['title'] = "Add " . ucfirst($this->module_name);
		$data['url'] = base_url("$this->module_name_p/save");
		$data['submitButtonText'] = "Add";
		$this->loadview("admin/$this->module_name_p/form", $data);
	}

	public function edit( $publicId = null ){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-admin') ){
			show_404();
		}
		$data["header"] = $this->makeHeader('users_edit');
		$data["assets"] = $this->getAssets('users_edit');
		$data['title'] = "Edit " . ucfirst($this->module_name);
		$data['url'] = base_url("$this->module_name_p/save/$publicId");
		$data['user'] = $this->users_model->getuser( $publicId );
		$data['submitButtonText'] = "Save";
		$data['publicId'] = $publicId;
		$this->loadview("admin/$this->module_name_p/form", $data);
	}

	public function save( $publicId = null ){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-admin') ){
			show_404();
		}
		$this->users_model->save($publicId);
	}

	public function getusers(){
		if( !$this->uauth->isloggedin() ){
			redirect('app');
		}
		if( !$this->uauth->haspermission('is-admin') ){
			show_404();
		}
		$this->users_model->getusersForDatatable();
	}

}
