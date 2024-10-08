# Draughts, or checkers, or "shashki".

This is library with PHP API.

### Features:
- [x] Got possible moves
- [x] Board positions
- [x] Game and board API
- [x] Minimax alpha-beta prunning AI
- [x] Evaluator API
- [x] History API
- [x] Draw after 30 no beat-moves
- [x] Draw after 3 retry moves

### Compuser installation:
```
composer require arknet/linereracer:dev-master
```

Game constructor:
```php
$game = (new \Arknet\LineReracer\Definition\Game);
```

Display the game in console:
```php
$game->display();
```

Position setting:
```php
$game->setNotation("white-0|b,b,b,b,b,b,b,b,b,b,b,b,e,e,e,e,e,e,e,e,w,w,w,w,w,w,w,w,w,w,w,w");
//white-0 is color of movement and moves without beats
```

Get position:
```php
$game->getNotation();
```

History notation setting:
```php
$game->setHistoryNotation($history)
```

Get history notation:
```php
$game->getHistoryNotation();
```

Possible moves:
```php
$game->getMoves();
```

Set movement:
```php
$game->setMove((int) $index);
```


Computed minimax alpha-beta prunning moves:
```php
$game->getEngineMoves();
```

License: MIT