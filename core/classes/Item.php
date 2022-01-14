<?php
class Item{
    private $label;
    private $price;
    private $css;
    private $type;
    private $id;
    
    public function __construct($item){
        if(is_array($item)){
            $this->price = $item['price'];
            $this->id = $item['id'];
        }else{
            $this->id=$item;
        }
        $query = Connexion::pdo()->prepare("SELECT * FROM site_itemsAssoc WHERE name=?");
        $query->execute(array($this->id));
        $result= $query->fetch(PDO::FETCH_ASSOC);
        $this->label = $result['label'];
        $this->css = $result['css'];
    }
    
    public function getLabel(){
        return $this->label;
    }
    
    public function getPrice(){
        return $this->price;
    }
    
    public function getCss(){
        return $this->css;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getRepresentation(){
        $return["texture"] = array();
        if(file_exists("data/images/textures/block/".$this->id.".png")){
            $return["type"] = "block";
            $return["texture"][0] = "data/images/textures/block/".$this->id.".png";
            if(file_exists("data/images/textures/block/".$this->id."_top.png")){
                $return["texture"][1] = "data/images/textures/block/".$this->id."_top.png";
            }
        }elseif(file_exists("data/images/textures/item/".$this->id.".png")){
            $return["type"] = "item";
            $return["texture"][0] = "data/images/textures/item/".$this->id.".png";
        }else{
            $return["type"] = "unknown";
            $return["texture"][0] = "data/images/textures/missing.png";
        }

        if(!isset($return["texture"][1])){
            $return["texture"][1] = $return["texture"][0];
        }
        return $return["texture"];
    }
}