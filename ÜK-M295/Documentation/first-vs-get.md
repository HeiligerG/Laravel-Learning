Sehr gute Frage – der Unterschied zwischen `first()` und `get()` in Laravel ist **zentral**, und genau da liegt das Missverständnis:

---

## 🧠 **Unterschied zwischen `get()` und `first()`**

### 🔹 `get()`

* Gibt eine **Collection** zurück (also ein *Array ähnliches Objekt* mit mehreren Modellen)
* Auch wenn **nur ein Ergebnis zurückkommt**, bleibt es eine Collection

```php
$topics = Topic::where('slug', 'glueck')->with('posts')->get(); // ⛔ Collection
$topics->posts; // ❌ Error! Collection hat keine `posts`-Eigenschaft
```

---

### 🔹 `first()`

* Gibt genau **ein Eloquent Model** zurück
* Du kannst direkt auf dessen Beziehungen zugreifen

```php
$topic = Topic::where('slug', 'glueck')->with('posts')->first(); // ✅ Eloquent Model
$topic->posts; // ✅ funktioniert
```

---

## 🔧 Warum dein Fehler auftritt:

Wenn du `get()` benutzt, bekommst du z. B.:

```php
Illuminate\Database\Eloquent\Collection {
    0: App\Models\Topic {...},
    1: App\Models\Topic {...},
}
```

Diese Collection **selbst** hat keine Eigenschaft `posts`. Nur **jedes einzelne Element darin (`Topic`)** hat `->posts`.

---

## ✅ Wenn du unbedingt `get()` verwenden willst:

Du musst durchiterieren:

```php
$topics = Topic::with('posts')->where(...)->get();

foreach ($topics as $topic) {
    echo $topic->posts;
}
```

---

## ✅ Fazit

| Funktion  | Typ            | Zugriff auf `->posts`?    |
| --------- | -------------- | ------------------------- |
| `get()`   | Collection     | ❌ Nein – nur per Schleife |
| `first()` | Eloquent Model | ✅ Ja                      |

---

Möchtest du auch wissen, wie du mit Route Model Binding direkt z. B. `topics/{slug}` in einen `Topic` mit `posts` auflöst, ohne Query?
