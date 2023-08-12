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
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (strtolower($command->getName()) == "findp") {
            if ($sender->hasPermission("findp.command")) {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        switch ($args[0]) {
                            case "tp":
                                $this->teleportToPlayer($sender, $args);
                                break;
                            case "find":
                                $this->findPlayerLocation($sender, $args);
                                break;
                            case "world":
                                $this->findPlayerWorld($sender, $args);
                                break;
                            default:
                                $sender->sendMessage(TextFormat::RED . "Commands: \n/findp tp {name}\n/findp find {player}\n/findp world {player}");
                                break;
                        }
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Commands: \n/findp tp {name}\n/findp find {player}\n/findp world {player}");
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED . "Must run in-game!");
                }
            } else {
                $sender->sendMessage(TextFormat::RED . "You do not have permissions!");
            }
        }
        return true;
    }

    private function teleportToPlayer(CommandSender $sender, array $args): void
    {
        if (isset($args[1])) {
            $player = $this->getServer()->getPlayerByPrefix($args[1]);
            if ($player instanceof Player) {
                $world = $player->getWorld()->getFolderName();
                $position = $player->getPosition();
                $sender->teleport(new Position($position->getX(), $position->getY(), $position->getZ(), $this->getServer()->getWorldManager()->getWorldByName($world)));
                $sender->sendMessage(TextFormat::GREEN . "Teleported to: $world, $position");
            } else {
                $sender->sendMessage(TextFormat::RED . "Player Not Found");
            }
        } else {
            $sender->sendMessage(TextFormat::RED . "Set a player name!");
        }
    }

    private function findPlayerLocation(CommandSender $sender, array $args): void
    {
        if (isset($args[1])) {
            $player = $this->getServer()->getPlayerByPrefix($args[1]);
            if ($player instanceof Player) {
                $position = $player->getPosition();
                $world = $player->getWorld()->getFolderName();
                $sender->sendMessage(TextFormat::GREEN . "Location found: $world, $position");
            } else {
                $sender->sendMessage(TextFormat::RED . "Player Not Found");
            }
        } else {
            $sender->sendMessage(TextFormat::RED . "Set a player name!");
        }
    }

    private function findPlayerWorld(CommandSender $sender, array $args): void
    {
        if (isset($args[1])) {
            $player = $this->getServer()->getPlayerByPrefix($args[1]);
            if ($player instanceof Player) {
                $world = $player->getWorld()->getFolderName();
                $sender->sendMessage(TextFormat::GREEN . "World Located: $world");
            } else {
                $sender->sendMessage(TextFormat::RED . "Player Not Found");
            }
        } else {
            $sender->sendMessage(TextFormat::RED . "Set a player name!");
        }
    }
}
