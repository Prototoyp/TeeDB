<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
$config = array(
                 'comment' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'id',
                                            'rules' => 'trim|required|is_natural_no_zero|exists[blog.id]'
                                         ),
                                    array(
                                            'field' => 'comment',
                                            'label' => 'comment text',
                                            'rules' => 'trim|required|min_length[10]|max_length[500]|unique[comments.comment]|no_spam[comments.3]|htmlspecialchars|nl2br|markup_parser'
                                         )
                                    )
            );