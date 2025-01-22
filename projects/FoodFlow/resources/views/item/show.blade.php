<div>
    <h1>{{ $foodItem->name }}</h1>
    <p>Kategorie: {{ $foodItem->category->name }}</p>
    <p>Standort: {{ $foodItem->location->name }}</p>
    <p>Verfallsdatum: {{ $foodItem->expiration_date->format('d.m.Y') }}</p>
    <p>Menge: {{ $foodItem->quantity }}</p>
</div>
