# Laravel Routing und Request-Objekt

## Dynamisches Routing

Durch das Angeben von Parametern in den Routen-Definitionen kann man dynamisches Routing ermöglichen. So kann man z. B. die ID eines Posts oder Kommentar-IDs als Parameter übergeben und dann je nach Wert andere Inhalte laden.

### Beispiel 1: Einfacher Parameter

```php
Route::get('/posts/{id}', function (string $id) {
    return 'Post ' . $id;
});
```

**Erklärung:**  
Aufruf unter `https://holyworkopia.test/posts/1` ergibt `Post 1`  
Aufruf unter `https://holyworkopia.test/posts/2` ergibt `Post 2`  
Ebenso funktioniert das mit beliebigen Strings, z. B. `https://holyworkopia.test/posts/brad` → `Post brad`

### Beispiel 2: Mehrere Parameter

```php
Route::get('/posts/{id}/comments/{commentid}', function (string $id, string $commentid) {
    return 'Post ' . $id . ' Comment ' . $commentid;
});
```

**Erklärung:**  
`https://holyworkopia.test/posts/3/comments/1` → `Post 3 Comment 1`

### Parameter-Validierung (Constraints)

Man kann Parameter durch reguläre Ausdrücke oder vordefinierte Methoden einschränken:

```php
Route::get('/posts/{id}', function (string $id) {
    return 'Post ' . $id;
})->where('id', '[0-9]+');
```

**Erklärung:**  
`https://holyworkopia.test/posts/100` → `Post 100` (funktioniert, da `100` numerisch ist)  
`https://holyworkopia.test/posts/brad` → `404 Not Found` (da `brad` nicht numerisch ist)

Umgekehrt kann man auch nur Buchstaben zulassen:

```php
Route::get('/posts/{id}', function (string $id) {
    return 'Post ' . $id;
})->where('id', '[a-zA-Z]+');
```

Laravel bietet auch vereinfachte Methoden:

- `->whereNumber('id')`
- `->whereAlpha('id')`

### Globale Constraints

In einer Service Provider-Datei (z. B. `RouteServiceProvider`) kann man globale Constraints definieren:

```php
use Illuminate\Support\Facades\Route;

public function boot()
{
    Route::pattern('id', '[0-9]+');
    parent::boot();
}
```

Nun sind alle `{id}`-Parameter global auf numerische Werte begrenzt, ohne dass wir in jeder Route erneut `->whereNumber('id')` angeben müssen.

---

## Das Request-Objekt

Statt alle Informationen in der Route Closure direkt aus den Parametern abzurufen, können wir das `Request`-Objekt verwenden. Dieses wird von Laravel via **Dependency Injection** in die Route Closure eingefügt.

```php
use Illuminate\Http\Request;

Route::get('/test', function (Request $request) {
    return [
        'method' => $request->method(),
    ];
});
```

Aufruf:  
`https://holyworkopia.test/test` → Gibt ein Array mit `method => "GET"` zurück.

### Weitere Request-Informationen

Man kann noch viele weitere Infos aus dem Request auslesen:

```php
Route::get('/test', function (Request $request) {
    return [
        'method'    => $request->method(),
        'url'       => $request->url(),
        'path'      => $request->path(),
        'fullUrl'   => $request->fullUrl(),
        'ip'        => $request->ip(),
        'userAgent' => $request->userAgent(),
        'header'    => $request->header(),
    ];
});
```

Beispielausgabe (gekürzt):
```json
{
    "method": "GET",
    "url": "https://holyworkopia.test/test",
    "path": "test",
    "fullUrl": "https://holyworkopia.test/test",
    "ip": "127.0.0.1",
    "userAgent": "Mozilla/5.0 ...",
    "header": {
        "host": ["holyworkopia.test"],
        "user-agent": ["Mozilla/5.0 ..."],
        ...
    }
}
```

---

## Query-Parameter

Query-Parameter können einfach mit dem Request-Objekt ausgelesen werden.

### Einzelne Query-Parameter

```php
Route::get('/users', function (Request $request) {
    return $request->query('name');
});
```

Aufruf:  
`https://holyworkopia.test/users?name=John` → Gibt "John" zurück.

### Mehrere Query-Parameter

Mit `only()` kann man einen Teil der Query-Parameter filtern:

```php
Route::get('/users', function (Request $request) {
    return $request->only(['name', 'age']);
});
```

Aufruf:  
`https://holyworkopia.test/users?name=John&age=30` →
```json
{
    "name": "John",
    "age": "30"
}
```

### Ausschließen von Parametern

Mit `except()` kann man bestimmte Keys ausschließen:

```php
Route::get('/users', function (Request $request) {
    return $request->except(['name']);
});
```

Aufruf:  
`https://holyworkopia.test/users?name=John&age=30` → Gibt nur `{"age":"30"}` zurück, da `name` ausgeschlossen wurde.

---

## Zusammenfassung

- **Dynamisches Routing:**  
  Durch `{param}` in den Routen können variable Inhalte geladen werden.

- **Parameter-Validierung:**  
  Mithilfe von `where()`, `whereNumber()`, `whereAlpha()` oder global definierten Patterns lassen sich Parameter validieren.

- **Request-Objekt:**  
  Erlaubt Zugriff auf Methoden, URLs, Headers, IP, User-Agent und Query-Parameter.

- **Query-Parameter filtern:**  
  Mit `only()` kann man bestimmte Parameter gezielt abrufen, mit `except()` kann man bestimmte Parameter ausschließen.