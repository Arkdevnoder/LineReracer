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
composer require arknet/linereracer
```

Game constructor:
```php
$game = (new \Arknet\LineReracer\Definition\Game);
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