<?php
if(isset($_GET['saveSettings']) && !empty($_POST)){
    foreach($_POST as $index => $value){
        if(!empty($index)){
            $query = BddConn::getPdo()->prepare('UPDATE `m_siteSetting` SET `value` = ? WHERE `name` = ?');
            $query->execute([$value, $index]);
        }
    }
}