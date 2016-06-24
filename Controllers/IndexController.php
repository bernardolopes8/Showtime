<?php

class IndexController {
    public static function process($msg) {
        if (isset($_POST['update-index'])) {
            $msg = self::processUpdate($msg); 
        }
        return $msg;
    }
    
    public static function processUpdate($msg) {
        $new_featured = Array($_POST['featured1'], $_POST['featured2'], $_POST['featured3'], $_POST['featured4']);
        $new_top = Array($_POST['top1'], $_POST['top2'], $_POST['top3']);
        $new_soon = Array($_POST['soon1'], $_POST['soon2'], $_POST['soon3']);
        
        $indexContent = "index.json";
        if (!file_exists($indexContent)) {
            $msg['error'][] = "JSON file doesn't exist";
            return $msg;
        }
        
        $json_data = json_decode(file_get_contents($indexContent), true);
        
        $json_data['featured'] = $new_featured;
        $json_data['top'] = $new_top;
        $json_data['soon'] = $new_soon;
        
        if(file_put_contents($indexContent, json_encode($json_data))) {
            $msg['info'][] = "Succesfully updated content";
        }
        else {
            $msg['error'][] = "Error updating content";
        }
        
        if (!empty($_FILES['featured1-img']['name'])) {$msg = Controller::processImgUpload($msg, 'featured1-img', "img/featured/1.jpg");}
        if (!empty($_FILES['featured2-img']['name'])) {$msg = Controller::processImgUpload($msg, 'featured2-img', "img/featured/2.jpg");}
        if (!empty($_FILES['featured3-img']['name'])) {$msg = Controller::processImgUpload($msg, 'featured3-img', "img/featured/3.jpg");}
        if (!empty($_FILES['featured4-img']['name'])) {$msg = Controller::processImgUpload($msg, 'featured4-img', "img/featured/4.jpg");}
        
        return $msg;
    }
    
    public static function getData() {
        $msg = array();
        $indexContent = "index.json";
        
        if (!file_exists($indexContent)) {
            $msg['error'][] = "JSON file doesn't exist";
            return $msg;
        }
        
        $json_data = json_decode(file_get_contents($indexContent), true);
        
        return $json_data;
    }
}

