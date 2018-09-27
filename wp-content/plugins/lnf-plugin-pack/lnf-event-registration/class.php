<?php
class LnfEventRegistration{
    public function render_shortcode(){
        $slug = isset($_GET['event']) ? $_GET['event'] : null;
        
        if ($slug)
            return $this->get_form($slug);
        else
            return $this->list_events();
    }
    
    public function enqueue_scripts(){
        wp_register_style('lnf-event-registration-styles', plugins_url('lnf-plugin-pack/lnf-event-registration/style.css'));
        wp_enqueue_style('lnf-event-registration-styles');
        
        wp_register_script('lnf-event-registration-scripts', plugins_url('lnf-plugin-pack/lnf-event-registration/script.js'), array('jquery'),'1.1', true);
        wp_enqueue_script('lnf-event-registration-scripts');
    }
    
    private function list_events(){
        $events = $this->get_events($slug);
        ob_start();
        include('events.php');
        return ob_get_clean();
    }
    
    private function get_form($slug){
        $event = null;
        $fields = null;
        
        $events = $this->get_events($slug);
        
        if (count($events) > 0){
            $event = $events[0];
            $fields = json_decode($event->fields);
        }
        
        $errors = array();
        
        if ($this->is_form_submit()){
            // handle form submit
            
            // assign field values
            foreach ($fields as $f){
                if (array_key_exists($f->id, $_POST)){
                    $f->value = $_POST[$f->id];
                }
            }
            
            // check for errors
            $errors = $this->validate($fields);
            
            if (count($errors) == 0){
                $this->save_entry($event, $fields);
                return print_r($_POST, true);
            }
        }
        
        ob_start();
        include('form.php');
        return ob_get_clean();
    }
    
    private function validate($fields){
        $result = array();
        
        foreach ($fields as $f){
            if ($f->type != 'label' && $f->required && !$f->value){
                $result[] = "$f->name is required.";
            }
        }
        
        return $result;
    }
    
    private function get_events($slug = null){
        $url = LNF_EVENT_API.'/event.php';
        
        if ($slug)
            $url .= '?slug='.urlencode($slug);
        
        $response = file_get_contents($url);
        
        return json_decode($response);
    }
    
    private function save_entry($event, $fields){
        $data = $_POST;
        
        // remove unnecessary post data
        unset($data['SubmitForm']);
        
        // add slug to post data
        $data['slug'] = $event->slug;
        
        $postData = http_build_query($data);
        
        $opts = array('http' => array(
            'method'    => 'POST',
            'header'    => 'content-type: application/x-www-form-urlencoded',
            'content'   => $postData
        ));
         
        $context = stream_context_create($opts);
        
        $result = file_get_contents(LNF_EVENT_API.'/entries.php', false, $context);
    }
    
    private function is_form_submit(){
        return isset($_POST["SubmitForm"]) && $_POST['SubmitForm'] == '1';
    }
}
?>