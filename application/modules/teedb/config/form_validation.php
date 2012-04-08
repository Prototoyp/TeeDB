<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
                 'mod' => array(
                                    array(
                                            'field' => 'modname',
                                            'label' => 'modname',
                                            'rules' => 'required|alpha_numeric|min_length[3]|max_length[20]|unique[teedb_mods.name]'
                                         ),
                                    array(
                                            'field' => 'link',
                                            'label' => 'link',
                                            'rules' => 'trim|required|prep_url|valid_url|min_length[6]|max_length[256]'
                                         )
                                    )
            );