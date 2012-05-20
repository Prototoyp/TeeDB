<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
$config = array(
                 'comment' => array(
                                    array(
                                            'field' => 'id',
                                            'label' => 'ID',
                                            'rules' => 'trim|required|is_natural_no_zero|exists[blog.id]'
                                         ),
                                    array(
                                            'field' => 'comment',
                                            'label' => 'lang:field_comment',
                                            'rules' => 'logged_in|trim|no_spam[comments.3]|purifier_html|required|min_length[10]|max_length[500]|nl2br|markup_parser|unique[comments.comment]'
                                         )
                                    ),
                 'news_article' => array(
                                    array(
                                            'field' => 'title',
                                            'label' => 'title',
                                            'rules' => 'trim|required|alpha_numeric|min_length[3]|max_length[255]|unique[news.title]'
                                         ),
                                    array(
                                            'field' => 'article',
                                            'label' => 'article',
                                            'rules' => 'logged_in|trim|required|min_length[10]|max_length[500]|unique[news.content]|nl2br|markup_parser'
                                         )
                                    )
            );