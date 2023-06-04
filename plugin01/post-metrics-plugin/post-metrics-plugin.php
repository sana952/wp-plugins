<?php
/*
  Plugin Name: Post Metrics Plugin
  Description: A plugin that shows different metrics about a post like the number of words and paragraphs and reading time.
  Version: 1.0
  Author: Datajek
*/


add_filter('the_content', 'add_metrics_to_post');

function add_metrics_to_post($content){

  if(is_single() && is_main_query())
    return '<strong>Post Metrics:</strong>
        <p>Reading time: x mins.</p>
        <p>This post has Y words and Z paragraphs.</p><br>' . $content;
  else
    return $content;
}