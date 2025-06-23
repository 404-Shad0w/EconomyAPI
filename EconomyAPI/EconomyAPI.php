<?php

namespace EconomyAPI;

use pocketmine\utils\Config;

class EconomyAPI
{
    private static ?Config $config = null;

    public static function init(string $dataFolder): void
    {
        if (self::$config !== null) return;

        self::$config = new Config($dataFolder . "economy.json", Config::JSON, []);
    }

    private static function checkInit(): void
    {
        if (self::$config === null) {
            trigger_error("EconomyAPI no inicializada. Ejecuta EconomyAPI::init() antes.", E_USER_WARNING);
        }
    }

    public static function getBalance(string $playerName): float
    {
        self::checkInit();
        return self::$config->get($playerName, 0.0);
    }

    public static function add(string $playerName, float $amount): bool
    {
        self::checkInit();
        if ($amount <= 0) return false;

        $current = self::getBalance($playerName);
        self::$config->set($playerName, $current + $amount);
        self::$config->save();

        return true;
    }

    public static function remove(string $playerName, float $amount): bool
    {
        self::checkInit();
        if ($amount <= 0) return false;

        $current = self::getBalance($playerName);
        if ($current < $amount) return false;

        self::$config->set($playerName, $current - $amount);
        self::$config->save();

        return true;
    }

    /**
     * Transfiere saldo de un jugador a otro.
     * Retorna un array con 'success' y 'message'.
     */
    public static function deposit(string $sender, string $receiver, float $amount): array
    {
        self::checkInit();

        if ($amount <= 0) {
            return ['success' => false, 'message' => 'Cantidad inválida.'];
        }

        $senderBalance = self::getBalance($sender);
        if ($senderBalance < $amount) {
            return ['success' => false, 'message' => 'No tienes suficiente saldo para transferir.'];
        }

        self::remove($sender, $amount);
        self::add($receiver, $amount);

        return ['success' => true, 'message' => "Has enviado $amount a $receiver."];
    }
}