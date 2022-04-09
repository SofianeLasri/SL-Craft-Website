<?php
class Item{
    private string $label;
    private string $cssClassName;
    private $representation;
    private string $type;
    private string $displayName;
    private array $enchants;

    /**
     * @throws Exception
     */
    public function __construct($itemInfos){
        if(is_array($itemInfos)){
            // On va vérifier qu'il s'agit bien d'un tableau contenant les infos d'un item
            if(!isset($itemInfos["type"])){
                throw new Exception("Ce tableau n'est pas un item");
            }
            $this->type = strtolower($itemInfos['type']);

            // L'item peut avoir des caractéristiques particulières, comme des enchantements par exemple
            if(isset($itemInfos['meta'])){
                if(isset($itemInfos['meta']['display-name'])){
                    $displayNameJson = json_decode($itemInfos['meta']['display-name'], true);
                    $this->displayName = $displayNameJson['text'];
                }else{
                    $this->displayName = "";
                }
                if(isset($itemInfos['meta']['enchants'])){
                    $this->enchants = $itemInfos['meta']['enchants'];
                }else{
                    $this->enchants = [];
                }
            }else{
                $this->displayName = "";
                $this->enchants = [];
            }
        }else{
            // Ici on a un nom d'item
            $this->type=$itemInfos;
            $this->displayName = "";
            $this->enchants = [];
        }
        // On va chercher l'item dans la table d'association des items afin de récupérer les infos
        $query = BddConn::getPdo()->prepare("SELECT * FROM site_itemsAssoc WHERE name=?");
        $query->execute(array($this->type));
        $result= $query->fetch(PDO::FETCH_ASSOC);
        $this->label = $result['label'];
        $this->cssClassName = $result['css'];
        $this->representation = $result['representation'];
    }
    
    public function getLabel(): string
    {
        return $this->label;
    }
    
    public function getCssClassName(): string
    {
        return $this->cssClassName;
    }
    
    public function getType(): string
    {
        return $this->type;
    }

    public function getRepresentation(): array
    {
        $return["texture"] = array();

        // On va regarder si on a une représentation pour cet item
        // Ça sera plus rapide avec la représentation de sauvegardée
        if(isset($this->representation) && !empty($this->representation) && isset($this->representation["type"])){
            if($this->representation["type"] == "block"){
                $return["type"] = "block";
                $return["texture"][0] = "data/images/textures/block/".$this->type.".png";
                if($this->representation["hasTop"]){
                    $return["texture"][1] = "data/images/textures/block/".$this->type."_top.png";
                }else{
                    $return["texture"][1] = $return["texture"][0];
                }
            }else if($this->representation["type"] == "block_side"){
                $return["type"] = "block";
                $return["texture"][0] = "data/images/textures/block/".$this->type."_side.png";
                if($this->representation["hasTop"]){
                    $return["texture"][1] = "data/images/textures/block/".$this->type."_top.png";
                }else{
                    $return["texture"][1] = $return["texture"][0];
                }
            }else if($this->representation["type"] == "item") {
                $return["type"] = "item";
                $return["texture"][0] = "data/images/textures/item/" . $this->type . ".png";
            }else{
                $return["type"] = "unknown";
                $return["texture"][0] = "data/images/textures/missing.png";
            }
        }else{
            // Sera plus long à éxecuter vu qu'on va tout vérifier
            $representation = array();
            if(file_exists("data/images/textures/block/".$this->type.".png")){
                $return["type"] = "block";
                $representation["type"] = "block";
                $return["texture"][0] = "data/images/textures/block/".$this->type.".png";
                if(file_exists("data/images/textures/block/".$this->type."_top.png")){
                    $return["texture"][1] = "data/images/textures/block/".$this->type."_top.png";
                    $representation["hasTop"] = true;
                }else{
                    $representation["hasTop"] = false;
                }
            }elseif(file_exists("data/images/textures/block/".$this->type."_side.png")){
                $return["type"] = "block_side";
                $representation["type"] = "block";
                $return["texture"][0] = "data/images/textures/block/".$this->type."_side.png";
                if(file_exists("data/images/textures/block/".$this->type."_top.png")){
                    $return["texture"][1] = "data/images/textures/block/".$this->type."_top.png";
                    $representation["hasTop"] = true;
                }else{
                    $representation["hasTop"] = false;
                }
            }elseif(file_exists("data/images/textures/item/".$this->type.".png")){
                $return["type"] = "item";
                $representation["type"] = "item";
                $return["texture"][0] = "data/images/textures/item/".$this->type.".png";
            }else{
                $return["type"] = "unknown";
                $representation["type"] = "unknown";
                $return["texture"][0] = "data/images/textures/missing.png";
            }

            if(!isset($return["texture"][1])){
                $return["texture"][1] = $return["texture"][0];
            }

            // On va mettre à jour la représentation de l'item
            $query = BddConn::getPdo()->prepare("UPDATE site_itemsAssoc SET representation=? WHERE name=?");
            $query->execute(array(json_encode($representation), $this->type));
        }
        return $return;
    }
    public function getDisplayName(): string
    {
        return $this->displayName;
    }
    public function getEnchants(): array
    {
        return $this->enchants;
    }
}