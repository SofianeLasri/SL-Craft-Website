<?php
class Shop{
    public static function getAllProducts(): array
    {
        // On récupère tous les items des magasins
        $itemsConfigsYaml = BddConn::getPdo()->query("SELECT itemConfig FROM qs_shops")->fetchAll(PDO::FETCH_ASSOC);
        
        /*
        item:
            ==: org.bukkit.inventory.ItemStack
            v: 2865
            type: WHEAT
        */

        // On va faire la liste de tous les items
        $items = array();
        foreach($itemsConfigsYaml as $itemConfigYaml){
            // On parse le YAML
            $itemConfig = yaml_parse($itemConfigYaml['itemConfig']);

            $alreadyInList = false;
            foreach($items as $checkItem){
                if(strtolower($itemConfig['item']['type']) == $checkItem->getType()){
                    $alreadyInList = true;
                    break; // On sort de la boucle
                }
            }
            if(!$alreadyInList){
                $items[] = new Item($itemConfig['item']['type']);
            }
        }
        return $items;
    }

    /**
     * @throws Exception
     */
    public static function getShops($search=array()): array
    {
        if(is_array($search)){
            if(empty($search)){
                // On récupère les shops
                $shops = BddConn::getPdo()->query("SELECT * FROM qs_external_cache NATURAL JOIN qs_shops")->fetchAll(PDO::FETCH_ASSOC);
                for($index=0;$index<count($shops);$index++){
                    $itemConfig = yaml_parse($shops[$index]['itemConfig']);
                    $shops[$index]['item'] = new Item($itemConfig['item']);
                    $owner = json_decode($shops[$index]['owner'], true);
                    $shops[$index]['seller'] = new Seller($owner["owner"]);
                }
                return $shops;
            }else{
                // TODO: faire une recherche par critère
                return array();
            }
        }else{
            // On lance une exception car on souhaite avoir un array
            throw new Exception("Search doit être un array");
        }
    }
}