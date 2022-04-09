<?php
class Seller{
    private string $uuid;
    private string $username;
    private string $skin;

    public function __construct($uuid){
        $this->uuid = $uuid;
        $jsonProfileInfos = file_get_contents('https://sessionserver.mojang.com/session/minecraft/profile/'.$uuid);
        $profileInfos = json_decode($jsonProfileInfos, true);
        $this->username = $profileInfos['name'];

        $properties = json_decode(base64_decode($profileInfos['properties'][0]['value']), true);
        $this->skin = $properties['textures']['SKIN']['url'];
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getSkin(): string
    {
        return $this->skin;
    }
}