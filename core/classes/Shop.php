<?php
class Shop{
    public static function getAllProducts(){
        $itemConfig = Connexion::pdo()->query("SELECT itemConfig FROM qs_shops")->fetchColumn();
        $items = yaml_parse($itemConfig);
        print_r($items);

        /*
        item:
            ==: org.bukkit.inventory.ItemStack
            v: 2865
            type: WHEAT
        */
        
        $return = array();
        foreach($items as $item){
            $itemAleadyEntered = false;
            foreach($return as $checkItem){
                if($item->item->type == $checkItem->getId()){
                    $itemAleadyEntered = true;
                }
            }
            if(!$itemAleadyEntered){
                $return[] = new Item($item->item->type);
            }
        }
        return $return;
    }
}