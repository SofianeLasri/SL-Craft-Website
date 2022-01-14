<?php
class Shop{
    public static function getAllProducts(){
        $itemsConfig = Connexion::pdo()->query("SELECT itemConfig FROM qs_shops")->fetchAll(PDO::FETCH_ASSOC);
        
        /*
        item:
            ==: org.bukkit.inventory.ItemStack
            v: 2865
            type: WHEAT
        */
        
        $return = array();
        foreach($itemsConfig as $itemConfig){
            $item = yaml_parse($itemConfig['itemConfig']);

            $itemAleadyEntered = false;
            foreach($return as $checkItem){
                if(strtolower($item['item']['type']) == $checkItem->getId()){
                    $itemAleadyEntered = true;
                }
            }
            if(!$itemAleadyEntered){
                $return[] = new Item($item['item']['type']);
            }
        }
        return $return;
    }
    public static function getShops($search=null){
        if(is_array($search)){

        }else{
            // On récupère les shops
            $shops = Connexion::pdo()->query("SELECT * FROM qs_external_cache NATURAL JOIN qs_shops")->fetchAll(PDO::FETCH_ASSOC);
            for($i=0;$i<count($shops);$i++){
                $item = yaml_parse($shops[$i]['itemConfig']);
                $shops[$i]['item'] = new Item($item['item']['type'])
            }
            return $shops;
        }
    }
}