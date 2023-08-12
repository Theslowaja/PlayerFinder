<?php

namespace Theslowaja\findp;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;

class Loader extends PluginBase
{

    public function onEnable(): void
    {
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (strtolower($command->getName()) == "findp") {
            if ($sender->hasPermission("findp.command")) {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        if (isset($args[1])) {
                            $p =  $this->getServer()->getPlayerByPrefix($args[1]);
                            if ($p instanceof Player) {
                                $world = $p->getWorld()->getFolderName();
                                $x = $p->getPosition()->getX();
                                $y = $p->getPosition()->getY();
                                $z = $p->getPosition()->getZ();
                                switch ($args[0]) {
                                    case "tp":
                                        $p->teleport(new Position($x, $y, $z, $this->getServer()->getWorldManager()->getWorldByName($world)));
                                        $sender->sendMessage(TextFormat::GREEN . "Teleported to: $world, $x, $y, $z");
                                        break;
                                    case "find":
                                        $sender->sendMessage(TextFormat::GREEN . "Location found: $world, $x, $y, $z");
                                        break;
                                    case "world":
                                        $sender->sendMessage(TextFormat::GREEN . "World Located: $world");
                                        break;
                                    default:
                                        $sender->sendMessage(TextFormat::RED . "Commands: \n/findp tp {name}\n/findp find {player}\n/findp world {player}");
                                        break;
                                }
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Player Not Found");
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
