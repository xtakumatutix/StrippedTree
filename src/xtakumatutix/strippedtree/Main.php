<?php

namespace xtakumatutix\strippedtree;

use pocketmine\plugin\PluginBase;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\block\BlockFactory;
use pocketmine\math\Vector3;

use pocketmine\item\Axe;

use pocketmine\player\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;

Class Main extends PluginBase implements Listener
{
    public function onEnable() :void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlace(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->getInventory()->getItemInHand() instanceof Axe){
            if ($event->getAction() == 1){
                $block = $event->getBlock();
                switch($block->getId()){
                    case 17:
                        switch($block->getMeta()){
                            case 0:
                                $this->setstripped(265, $player, $block);
                                break;
                            case 1:
                                $this->setstripped(260, $player, $block);
                                break;    
                            case 2:
                                $this->setstripped(261, $player, $block);
                                break;
                            case 3:
                                $this->setstripped(262, $player, $block);
                                break;             
                        }
                        break;
                    case 162:
                        switch($block->getMeta()){
                            case 0:
                                $this->setstripped(263, $player, $block);
                                break;
                            case 1:
                                $this->setstripped(264, $player, $block);
                                break;      
                        }
                        break;
                }
            }
        }
    }

    public function setstripped (int $id, Player $player, Block $block)
    {
        $factory = BlockFactory::getInstance();
        $tripped = $factory->get($id,0);
        $vector = $block->getPosition()->asVector3();
        $world = $player->getPosition()->getWorld();
        $this->sendSound($player);
        $world->setBlock($vector, $tripped);  
    }

    public function sendSound(Player $player) {
        $pk = new PlaySoundPacket();
        $pk->soundName = "use.wood";
        $pk->x = $player->getPosition()->x;
        $pk->y = $player->getPosition()->y;
        $pk->z = $player->getPosition()->z;
        $pk->volume = 1;
        $pk->pitch = 1;
        $player->getNetworkSession()->sendDataPacket($pk);
    }
}