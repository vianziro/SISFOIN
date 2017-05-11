<?php

class Login_model extends MY_Model
{
  public $table = 'user, level';
  
  public function getDefaultValues()
  {
    return [
      'username' => '',
      'password' => ''
    ];
  }
  
  public function getValidationRules()
  {
    $validationRules = [
      [
          'field' => 'username',
          'label' => 'Username',
          'rules' => 'trim|required'
      ],
      [
          'field' => 'password',
          'label' => 'Password',
          'rules' => 'trim|required'
      ],
    ];
    
    return $validationRules;
  }
  
  public function run($input)
  {
    $input->password = md5($input->password);
    
    $user = $this->db->where('username', $input->username)
                     ->where('password', $input->password)
                     ->where('is_blokir', 'n')
					 ->where('user.id_level = level.id_level')
                     ->limit(1)
                     ->get($this->table)
	  				 ->row();
    
    if (count($user)) {
      $data = [
          'username'        => $user->username,
          'level'           => $user->nama_level,
          'nama_user'       => $user->nama_user,
          'id_level_ruang'  => $user->id_level_ruang,
          'id_user'         => $user->id_user,
          'is_login'        => true          
      ];
      
      $this->session->set_userdata($data);
      return true;
    }
    
    return false;
  }
  
  public function logout()
  {
    $data = ['username'         => null,
             'level'            => null,
             'nama_user'        => null,
             'is_login'         => null,
             'ruang'            => null
            ];
    $this->session->unset_userdata($data);
    $this->session->sess_destroy();
  }
}