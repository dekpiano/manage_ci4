<?php

namespace App\Controllers;

use App\Models\Model_login;
use Google\Client;
use Google\Service\Oauth2;

class Control_login extends BaseController
{
    protected $Model_login;

    public function __construct()
    {
        $this->Model_login = new Model_login();
    }

	public static $title = "เข้าสู่ระบบ";
	public static $description = "ระบบ Login โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
 	
 	public function dataAll(){
		$data['full_url'] = current_url();
 		$data['title'] = self::$title;
		$data['description'] = self::$description; 		

		return $data;
 	}

    public function Login_main()
    {
        if (! empty(get_cookie('username_cookie')) && ! empty(get_cookie('password_cookie'))) {
            return redirect()->to('Logout');
        } else {
            $data = $this->dataAll();
            echo view('login/loginMain.php', $data);
        }
    }

    public function LoginStudent(){
        
	$data['title'] = "ระบบสารสนเทศสำหรับนักเรียน สกจ";
	$data['description'] = "สำหรับดูผลการเรียนออนไลน์ ลงทะเบียนต่าง ๆ ของโรงเรียน และ อื่น ๆ";  
	$data['full_url'] = current_url();
	$data['banner'] = base_url("uploads/academic/LoginStudent/login.PNG");

	return view('user/Login/PageLoginStudent', $data);
		
		// $this->load->view('login/loginStudent.php');
	}

    public function LoginTeacher1(){
		echo view('login/loginTeacher.php');
	}

    public function check_student()
    {	
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');
		
		
		if($this->request->getMethod() == 'post'){
			if($this->Model_login->record_count_student($username, $password) == 1)
			{
				$result = $this->Model_login->fetch_student_login($username, $password);
				session()->set(array('login_id' => $result->StudentID,'StudentCode' => $result->StudentCode,'fullname'=> $result->StudentPrefix.$result->StudentFirstName.' '.$result->StudentLastName,'status'=> 'user','class' => $result->StudentClass));

				set_cookie('username_cookie',$username,'3600'); 
				set_cookie('password_cookie',$password,'3600');

				session()->set(array('login_id' => $result->StudentID,'StudentCode' => $result->StudentCode,'fullname'=> $result->StudentPrefix.$result->StudentFirstName.' '.$result->StudentLastName,'status'=> 'user'));

				return redirect()->to('Student/Home');
				//echo "Yes";

			}
			else
			{
				session()->setFlashdata(array('status'=>'OK','messge'=> 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง','alert'=>'error'));
				// redirect('login');
				return redirect()->to('LoginStudent');
			}
		}
    }

    public function check_teacher()
    {	
			$username = $this->request->getPost('username');
			$password = md5(md5($this->request->getPost('password')));
			
			
			if($this->request->getMethod() == 'post'){
				if($this->Model_login->record_count_teacher1($username, $password) == 1)
				{

					$result = $this->Model_login->fetch_teacher_login1($username, $password);
					session()->set(array('login_id' => $result->pers_id,'pers_learning' => $result->pers_learning,'fullname'=> $result->pers_prefix.$result->pers_firstname.' '.$result->pers_lastname,'status'=> 'admin','class' => $result->StudentClass,'img' => $result->pers_img,'groupleade'=>$result->pers_groupleade,'CheckStatusPassword'=>$result->pers_changepassword));

					set_cookie('username_cookie',$username,'3600'); 
					set_cookie('password_cookie',$password,'3600');

				 return redirect()->to('Teacher/Home');
					//echo "Yes";
				}
				else
				{					
					session()->setFlashdata(array('status'=>'OK','msgerr'=> 'ชื่อผู้ใช้งานหรือรหัสผ่าน ไม่ถูกต้อง หรือ ไม่ข้อมูลในระบบ กรุณาติดต่อเจ้าหน้าที่คอม','alert'=>'error'));
					// redirect('login');
					return redirect()->to('LoginTeacher');
					//print($this->Model_login->record_count_teacher1($username, $password));
				}
			}
    }	

	    function LoginTeacherMain(){
			$data['login_button'] = ''; // This will be populated by LoginTeacher if needed
			$data['title'] = "Login สำหรับครูผู้สอน";
			$data['description'] = "Login สำหรับครูผู้สอน";  
			$data['full_url'] = current_url();
		
			return view('user/Login/PageLoginTeacher', $data);
	    }	
    function LoginTeacher(){
		include_once APPPATH . "../vendor/google_sheet/vendor/autoload.php"; // Re-added manual require
		$google_client = new Client();

		$google_client->setClientId('29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com');
		$google_client->setClientSecret('RSANANTRl84lnYm54Hi0icGa');
		$google_client->setRedirectUri(base_url('LoginTeacher'));
		$google_client->addScope('email');
		$google_client->addScope('profile');
		
		if($this->request->getGet("code")){
			$token = $google_client->fetchAccessTokenWithAuthCode($this->request->getGet("code"));
			if(!isset($token["error"])){				
				session()->set('access_token',$token['access_token']);
				$google_service = new Oauth2($google_client);
	
					$data = $google_service->userinfo->get();
					$current_datetime = date('Y-m-d H:i:s');			
	
					// echo $this->Model_login->check_login_teacher($data['email']); 
					if($this->Model_login->check_login_teacher($data['email']) == 1)
	   				 {
						$google_client->setAccessToken($token['access_token']);
						$user_data = array(				 
							'pers_username' => $data['email'],
							'updated_at' => $current_datetime,
							'login_oauth_uid' => $data['id']
						);			
					   $this->Model_login->Update_user_data($user_data, $data['email']);
	
					   $result = $this->Model_login->fetch_teacher_login($data['email']);
					   session()->set(array('login_id' => $result->pers_id,'pers_learning' => $result->pers_learning,'fullname'=> $result->pers_prefix.$result->pers_firstname.' '.$result->pers_lastname,'status'=> 'admin','img' => $result->pers_img,'groupleade'=>$result->pers_groupleade));
					  
					}else{
						session()->remove('access_token');
	
						session()->setFlashdata(array('msg'=>'OK','messge'=> 'ระบบนี้ใช้ได้แค่อีเมลโรงเรียนที่ลงทะเบียนเท่านั้น กรุณาติดต่อเจ้าหน้าที่คอม','alert'=>'error'));
					
					}
				}
			}
				
				$login_button = '';
				if(!session()->get('access_token'))
				{
				$login_button = '
				<a href="'.$google_client->createAuthUrl().'"><img src="'.base_url('assets/images/btn_google_signin.png').'" alt="Google logo"></a>
				';
				$data['login_button'] = $login_button;
				$data['title'] = "Login สำหรับครูผู้สอน";
				$data['description'] = "Login สำหรับครูผู้สอน";  
				$data['full_url'] = current_url();
				$data['banner'] = "";
	
				// $this->load->view('user/layout/HeaderUser.php',$data);
				// $this->load->view('user/Login/PageLoginTeacher.php');
				// $this->load->view('user/layout/FooterUser.php');
				
				 echo view('login/loginTeacher.php',$data);
				}else{
					return redirect()->to('Teacher/Home');
				}
			
			
		}

    public function LoginAdmin()
    {	
			$username = $this->request->getPost('username');
			$password = md5(md5($this->request->getPost('password')));
			
			
			if($this->request->getMethod() == 'post'){
				if($this->Model_login->record_count_teacher1($username, $password) == 1)
				{

					$result = $this->Model_login->fetch_teacher_login1($username, $password);
					session()->set(array('login_id' => $result->pers_id,'pers_learning' => $result->pers_learning,'fullname'=> $result->pers_prefix.$result->pers_firstname.' '.$result->pers_lastname,'status'=> $result->academic_status,'img' => $result->pers_img,'groupleade'=>$result->pers_groupleade,'CheckrloesAcademic' => $result->academic_nanetype,'CheckrloesGeneral' => $result->general_nanetype));

					set_cookie('username_cookie',$username,'3600'); 
					set_cookie('password_cookie',$password,'3600');
					//print_r($result);exit();
				 	return redirect()->to('Admin/Home');
					//echo "Yes";

				}
				else
				{					
					//session()->setFlashdata(array('status'=>'OK','msgerr'=> 'ชื่อผู้ใช้งานหรือรหัสผ่าน ไม่ถูกต้อง หรือ ไม่ข้อมูลในระบบ กรุณาติดต่อเจ้าหน้าที่คอม','alert'=>'error'));
					// redirect('login');
					return redirect()->to('welcome');
					//print($this->Model_login->record_count_teacher1($username, $password));
				}
			}
    }	


    public function logout()
    {
		
		delete_cookie('username_cookie'); 
		delete_cookie('password_cookie'); 
		session()->destroy();
		return redirect()->to('LoginStudent');
    }

    public function LogoutTeacher()
    {
		delete_cookie('username_cookie'); 
		delete_cookie('password_cookie'); 
		session()->destroy();
		return redirect()->to('welcome');
    }


    function logoutGoogle()
    {
		session()->remove('access_token');

		session()->remove('user_data');
		session()->destroy();

		return redirect()->to('welcome');
    }

	    public function LoginMenager_callback(){
		
		$path = dirname(dirname(dirname(dirname(dirname((dirname(__FILE__)))))));
		require $path . '/librarie_skj/google_sheet/vendor/autoload.php';
		
		$google_client = new Client();

		$redirect_uri = base_url('LoginMenager_callback');

		$google_client->setClientId('29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com');
		$google_client->setClientSecret('RSANANTRl84lnYm54Hi0icGa');
		$google_client->setRedirectUri($redirect_uri);
		$google_client->addScope('email');
		$google_client->addScope('profile');
		
		if($this->request->getGet("code")){
			$token = $google_client->fetchAccessTokenWithAuthCode($this->request->getGet("code"));
			if(!isset($token["error"])){				
				session()->set('access_token',$token['access_token']);
				$google_service = new Oauth2($google_client);
	
					$data = $google_service->userinfo->get();
					$current_datetime = date('Y-m-d H:i:s');			
	
					//echo $this->Model_login->check_login_teacher($data['email']); exit();
					if($this->Model_login->check_login_teacher($data['email']) >= 1)
	   				 {
						$google_client->setAccessToken($token['access_token']);
						$user_data = array(				 
							'pers_username' => $data['email'],
							'updated_at' => $current_datetime,
							'login_oauth_uid' => $data['id']
						);			
					   $this->Model_login->Update_user_data($user_data, $data['email']);
	
					   $result = $this->Model_login->fetch_teacher_login($data['email']);
					   session()->set(array('login_id' => $result->pers_id,'pers_learning' => $result->pers_learning,'fullname'=> $result->pers_prefix.$result->pers_firstname.' '.$result->pers_lastname,'status'=> $result->academic_status,'img' => $result->pers_img,'groupleade'=>$result->pers_groupleade,'CheckrloesAcademic' => $result->academic_nanetype,'CheckrloesGeneral' => $result->general_nanetype));
					   
					}else{
						session()->remove('access_token');
	
						session()->setFlashdata(array('status'=>'OK','messge'=> 'ระบบนี้ใช้ได้แค่อีเมลโรงเรียนที่ลงทะเบียนเท่านั้น<br>กรุณาติดต่อเจ้าหน้าที่คอม','alert'=>'error'));
					
					}
				}
			}
				
				$login_button = '';
				if(!session()->get('access_token'))
				{
				// header('Location: '.$google_client->createAuthUrl());
				session()->setFlashdata(array('status'=>'OK','messge'=> 'ระบบนี้ใช้ได้แค่อีเมลโรงเรียนที่ลงทะเบียนเท่านั้น<br>กรุณาติดต่อเจ้าหน้าที่คอม','alert'=>'error'));
				return redirect()->to('welcome');
				}
				else
				{			
					return redirect()->to('Admin/Home');
				}	
	    }}