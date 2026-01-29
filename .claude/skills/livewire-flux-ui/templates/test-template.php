<?php

use App\Livewire\[ComponentName];
use App\Models\User;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('renders successfully', function () {
    actingAs($this->user)
        ->get('/route')
        ->assertOk();
});

test('creates [model]', function () {
    Livewire::actingAs($this->user)
        ->test([ComponentName]::class)
        ->set('name', 'Test Name')
        ->set('email', 'test@example.com')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('[table_name]', [
        'name' => 'Test Name',
        'user_id' => $this->user->id,
    ]);
});

test('validates required fields', function () {
    Livewire::actingAs($this->user)
        ->test([ComponentName]::class)
        ->set('name', '')
        ->set('email', '')
        ->call('save')
        ->assertHasErrors(['name', 'email']);
});

test('name must be at least 3 characters', function () {
    Livewire::actingAs($this->user)
        ->test([ComponentName]::class)
        ->set('name', 'ab')
        ->call('save')
        ->assertHasErrors(['name']);
});
