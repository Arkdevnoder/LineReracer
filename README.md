# Draughts, or checkers, or "shashki".

This is library with PHP API.

### Features:
- [x] Got possible moves
- [x] Board positions
- [x] Game and board API
- [x] Minimax alpha-beta prunning AI
- [x] Evaluator API

### Compuser installation:
```json
{
  "repositories": [
    {
      "type": "path",
      "url": "/path/to/this/lib"
    }
  ],
  "require": {
    "arknet/linereracer": "^0.0.1"
  }
}
```

Game constructor:
```php
$game = (new Game);
```

Position setting:
```php
$game->getBoard()->getPositionCollection()->setNotation(
    "b,b,b,b,b,b,b,b,b,b,b,b,e,e,e,e,e,e,e,e,w,w,w,w,w,w,w,w,w,w,w,w"
);
```

Turn setting:
```php
$game->getTurn()->setBlack();
$game->getTurn()->setWhite();
```

Possible moves:
```php
$game->getBoard()->getPossibleMoves()->getArray();
```

Computed minimax alpha-beta prunning moves:
```php
$game->getEngine()->compute()->getResult();
```