<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class); // Um sicherzustellen, dass die Datenbank für jeden Test zurückgesetzt wird

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('store creates category', function () {
    $user = User::factory()->create(); // Erstelle einen Benutzer
    $this->actingAs($user); // Simuliere die Anmeldung des Benutzers

    $data = ['name' => 'Neue Kategorie'];
    $response = $this->postJson(route('categories.store'), $data);

    $response->assertStatus(201); // Überprüfe den HTTP-Statuscode
    $response->assertJsonFragment(['name' => 'Neue Kategorie']); // Überprüfe die JSON-Antwort
    $this->assertDatabaseHas('categories', ['name' => 'Neue Kategorie']); // Überprüfe die Datenbank

    $response = $this->postJson(route('categories.store'), $data);

    dd($response->getStatusCode(), $response->json());

});


