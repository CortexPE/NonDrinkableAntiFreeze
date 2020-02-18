<?php

declare(strict_types=1);

namespace CortexPE\NonDrinkableAntiFreeze;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\MoveActorAbsolutePacket;
use pocketmine\network\mcpe\protocol\MovePlayerPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {
	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/**
	 * @param PlayerMoveEvent $ev
	 *
	 * @priority HIGHEST
	 * @ignoreCancelled true
	 */
	public function onMove(PlayerMoveEvent $ev):void {
		$p = $ev->getPlayer();

		$pk = new MovePlayerPacket();
		$pk->entityRuntimeId = $p->getId();
		$pk->position = $p->getOffsetPosition($p->asVector3());
		$pk->pitch = $p->pitch;
		$pk->headYaw = $pk->yaw = $p->yaw;
		$pk->mode = MovePlayerPacket::MODE_NORMAL;
		$this->getServer()->broadcastPacket($p->getViewers(), $pk);
	}
}
