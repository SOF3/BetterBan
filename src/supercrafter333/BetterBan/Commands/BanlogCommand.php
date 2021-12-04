<?php

namespace supercrafter333\BetterBan\Commands;

use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use supercrafter333\BetterBan\BetterBan;
use supercrafter333\BetterBan\Forms\BBDefaultForms;

/**
 * Class BanlogCommand
 * @package supercrafter333\BetterBan\Commands
 */
class BanlogCommand extends BetterBanOwnedCommand
{

    /**
     * @var BetterBan
     */
    private $pl;

    /**
     * BanlogCommand constructor.
     * @param string $name
     * @param string $description
     * @param string|null $usageMessage
     * @param array $aliases
     */
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        $this->pl = BetterBan::getInstance();
        parent::__construct("banlog", "See the ban-count of a player", "§4Usage:§r /banlog <player>", ["bancount"]);
    }

    /**
     * @param CommandSender $s
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $s, string $commandLabel, array $args): void
    {
        if (!$this->testPermission($s)) {
            return;
        }
        if (empty($args)) {
            $s->sendMessage($this->usageMessage);
            return;
        }
        $pl = $this->pl;
        $cfg = $pl->getConfig();
        $server = $pl->getServer();
        if (!$server->getNameBans()->isBanned($args[0])) {
            $s->sendMessage(str_replace(["{name}"], [$args[0]], $cfg->get("error-not-banned")));
            return;
        }
        $pl = $this->pl;
        $name = implode(" ", $args);
        $s->sendMessage(str_replace(["{name}", "{log}"], [$name, (string)$pl->getBanLogOf($name)], $pl->getConfig()->get("banlog-message-log")));
        return;
    }

    /**
     * @return Plugin
     */
    public function getPlugin(): Plugin
    {
        return $this->pl;
    }
}