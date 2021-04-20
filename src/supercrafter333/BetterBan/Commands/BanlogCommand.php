<?php

namespace supercrafter333\BetterBan\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use supercrafter333\BetterBan\BetterBan;

class BanlogCommand extends Command implements PluginIdentifiableCommand
{

    private $pl;

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        $this->pl = BetterBan::getInstance();
        parent::__construct("banlog", "See the ban-count of a player", "§4Usage:§r /banlog <player>", ["bancount"]);
    }

    public function execute(CommandSender $s, string $commandLabel, array $args): void
    {
        if (empty($args)) {
            $s->sendMessage($this->usageMessage);
            return;
        }
        $pl = $this->pl;
        $name = implode(" ", $args);
        $s->sendMessage(str_replace(["{name}", "{log}"], [$name, $pl->getBanLogOf($name)], $pl->getConfig()->get("banlog-message-log")));
        return;
    }

    public function getPlugin(): Plugin
    {
        return $this->pl;
    }
}