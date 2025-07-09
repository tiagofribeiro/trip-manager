<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('fluxo completo de solicitações de viagem', function () {
    // Registro
    $registerResponse = $this->postJson('/api/register', [
        'name' => 'Teste',
        'email' => 'teste@email.com',
        'password' => 'admin123',
    ]);
    $registerResponse->assertStatus(201);

    // Login
    $loginResponse = $this->postJson('/api/login', [
        'email' => 'teste@email.com',
        'password' => 'admin123',
    ]);
    $loginResponse->assertStatus(200);
    $token = $loginResponse->json('token');
    expect($token)->not->toBeEmpty();

    $headers = ['Authorization' => "Bearer $token"];

    // Criar viagens
    $trip1Response = $this->withHeaders($headers)->postJson('/api/trips', [
        'destination' => 'Bolívia',
        'departure_date' => '2025-07-01',
        'return_date' => '2025-07-05',
    ]);
    $trip1Response->assertStatus(201);

    $trip2Response = $this->withHeaders($headers)->postJson('/api/trips', [
        'destination' => 'Paraguai',
        'departure_date' => '2025-07-06',
        'return_date' => '2025-07-10',
    ]);
    $trip2Response->assertStatus(201);

    // Listar viagens
    $listResponse = $this->withHeaders($headers)->get('/api/trips');
    $listResponse->assertStatus(200);
    $trips = $listResponse->json();
    expect($trips)->toHaveCount(2);

    $trip1Id = $trips[0]['id'];
    $trip2Id = $trips[1]['id'];

    // Aprovar a primeira viagem
    $this->withHeaders($headers)->putJson("/api/trips/{$trip1Id}", [
        'status' => 'approved',
    ])->assertStatus(200);

    // Cancelar a segunda viagem
    $this->withHeaders($headers)->delete("/api/trips/{$trip2Id}")
        ->assertStatus(200);
});
