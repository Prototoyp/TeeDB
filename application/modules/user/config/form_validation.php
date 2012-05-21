<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
                 'signup' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => 'lang:field_username',
                                            'rules' => 'not_logged_in|trim|required|allowed_name|min_length[3]|max_length[20]|unique[users.name]'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'lang:field_password',
                                            'rules' => 'required|min_length[6]|max_length[50]'
                                         ),
                                    array(
                                            'field' => 'passconf',
                                            'label' => 'lang:field_confirm_password',
                                            'rules' => 'required|matches[password]'
                                         ),
                                    array(
                                            'field' => 'email',
                                            'label' => 'lang:field_email',
                                            'rules' => 'required|valid_email|unique[users.email]'
                                         )
                                    )
            );