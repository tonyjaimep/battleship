# Arquitectura propuesta
## User Stories
* Yo, Fulano, entro a BattleShipOnline.
* Veo el promocional de la página princial.
* Creo una cuenta con un nombre de usuario único y una contraseña.
* Se me muestra el dashboard.
* Se me da la opción de jugar contra una computadora para entrenar.
* Juego contra la computadora y gano N XP.
* Subo a nivel 1.
* Entro al lobby.
* Se me propone un match contra Sutano, que es nivel 2.
* Sutano se da cuenta que mi nivel es muy bajo para su poder y niega el juego.
* Vuelvo al lobby.
* Se me propone un match contra Rumano y ambos aceptamos.
* Se me presenta el tablero.
* // start game loop
* Elijo una posición de ataque y confirmo mi ataque.
* Fallo, pero se marca mi ataque en el mapa.
* Es el turno de Rumano y destruye una de mis piezas.
* Es mi turno y destruyo una de las piezas de Rumano.
* Se marca mi ataque en mi minimapa.
* // exit game loop
* Gano y mi XP aumenta por N% el XP de Rumano.
* Vuelvo al dashboard.

## Clases
### Usuario
* ID
* Nombre (string)
* Username (string)
* Hash (string)
* XP (unsigned int)
* En lobby desde (datetime, anulable)
* Conoce el tablero (bool)

### Juego
* ID
* Creado en (datetime)
* Acabado en (datetime)
* Usuario A (big int) (foráneo, usuario)
* Usuario B (big int) (foráneo, usuario)
* Ganador (big int) (foráneo, usuario)

### Tablero
* ID
* Usuario (big int) (foráneo, usuario)
* Juego (big int) (foráneo, juego)

### Pieza
* ID
* Tablero
* Posición (x, y)
* Tamaño
* Orientación

### Ataque
* ID
* Usuario
* Objetivo (big int) (foráneo, tablero)
* Atinado (bool)
