Der Unterschied zwischen `$fillable` und `$guarded` in Laravel:

`$fillable` definiert eine Whitelist von Attributen, die mass-assignable sind - nur diese Felder können durch Methoden wie `create()` oder `update()` befüllt werden.

`$guarded` dagegen definiert eine Blacklist von Attributen, die NICHT mass-assignable sind - alle Felder AUSSER diesen können durch Massenzuweisung befüllt werden.

Diese Properties sind gegensätzlich und sollten nicht gleichzeitig im selben Model verwendet werden. Wenn `$guarded` leer ist (`protected $guarded = []`), sind alle Attribute mass-assignable, was ein Sicherheitsrisiko darstellen kann.