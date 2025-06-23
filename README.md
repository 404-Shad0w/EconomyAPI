---

# 💰 EconomyAPI para PocketMine-MP

**EconomyAPI** es una clase económica estática, optimizada y lista para usar en servidores **PocketMine-MP**. Permite controlar el saldo de los jugadores fácilmente desde cualquier plugin que necesite economía.

---

## 📦 Características

- ✅ API **100% estática**, sin necesidad de instancias.
- 💾 Almacenamiento automático en `economy.json` usando `Config`.
- 🔐 Validaciones automáticas para evitar errores o fraudes.
- 🔁 Transferencias seguras entre jugadores.
- 📊 Compatible con cualquier sistema de tienda, recompensas, minijuegos y más.

---

## 🛠️ Instalación

1. Coloca `EconomyAPI.php` en `src/EconomyAPI/` dentro de tu plugin.
2. Llama a `EconomyAPI::init($dataFolder);` en el `onEnable()` de tu plugin.

---

## ⚙️ Inicialización obligatoria

> Siempre llama a `init()` al iniciar tu plugin para que cargue el archivo de economía.

```php
use EconomyAPI\EconomyAPI;

public function onEnable(): void {
    EconomyAPI::init($this->getDataFolder());
}
```

---

# 🧠 Métodos disponibles

| Método                                                  | Tipo         | Descripción                                                                 |
|----------------------------------------------------------|--------------|-----------------------------------------------------------------------------|
| `init(string $dataFolder)`                              | `void`       | Inicializa la API cargando el archivo `economy.json`.                       |
| `getBalance(string $player)`                            | `float`      | Devuelve el saldo actual del jugador.                                      |
| `add(string $player, float $amount)`                    | `bool`       | Suma saldo al jugador. No permite cantidades negativas o cero.             |
| `remove(string $player, float $amount)`                 | `bool`       | Resta saldo si el jugador tiene suficiente.                                |
| `deposit(string $from, string $to, float $amount)`      | `array`      | Transfiere saldo entre jugadores. Retorna `["success" => bool, "message" => string]`. |
| `has(string $player, float $amount)`                    | `bool`       | Verifica si el jugador tiene al menos esa cantidad.                        |

---

# 💡 Ejemplo de uso

```php
use EconomyAPI\EconomyAPI;

EconomyAPI::init($this->getDataFolder());

EconomyAPI::add("Player1", 100);   // +100 a Player1
EconomyAPI::remove("Player1", 25); // -25 a Player1

$balance = EconomyAPI::getBalance("Player1"); // Devuelve 75.0

$result = EconomyAPI::deposit("Player1", "Player2", 50);

if ($result["success"]) {
    echo $result["message"]; // Has enviado 50 a Player2.
} else {
    echo "Error: " . $result["message"];
}
```

---

# 🔁 Transferencia segura (`deposit()`)

Este método realiza una transferencia segura y validada entre dos jugadores.

## Retorno del método:

```php
[
  "success" => true/false,
  "message" => "Mensaje descriptivo del resultado"
]
```

## Ejemplo:

```php
$result = EconomyAPI::deposit("PlayerA", "PlayerB", 100);

if (!$result["success"]) {
    $this->getServer()->getPlayerExact("PlayerA")?->sendMessage("❌ " . $result["message"]);
}
```

---

# ✅ Buenas prácticas

- Siempre inicializa con `init()` al arrancar tu plugin.
- Usa `has()` para validar antes de quitar o transferir dinero.
- No edites manualmente el archivo `economy.json`, usa los métodos de la API.
- Puedes combinar esta API con menús, tiendas, recompensas y mucho más.

---

# 📁 Formato del archivo `economy.json`

```json
{
  "Player1": 75.0,
  "Player2": 340.5
}
```

El archivo es creado automáticamente en la carpeta del plugin cuando se llama a `init()`.

---

# 🧪 Casos de uso recomendados

- 🛒 Tiendas con `/buy`, `/shop`
- 🎁 Recompensas por logros o eventos
- ⚔️ Minijuegos PvP con premios
- 🎰 Plugins de lotería, bancarios, o economía por rango

---

# 📜 Licencia

Este código es **open source**. Puedes usarlo, modificarlo y distribuirlo libremente. Si quieres dar crédito, ¡es bien recibido! 🎉

---