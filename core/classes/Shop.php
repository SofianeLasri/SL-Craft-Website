<?php
class Shop{
    static public getAllProducts(){
        $itemConfig = Connexion::pdo()->query("SELECT itemConfig FROM qs_shops")->fetchColumn();
        $items = yaml_parse($itemConfig);
        
        $return = array();
        foreach($items as $item){
            $itemAleadyEntered = false;
            foreach($return as $checkItem){
                if($item == $checkItem->getId()){
                    $itemAleadyEntered = true;
                }
            }
            if(!$itemAleadyEntered){
                $return[] = new Item($item);
            }
        }
        return $return;
    }
}