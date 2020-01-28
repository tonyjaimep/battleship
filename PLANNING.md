# Arquitectura propuesta

## MVP

## User Stories
* Yo, Fulano, entro a BattleShipOnline. **(MVP)**
* Veo el promocional de la página princial.
* Creo una cuenta con un nombre de usuario único y una contraseña. **(MVP)**
* Se me muestra el dashboard.
* Se me da la opción de jugar contra una computadora para entrenar.
* Juego contra la computadora y gano N XP.
* Subo a nivel 1. **(MVP)**
* Entro al lobby.
* Se me propone un match contra Sutano, **(MVP)** que es nivel 2.
* Sutano se da cuenta que mi nivel es muy bajo para su poder y niega el juego. **(MVP)**
* Vuelvo al lobby. **(MVP)**
* Se me propone un match contra Rumano y ambos aceptamos. **(MVP)**
* Se me presenta el tablero. **(MVP)**
* // start game loop **(MVP)**
* Elijo un tipo de ataque.
* Elijo una posición de ataque y confirmo mi ataque. **(MVP)**
* Fallo, pero se marca mi ataque en el mapa.
* Es el turno de Rumano y destruye una de mis piezas.
* Es mi turno y destruyo una de las piezas de Rumano.
* Se marca mi ataque en mi minimapa.
* // exit game loop
* Gano y mi XP aumenta por N% el XP de Rumano.
* Vuelvo al dashboard.

## Clases
### Usuario
#### Atributos
* ID
* Nombre (string)
* Username (string)
* Hash (string)
* XP (unsigned int)
* En lobby desde (datetime, anulable)
* Conoce el tablero (bool)
* País (string) (opcional)

##### Computado
* Juegos ganados (basado en juegos foreign ganador)
* Nivel (basado en XP)
* Está en juego
* Está en línea

##### Métodos
* (Si está en juego) Atacar
* (Si está en juego) Abandonar
* Entrar a lobby (usuario.en_lobby_desde = now())
* Cerrar sesión -> (Si está en juego, abandonar. Eliminar sesión)

### Juego
* ID
* Creado en (datetime)
* Acabado en (datetime)
* Usuario A (big int) (foráneo, usuario)
* Usuario B (big int) (foráneo, usuario)
* Ganador (big int) (foráneo, usuario, anulable)

### Tablero
* ID
* Tamaño (unsigned) (default a 10)
* Usuario (big int) (foráneo, usuario)
* Juego (big int) (foráneo, juego)

### Pieza
* ID
* Tablero
* Posición (x, y)
* Tamaño
* Orientación

#### Computado
* Posición es válida (bool)

#### Método
* Colocar(posicion) solo si es válida.

### Ataque
* ID
* Usuario
* Objetivo (big int) (foráneo, tablero)
* Atinado (bool)
