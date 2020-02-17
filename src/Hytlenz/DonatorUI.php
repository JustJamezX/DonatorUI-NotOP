<?php

namespace Hytlenz;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;
use pocketmine\Server;

use Hytlenz\forms_by_jojoe\{SimpleForm, CustomForm};

class DonatorUI extends PluginBase implements Listener{
    
    public function onEnable(){
        $this->getLogger()->info("DonatorUI - Service Connected..");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");

    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool
    {
        switch($cmd->getName()){
        case "donator":
        if(!($sender instanceof Player)){
        	if($sender->hasPermission("donator.ui")){
                $sender->sendMessage("§7This command can't be used here. Sorry!");
                return true;
        }
    }
        $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$sender->addTitle("§bThank You", "§aFor Using.");
                        break;
                    case 1:
                    	$sender->setHealth($sender->getMaxHealth());
                    	$sender->setFood(20);
                    	$sender->sendMessage($this->getConfig()->get("cure.msg"));
                    	$sender->addTitle("§bRegenerating..", "§aHealth and Hunger filled..");
			break;
		    case 2:
		    	$sender->removeAllEffects();
		        $sender->sendMessage($this->getConfig()->get("effect.msg"));
                    	$sender->addTitle("§bCleansing..", "§aLift all effects..");
                        break;
                    case 3:
                    	$this->FlyUI($sender);
                        break;
                    case 4:
                    	$this->VanishUI($sender);
                        break;
                    case 5:
                    	$this->LightsUI($sender);
                        break;
                    case 6:
                    	$this->GmUI($sender);
                        break;
                    case 7:
                    	$this->NickMainUI($sender);
                        break;
		    case 8:
			$this->CrawlUI($sender);
			break;
		    case 9:
			$this->TimeSetUI($sender);
			break;
		    case 10:
			$this->SizeUI($sender);
			break;
            }
        });
        $form->setTitle($this->getConfig()->get("donator.title"));
        $form->setContent($this->getConfig()->get("donator.content"));
        $form->addButton("§4Exit");
        $form->addButton($this->getConfig()->get("cure.btn"), $this->getConfig()->get("cure.img-type"), $this->getConfig()->get("cure.img-url"));
	$form->addButton($this->getConfig()->get("effect.btn"), $this->getConfig()->get("effect.img-type"), $this->getConfig()->get("effect.img-url"));
        $form->addButton($this->getConfig()->get("fly.btn"), $this->getConfig()->get("fly.img-type"), $this->getConfig()->get("fly.img-url")); 
        $form->addButton($this->getConfig()->get("vanish.btn"), $this->getConfig()->get("vanish.img-type"), $this->getConfig()->get("vanish.img-url"));
        $form->addButton($this->getConfig()->get("lights.btn"), $this->getConfig()->get("lights.img-type"), $this->getConfig()->get("lights.img-url")); 
        $form->addButton($this->getConfig()->get("gm.btn"), $this->getConfig()->get("gm.img-type"), $this->getConfig()->get("gm.img-url"));
        $form->addButton($this->getConfig()->get("nick.btn"), $this->getConfig()->get("nick.img-type"), $this->getConfig()->get("nick.img-url"));
	$form->addButton($this->getConfig()->get("crawl.btn"), $this->getConfig()->get("crawl.img-type"), $this->getConfig()->get("crawl.img-url"));
	$form->addButton($this->getConfig()->get("time.btn"), $this->getConfig()->get("time.img-type"), $this->getConfig()->get("time.img-url"));
	$form->addButton($this->getConfig()->get("size.btn"), $this->getConfig()->get("size.img-type"), $this->getConfig()->get("size.img-url"));
        $form->sendToPlayer($sender);     
        }
        return true;
    }
    
     public function VanishUI($sender){
      	$form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
                        break;
                    case 1:
			$sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
			$sender->setNameTagVisible(false);
			$sender->addTitle("§bVanised", "§aOn");
                    	$sender->sendMessage($this->getConfig()->get("vanish.on"));
                        break;
                    case 2:
                    	$sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
			$sender->setNameTagVisible(true);
			$sender->addTitle("§bVanished", "§cOff");
                    	$sender->sendMessage($this->getConfig()->get("vanish.off"));
                        break;
                    	
            }
        });
        $form->setTitle($this->getConfig()->get("vanish.title"));
        $form->setContent($this->getConfig()->get("vanish.content"));
        $form->addButton("§lBack");
        $form->addButton("§l§2On");
        $form->addButton("§l§4Off");
        $form->sendToPlayer($sender);
        }
        
      public function LightsUI($sender){
      	$form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
			break;
                    case 1:
                    	$sender->addEffect(new EffectInstance(Effect::getEffect(Effect::NIGHT_VISION), 99999999, 0, false));
                    	$sender->addTitle("§bLights", "§aOn");
                    	$sender->sendMessage($this->getConfig()->get("lights.on"));
                        break;
                    case 2:
                    	$sender->removeEffect(Effect::NIGHT_VISION);
                    	$sender->addTitle("§bLights", "§cOff");
			$sender->sendMessage($this->getConfig->get("lights.off"));
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("lights.title"));
        $form->setContent($this->getConfig()->get("lights.content"));
        $form->addButton("§lBack");
        $form->addButton("§l§2On");
        $form->addButton("§l§4Off");
        $form->sendToPlayer($sender);
        }
        
      public function FlyUI($sender){
      	$form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                     	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
			break;
                    case 1:
                    	$sender->setAllowFlight(true);
                    	$sender->sendMessage($this->getConfig()->get("fly.on"));
                    	$sender->addTitle("§bFly", "§aEnabled!");
                        break;
                    case 2:
                    	$sender->setAllowFlight(false);
                    	$sender->sendMessage($this->getConfig()->get("fly.off"));
                    	$sender->addTitle("§bFly", "§cDisabled!");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("fly.title"));
        $form->setContent($this->getConfig()->get("fly.content"));
        $form->addButton("§lBack");
        $form->addButton("§l§2On");
        $form->addButton("§l§4Off");
        $form->sendToPlayer($sender);
        }
        
    public function GmUI($sender){
	$form = new CustomForm(function (Player $sender, $data){
        	if( !is_null($data)) {
                 switch($data[1]) {
                case 0:
                	$sender->setGamemode(Player::SURVIVAL);
                	$sender->addTitle("§bSurvival", "§aMode");
                	$sender->sendMessage($this->getConfig()->get("gms"));
                    	break;
                case 1:
                	$sender->setGamemode(Player::CREATIVE);
                	$sender->addTitle("§bCreative", "§aMode");
                	$sender->sendMessage($this->getConfig()->get("gmc"));
                    	break;
                case 2:
                	$sender->setGamemode(Player::SPECTATOR);
                	$sender->addTitle("§bSpectator", "§aMode");
                	$sender->sendMessage($this->getConfig()->get("gmsp"));
                    	break;
               	default:
                   	return;
            }
  }

    });
    $form->setTitle($this->getConfig()->get("gm.title"));
    $form->addLabel($this->getConfig()->get("gm.content"));
    $form->addDropdown("Gamemodes", ["Survival", "Creative", "Spectator"]);
    $form->sendToPlayer($sender);
    }
    
    public function NickMainUI($sender){
      $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
                        break;
                    case 1:
                    	$this->NickUI($sender);
                        break;
                    case 2:
                    	$sender->setDisplayName($sender->getName());
                    	$sender->setNameTag($sender->getName());
                    	$sender->sendMessage($this->getConfig()->get("nick.reset"));
                    	$sender->addTitle("§bNick", "§aReset!");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("nickmain.title"));
        $form->setContent($this->getConfig()->get("nickmain.content"));
        $form->addButton("§lBack");
        $form->addButton("§lEdit Nick");
        $form->addButton("§lReset Nick");
        $form->sendToPlayer($sender);
        }
     
    public function NickUI($sender){
	    $form = new CustomForm(function (Player $sender, $data){
                    if($data !== null){
			$sender->setDisplayName("#$data[1]");
			$sender->setNameTag("#$data[1]");
			$sender->sendMessage($this->getConfig()->get("nick.msg"));
			$sender->addTitle("§b#$data[1]","§aSet");
		}
	});
	$form->setTitle($this->getConfig()->get("nick.title"));
	$form->addLabel($this->getConfig()->get("nick.label"));
	$form->addInput("Put your nick name here:", "Nickname");
	$form->sendToPlayer($sender);
	}
		
    public function CrawlUI($sender){
      $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
                        break;
                    case 1:
                    	$sender->setCanClimbWalls(true);
                    	$sender->sendMessage($this->getConfig()->get("crawl.on"));
                    	$sender->addTitle("§bCrawl", "§aEnabled!");
                        break;
                    case 2:
                    	$sender->setCanClimbWalls(false);
                    	$sender->sendMessage($this->getConfig()->get("crawl.off"));
                    	$sender->addTitle("§bCrawl", "§cDisabled!");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("crawl.title"));
        $form->setContent($this->getConfig()->get("crawl.content"));
        $form->addButton("§lBack");
        $form->addButton("§l§2On");
        $form->addButton("§l§4Off");
        $form->sendToPlayer($sender);
       }
	
	public function TimeSetUI($sender){
	    $form = new CustomForm(function (Player $sender, $data){
              if( !is_null($data)) {
                 switch($data[1]) {
               	case 0:
                	$sender->getLevel()->setTime(0);
                	$sender->addTitle("§bDay", "§aTime");
                	$sender->sendMessage($this->getConfig()->get("time.day"));
                    	break;
                case 1:
			$sender->getLevel()->setTime(15000);
                	$sender->addTitle("§bNight", "§aTime");
                	$sender->sendMessage($this->getConfig()->get("time.night"));
                    	break;
               default:
                   return;
            }
    }

    });
    $form->setTitle($this->getConfig()->get("time.title"));
    $form->addLabel($this->getConfig()->get("time.content"));
    $form->addDropdown("Time Set", ["Day", "Night"]);
    $form->sendToPlayer($sender);
    }
	
	public function SizeUI($sender){
      	  $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
                        break;
                    case 1:
                    	$sender->setScale(0.4);
                    	$sender->sendMessage($this->getConfig()->get("size.baby"));
                    	$sender->addTitle("§bBaby", "§aSize!");
                        break;
                    case 2:
                    	$sender->setScale(0.6);
                    	$sender->sendMessage($this->getConfig()->get("size.kid"));
                    	$sender->addTitle("§bKid", "§aSize!");
                        break;
		    case 3:
                    	$sender->setScale(0.8);
                    	$sender->sendMessage($this->getConfig()->get("size.teen"));
                    	$sender->addTitle("§bTeen", "§aDisabled!");
                        break;
		    case 4:
                    	$sender->setScale(1.0);
                    	$sender->sendMessage($this->getConfig()->get("size.default"));
                    	$sender->addTitle("§bDefault", "§aSize!");
                        break;
		    case 5:
                    	$sender->setScale(1.5);
                    	$sender->sendMessage($this->getConfig()->get("size.giant"));
                    	$sender->addTitle("§bGiant", "§aSize!");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("size.title"));
        $form->setContent($this->getConfig()->get("size.content"));
        $form->addButton("§lBack");
	$form->addButton("§lBaby");
        $form->addButton("§lKid");
        $form->addButton("§lTeen");
	$form->addButton("§lDefault");
	$form->addButton("§lGiant");
        $form->sendToPlayer($sender);
       }

    public function onDisable(){
        $this->getLogger()->info("DonatorUI - Service Disconnected..");
    }
}
