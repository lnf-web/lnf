<?php
define('LNF_EVENT_API', 'https://lnf.umich.edu/data/registration/api');
require_once('class.php');

$lnf_event_registration = new LnfEventRegistration();

add_action('wp_enqueue_scripts', array($lnf_event_registration, 'enqueue_scripts'));
add_shortcode('lnf_event_registration', array($lnf_event_registration, 'render_shortcode'));
?>