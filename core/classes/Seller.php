<?php
class Seller{
    private $uuid;
    private $username;
    private $skin;

    public function __construct($uuid){
        $this->uuid = $uuid;
        $json = file_get_contents('https://sessionserver.mojang.com/session/minecraft/profile/'.$uuid);
        $profile = json_decode($json, true);
        $this->username = $profile['name'];

        $properties = json_decode(base64_decode($profile['properties'][0]['value']), true);
        $this->skin = $properties['textures']['SKIN']['url'];
    }

    public function getUuid(){
        return $this->uuid;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getSkin(){
        return $this->skin;
    }
}