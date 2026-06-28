# Stimulus

Stimulus ist ein leichtgewichtiges JavaScript-Framework von Basecamp. Es verbindet HTML-Elemente mit JS-Klassen über `data-`-Attribute — ohne das DOM zu übernehmen wie React oder Vue.

## Kernidee

```html
<nav data-controller="header">
```

Sobald Stimulus dieses Element im DOM findet, erstellt es automatisch eine Instanz der `HeaderController`-Klasse und ruft `connect()` auf.

## Lifecycle-Methoden

```js
export default class extends Controller {
    connect() {
        // läuft wenn das Element ins DOM kommt
    }

    disconnect() {
        // läuft wenn das Element aus dem DOM entfernt wird
    }
}
```

## Wie Stimulus Controller findet

`bootstrap.js` scannt beim Start alle Dateien im `controllers/`-Ordner:

```
controllers/
  header_controller.js           → data-controller="header"
  hello_controller.js → data-controller="hello"
  user--profile.js    → data-controller="user--profile"
```

Dateiname = Controller-Name. Automatisch, ohne manuelle Registrierung.

## Vergleich mit Vanilla JS

```js
// Vanilla JS — globaler Scope, kein Lifecycle
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.disc-pill')...
});

// Stimulus — scoped, wiederverwendbar
export default class extends Controller {
    connect() {
        this.element.querySelectorAll('.disc-pill')...
        // this.element = nur der <nav>, nicht das ganze document
    }
}
```

## Wann Stimulus, wann Vanilla JS?

| Stimulus | Vanilla JS |
|---|---|
| Wiederverwendbare Komponenten | Einmalige Skripte |
| Mehrere Instanzen im DOM | Globale Logik |
| Dynamisch geladene Inhalte (Turbo) | Einfache Event-Handler |

In einem Symfony-Projekt ist Stimulus die Standard-Wahl, weil es von Symfony UX direkt unterstützt wird und gut mit Twig-Komponenten zusammenarbeitet.
