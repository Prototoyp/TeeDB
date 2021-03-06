<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
                 'is_id' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'trim|required|is_natural_no_zero'
                                         )
                                    ),
                 'rate_skin' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'logged_in|trim|required|is_natural_no_zero|exist[teedb_skins.id]'
                                         ),
                                    array(
                                            'field' => 'rate',
                                            'label' => 'rate',
                                            'rules' => 'trim|required|is_natural|less_than[2]'
                                         )
                                    ),
                 'rate_map' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'logged_in|trim|required|is_natural_no_zero|exist[teedb_maps.id]'
                                         ),
                                    array(
                                            'field' => 'rate',
                                            'label' => 'rate',
                                            'rules' => 'trim|required|is_natural|less_than[2]'
                                         )
                                    ),
                 'rate_mod' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'logged_in|trim|required|is_natural_no_zero|exist[teedb_mods.id]'
                                         ),
                                    array(
                                            'field' => 'rate',
                                            'label' => 'rate',
                                            'rules' => 'trim|required|is_natural|less_than[2]'
                                         )
                                    ),
                 'rate_demo' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'logged_in|trim|required|is_natural_no_zero|exist[teedb_demos.id]'
                                         ),
                                    array(
                                            'field' => 'rate',
                                            'label' => 'rate',
                                            'rules' => 'trim|required|is_natural|less_than[2]'
                                         )
                                    ),
                 'rate_mapres' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'logged_in|trim|required|is_natural_no_zero|exist[teedb_mapres.id]'
                                         ),
                                    array(
                                            'field' => 'rate',
                                            'label' => 'rate',
                                            'rules' => 'trim|required|is_natural|less_than[2]'
                                         )
                                    ),
                 'rate_gameskin' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'logged_in|trim|required|is_natural_no_zero|exist[teedb_gameskins.id]'
                                         ),
                                    array(
                                            'field' => 'rate',
                                            'label' => 'rate',
                                            'rules' => 'trim|required|is_natural|less_than[2]'
                                         )
                                    ),
                 'mod' => array(
                                    array(
                                            'field' => 'modname',
                                            'label' => 'modname',
                                            'rules' => 'required|alpha_dash|min_length[3]|max_length[20]|unique[teedb_mods.name]'
                                         ),
                                    array(
                                            'field' => 'link',
                                            'label' => 'link',
                                            'rules' => 'trim|required|prep_url|valid_url|min_length[6]|max_length[256]'
                                         )
                                    ),
                 'mod_name' => array(
                                    array(
                                            'field' => 'modname',
                                            'label' => 'modname',
                                            'rules' => 'required|alpha_dash|min_length[3]|max_length[20]|unique[teedb_mods.name]'
                                         )
                                    ),
                 'mod_link' => array(
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
                                            'rules' => 'trim|required|alpha_dash|min_length[3]|max_length[32]|unique[teedb_skins.name]'
                                         )
                                    ),
                 'my_gameskin' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'gameskin-id',
                                            'rules' => 'trim|required|is_natural_no_zero'
                                         ),
                                    array(
                                            'field' => 'gameskinname',
                                            'label' => 'gameskinname',
                                            'rules' => 'trim|required|alpha_dash|min_length[3]|max_length[32]|unique[teedb_gameskins.name]'
                                         )
                                    ),
                 'my_mapres' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'mapres-id',
                                            'rules' => 'trim|required|is_natural_no_zero'
                                         ),
                                    array(
                                            'field' => 'mapresname',
                                            'label' => 'mapresname',
                                            'rules' => 'trim|required|alpha_dash|min_length[3]|max_length[32]|unique[teedb_mapres.name]'
                                         )
                                    ),
                 'my_demos' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'demo-id',
                                            'rules' => 'trim|required|is_natural_no_zero'
                                         ),
                                    array(
                                            'field' => 'demoname',
                                            'label' => 'demoname',
                                            'rules' => 'trim|required|alpha_dash|min_length[3]|max_length[32]|unique[teedb_demos.name]'
                                         )
                                    ),
                 'my_maps' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'map-id',
                                            'rules' => 'trim|required|is_natural_no_zero'
                                         ),
                                    array(
                                            'field' => 'mapname',
                                            'label' => 'mapname',
                                            'rules' => 'trim|required|alpha_dash|min_length[3]|max_length[32]|unique[teedb_maps.name]'
                                         )
                                    )
            );