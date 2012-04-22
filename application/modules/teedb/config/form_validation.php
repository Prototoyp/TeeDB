<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
                 'is_id' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'trim|required|is_natural_no_zero'
                                         )
                                    ),
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
                                    ),
                 'my_skin' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'skin-id',
                                            'rules' => 'trim|required|is_natural_no_zero'
                                         ),
                                    array(
                                            'field' => 'skinname',
                                            'label' => 'skinname',
                                            'rules' => 'trim|required|alpha_numeric|min_length[3]|max_length[32]|unique[teedb_skins.name]'
                                         )
                                    ),
                 'my_skin' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'skin-id',
                                            'rules' => 'trim|required|is_natural_no_zero'
                                         ),
                                    array(
                                            'field' => 'skinname',
                                            'label' => 'skinname',
                                            'rules' => 'trim|required|alpha_numeric|min_length[3]|max_length[32]|unique[teedb_skins.name]'
                                         )
                                    )
            );