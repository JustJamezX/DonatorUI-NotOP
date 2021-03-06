<?php

namespace Hytlenz;

use pocketmine\plugin\PluginBase;
use pocketmine\command\{Command, CommandSender};
use pocketmine\event\Listener;
use pocketmine\entity\{Effect, EffectInstance, Entity};
use pocketmine\{Player, Server};
use pocketmine\utils\Config;

use Hytlenz\forms_by_jojoe\{SimpleForm, CustomForm};

class DonatorUI extends PluginBase implements Listener{
    
    public function onEnable()
    {
        $this->getLogger()->info("is Enable");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
        @mkdir($this->getDataFolder());
	$this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool
    {
        switch($cmd->getName()){
        case "donator":
        if(!($sender instanceof Player)){
        	if($sender->hasPermission("donator.ui")){
                $sender->sendTitle($this->cfg->getNested("error.title"), $this->cfg->getNested("error.subtitle"));
                return true;
        }
    }
        $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
			$sender->sendTitle($this->cfg->getNested("exit.title"), $this->cfg->getNested("exit.subtitle"));
                        break;
                    case 1:
                    	$sender->setHealth($sender->getMaxHealth());
                    	$sender->setFood(20);
                    	$sender->sendMessage($this->cfg->getNested("cure.msg"));
                    	$sender->sendTitle($this->cfg->getNested("cure.title"), $this->cfg->getNested("cure.subtitle"));
			break;
		    case 2:
		    	$sender->removeAllEffects();
		        $sender->sendMessage($this->cfg->getNested("effect.msg"));
                    	$sender->sendTitle($this->cfg->getNested("effect.title"), $this->cfg->getNested("effect.subtitle"));
                        break;
                    case 3:
                    	$this->FlyUI($sender);
                        break;
                    case 4:
                    	$this->LightsUI($sender);
                        break;
                    case 5:
                    	$this->NickMainUI($sender);
                        break;
		    case 6:
			$this->CrawlUI($sender);
			break;
		    case 7:
			$this->TimeSetUI($sender);
			break;
		    case 8:
			$this->SizeUI($sender);
			break;
            }
        });
        $form->setTitle($this->cfg->getNested("donator.title"));
        $form->setContent($this->cfg->getNested("donator.content"));
        $form->addButton($this->cfg->getNested("exit.btn"), $this->cfg->getNested("exit.img-type"), $this->cfg->getNested("exit.img-url"));
        $form->addButton($this->cfg->getNested("cure.btn"), $this->cfg->getNested("cure.img-type"), $this->cfg->getNested("cure.img-url"));
	$form->addButton($this->cfg->getNested("effect.btn"), $this->cfg->getNested("effect.img-type"), $this->cfg->getNested("effect.img-url"));
        $form->addButton($this->cfg->getNested("fly.btn"), $this->cfg->getNested("fly.img-type"), $this->cfg->getNested("fly.img-url")); 
        $form->addButton($this->cfg->getNested("lights.btn"), $this->cfg->getNested("lights.img-type"), $this->cfg->getNested("lights.img-url")); 
        $form->addButton($this->cfg->getNested("nick.btn"), $this->cfg->getNested("nick.img-type"), $this->cfg->getNested("nick.img-url"));
	$form->addButton($this->cfg->getNested("crawl.btn"), $this->cfg->getNested("crawl.img-type"), $this->cfg->getNested("crawl.img-url"));
	$form->addButton($this->cfg->getNested("time.btn"), $this->cfg->getNested("time.img-type"), $this->cfg->getNested("time.img-url"));
	//Soon Capes, Wings, Particles etc.
        $form->sendToPlayer($sender);     
	
        }
        return true;
    }
    
      public function LightsUI($sender){
      	$form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$this->getServer()->getCommandMap()->dispatch($sender, "donator");
			break;
                    case 1:
                    	$sender->addEffect(new EffectInstance(Effect::getEffect(Effect::NIGHT_VISION), 99999999, 0, false));
                    	$sender->sendTitle($this->cfg->getNested("lights.title"), $this->cfg->getNested("lights.on"));
                    	$sender->sendMessage($this->cfg->getNested("lights.on"));
                        break;
                    case 2:
                    	$sender->removeEffect(Effect::NIGHT_VISION);
                    	$sender->sendTitle($this->cfg->getNested("lights.title"), $this->cfg->getNested("lights.off"));
			$sender->sendMessage($this->cfg->getNested("lights.off"));
                        break;
            }
        });
        $form->setTitle($this->cfg->getNested("lights.title-form"));
        $form->setContent($this->cfg->getNested("lights.content"));
        $form->addButton($this->cfg->getNested("ui.back.btn"), $this->cfg->getNested("ui.back.img-type"), $this->cfg->getNested("ui.back.img-url"));
        $form->addButton($this->cfg->getNested("ui.on.btn"), $this->cfg->getNested("ui.on.img-type"), $this->cfg->getNested("ui.on.img-url"));
	$form->addButton($this->cfg->getNested("ui.off.btn"), $this->cfg->getNested("ui.off.img-type"), $this->cfg->getNested("ui.off.img-url"));
        $form->sendToPlayer($sender);
        }
        
      public function FlyUI($sender){
      	$form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$this->getServer()->getCommandMap()->dispatch($sender, "donator");
			break;
                    case 1:
                    	$sender->setAllowFlight(true);
                    	$sender->sendMessage($this->cfg->getNested("fly.on"));
                    	$sender->sendTitle($this->cfg->getNested("fly.title"), $this->cfg->getNested("fly.on"));
                        break;
                    case 2:
                    	$sender->setAllowFlight(false);
                    	$sender->sendMessage($this->cfg->getNested("fly.off"));
                    	$sender->sendTitle($this->cfg->getNested("fly.title"), $this->cfg->getNested("fly.off"));
                        break;
            }
        });
        $form->setTitle($this->cfg->getNested("fly.title-form"));
        $form->setContent($this->cfg->getNested("fly.content"));
	$form->addButton($this->cfg->getNested("ui.back.btn"), $this->cfg->getNested("ui.back.img-type"), $this->cfg->getNested("ui.back.img-url"));
        $form->addButton($this->cfg->getNested("ui.on.btn"), $this->cfg->getNested("ui.on.img-type"), $this->cfg->getNested("ui.on.img-url"));
	$form->addButton($this->cfg->getNested("ui.off.btn"), $this->cfg->getNested("ui.off.img-type"), $this->cfg->getNested("ui.off.img-url"));
        $form->sendToPlayer($sender);
        }
    
    public function NickMainUI($sender){
      $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$this->getServer()->getCommandMap()->dispatch($sender, "donator");
                        break;
                    case 1:
                    	$this->NickUI($sender);
                        break;
                    case 2:
                    	$sender->setDisplayName($sender->getName());
                    	$sender->setNameTag($sender->getName());
                    	$sender->sendMessage($this->cfg->getNested("nick.reset"));
                        break;
            }
        });
        $form->setTitle($this->cfg->getNested("nickmain.title"));
        $form->setContent($this->cfg->getNested("nickmain.content"));
        $form->addButton($this->cfg->getNested("ui.back.btn"), $this->cfg->getNested("ui.back.img-type"), $this->cfg->getNested("ui.back.img-url"));
        $form->addButton($this->cfg->getNested("nickmain.edit.btn"), $this->cfg->getNested("nickmain.edit.img-type"), $this->cfg->getNested("nickmain.edit.img-url"));
        $form->addButton($this->cfg->getNested("nickmain.reset.btn"), $this->cfg->getNested("nickmain.reset.img-type"), $this->cfg->getNested("nickmain.reset.img-url"));
        $form->sendToPlayer($sender);
        }
     
    public function NickUI($sender){
	    $form = new CustomForm(function (Player $sender, $data){
                    if($data !== null){
			$sender->setDisplayName("#$data[1]");
			$sender->setNameTag("#$data[1]");
			$sender->sendMessage($this->cfg->getNested("nick.msg"));
			$sender->sendTitle("§b#$data[1]","§aSet");
		}
	});
	$form->setTitle($this->cfg->getNested("nick.title-form"));
	$form->addLabel($this->cfg->getNested("nick.label"));
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
                    	$this->getServer()->getCommandMap()->dispatch($sender, "donator");
                        break;
                    case 1:
                    	$sender->setCanClimbWalls(true);
                    	$sender->sendMessage($this->cfg->getNested("crawl.on"));
                        break;
                    case 2:
                    	$sender->setCanClimbWalls(false);
                    	$sender->sendMessage($this->cfg->getNested("crawl.off"));
                        break;
            }
        });
        $form->setTitle($this->cfg->getNested("crawl.title-form"));
        $form->setContent($this->cfg->getNested("crawl.content"));
        $form->addButton($this->cfg->getNested("ui.back.btn"), $this->cfg->getNested("ui.back.img-type"), $this->cfg->getNested("ui.back.img-url"));
        $form->addButton($this->cfg->getNested("ui.on.btn"), $this->cfg->getNested("ui.on.img-type"), $this->cfg->getNested("ui.on.img-url"));
	$form->addButton($this->cfg->getNested("ui.off.btn"), $this->cfg->getNested("ui.off.img-type"), $this->cfg->getNested("ui.off.img-url"));
        $form->sendToPlayer($sender);
       }
	
	public function TimeSetUI($sender){
	    $form = new CustomForm(function (Player $sender, $data){
              if( !is_null($data)) {
                 switch($data[1]) {
               	case 0:
                	$sender->getLevel()->setTime(0);
                	$sender->sendMessage($this->cfg->getNested("time.day"));
                    	break;
                case 1:
			$sender->getLevel()->setTime(15000);
                	$sender->sendMessage($this->cfg->getNested("time.night"));
                    	break;
               default:
                   return;
            }
    }

    });
    $form->setTitle($this->cfg->getNested("time.title"));
    $form->addLabel($this->cfg->getNested("time.content"));
    $form->addDropdown("Time Set", ["Day", "Night"]);
    $form->sendToPlayer($sender);
    }
    public function onDisable(){
        $this->getLogger()->info("is Disable");
    }
}
