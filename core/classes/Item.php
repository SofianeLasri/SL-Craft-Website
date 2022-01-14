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
        $query = Connexion::pdo()->prepare("SELECT * FROM site_itemsAssoc WHERE label=?");
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
}