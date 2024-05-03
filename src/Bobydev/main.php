<?php

namespace Bobydev;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\VanillaItems;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getLogger()->info("Bobydev plugin has been enabled");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDisable(): void {
        $this->getLogger()->info("Bobydev plugin has been disabled");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        if($cmd->getName() === "bditem"){
            if($sender instanceof Player && $sender->hasPermission("bditem.cmd")){
                $emerald = VanillaItems::EMERALD()->setCustomName("Magic Emerald");
                $sender->getInventory()->addItem($emerald);
                $sender->sendMessage("You have been given the Magic Emerald!");
            } else {
                $sender->sendMessage("You don't have permission to use this command");
            }
            return true;
        }
        return false;
    }

   public function onItemHeld(PlayerItemHeldEvent $event): void {
    $player = $event->getPlayer();
    $item = $event->getItem();
    if($item->getCustomName() === "Magic Emerald"){

        $hasteEffect = new EffectInstance(VanillaEffects::HASTE(), 20 * 60 * 20, 1, true);
        $player->getEffects()->add($hasteEffect);       
        $speedEffect = new EffectInstance(VanillaEffects::SPEED(), 20 * 60 * 20, 3, true);
        $player->getEffects()->add($speedEffect);
        $jumpBoostEffect = new EffectInstance(VanillaEffects::JUMP_BOOST(), 20 * 60 * 20, 3, true);
        $player->getEffects()->add($jumpBoostEffect);
    } else {        
        $player->getEffects()->remove(VanillaEffects::HASTE());
        $player->getEffects()->remove(VanillaEffects::SPEED());
        $player->getEffects()->remove(VanillaEffects::JUMP_BOOST());
    }
  }
}
