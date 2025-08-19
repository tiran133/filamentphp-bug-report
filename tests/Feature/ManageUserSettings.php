<?php

use App\Filament\Pages\ManageUserSettings;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);
});

test('It validates and updates with a form', function () {
    livewire(ManageUserSettings::class)
        ->fillForm([
            'name' => 'Changed Name',
            'email' => 'changed@email.de',
        ])
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('email')
        ->call('save')
        ->assertHasNoErrors();

    expect($this->user->fresh()->name)->toBe('Changed Name')
        ->and($this->user->fresh()->email)->toBe('changed@email.de');
});
