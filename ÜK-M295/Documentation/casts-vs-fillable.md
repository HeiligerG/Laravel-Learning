In Laravel, die Unterschiede zwischen `$casts` und `$fillable` sind wie folgt:

## $fillable

Die `$fillable` Property in Laravel definiert, welche Attribute eines Models als "mass assignable" gelten. Das bedeutet, diese Attribute können sicher über Methoden wie `create()` oder `update()` mit Daten aus Benutzeranfragen befüllt werden:

```php
protected $fillable = [
    'name', 'email', 'password'
];
```

Diese Eigenschaft dient als Sicherheitsmaßnahme, um vor Mass-Assignment-Sicherheitslücken zu schützen, bei denen ein Angreifer unerwartete Felder in Anfragen einfügen könnte.

## $casts

Die `$casts` Property hingegen definiert, wie Datenbank-Attribute beim Laden aus der Datenbank in PHP-Datentypen umgewandelt werden sollen:

```php
protected $casts = [
    'is_admin' => 'boolean',
    'price' => 'float',
    'options' => 'array',
    'published_at' => 'datetime'
];
```

Mit `$casts` kannst du Datentyp-Transformationen automatisieren, sodass du die Werte direkt im richtigen Format erhältst, ohne sie manuell konvertieren zu müssen.

## Zusammenfassung der Unterschiede

- **$fillable**: Kontrolliert, welche Felder mit Massenzuweisung befüllt werden dürfen (Sicherheit)
- **$casts**: Definiert automatische Typkonvertierungen zwischen Datenbank und PHP (Bequemlichkeit)