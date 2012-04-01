<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
                 'signup' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => 'username',
                                            'rules' => 'not_logged_in|trim|required|alpha_numeric|min_length[3]|max_length[20]|unique[users.name]'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'required|min_length[6]|max_length[50]'
                                         ),
                                    array(
                                            'field' => 'passconf',
                                            'label' => 'confirm password',
                                            'rules' => 'required|matches[password]'
                                         ),
                                    array(
                                            'field' => 'email',
                                            'label' => 'email',
                                            'rules' => 'required|valid_email|unique[users.email]'
                                         )
                                    )
            );