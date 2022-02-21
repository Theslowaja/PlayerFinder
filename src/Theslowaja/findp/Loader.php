<?php

namespace Theslowaja\findp;


use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\world\{World,Position};
use pocketmine\utils\Config;
use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\Server;

class Main extends PluginBase implements Listener {
    
    public function onEnable() : void {
         @mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (strtolower($command->getName()) == "findp") {
            if ($sender->hasPermission("findp.command")) {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        if (isset($args[1])) {
                            if ($args[0] == "tp") {
                                $player = $args[1];
                                $world = $this->getServer()->getPlayer($player)->getWorld()->getFolderName();
                                $x = $this->getServer()->getPlayer($player)->getPosition()->getX();
                                $y = $this->getServer()->getPlayer($player)->getPosition()->getY();
                                $z = $this->getServer()->getPlayer($player)->getPosition()->getZ();
                                $this->getServer()->getPlayer($player)->teleport(new Position($x, $y, $z, $this->getServer()->getLevelByName($world)));
                                $sender->sendMessage(TextFormat::GREEN . "Teleported to: $world, $x, $y, $z");
                                return true;
                            } elseif ($args[0] == "find") {
                                $player = $args[1];
                                $world = $this->getServer()->getPlayer($player)->getWorld()->getFolderName();
                                $x = $this->getServer()->getPlayer($player)->getPosition()->getX();
                                $y = $this->getServer()->getPlayer($player)->getPosition()->getY();
                                $z = $this->getServer()->getPlayer($player)->getPosition()->getZ();
                                $sender->sendMessage(TextFormat::GREEN . "Location found: $world, $x, $y, $z");
                            } elseif ($args[0] == "world") {
                                $player = $args[1];
                                $world = $this->getServer()->getPlayer($player)->getWorld()->getFolderName();
                                $sender->sendMessage(TextFormat::GREEN . "World Located: $world");
                                } else {
                                $sender->sendMessage(TextFormat::RED . "Commands: \n/findp tp {name}\n/findp find {player}\n/findp world {player}");
                            }
                        } else {
                            $sender->sendMessage(TextFormat::RED . "Set a player name!");
                        }
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Commands: \n/findp tp {name}\n/findp find {player}\n/findp world {player}");
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED . "Must run in-game!");
                }
            } else {
                $sender->sendMessage(TextFormat::RED . "You not have permissions!");
                return false;
            }
        }
        return false;
    }
}
