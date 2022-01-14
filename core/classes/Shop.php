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
                if($item['item']['type'] == $checkItem->getId()){
                    $itemAleadyEntered = true;
                }
            }
            if(!$itemAleadyEntered){
                $return[] = new Item($item['item']['type']);
            }
        }
        return $return;
    }
}