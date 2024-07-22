<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    public function testCreate(): void
    {
        $projectName = fake()->name;

        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user)->post('/projects', [
            'name' => $projectName,
            'description' => fake()->text(100)
        ]);

        $this->assertDatabaseHas('projects', ['name' => $projectName]);
    }

    public function testUpdate(): void
    {
        $projectNewName = fake()->name;

        $project = Project::inRandomOrder()->first();
        $user = $project->user;

        $response = $this->actingAs($user)->post('/projects', [
            'name' => $projectNewName,
            'description' => fake()->text(100)
        ]);

        $this->assertDatabaseHas('projects', ['name' => $projectNewName]);
    }

    public function testDelete(): void
    {
        $project = Project::inRandomOrder()->first();
        $user = $project->user;

        $response = $this->actingAs($user)->delete(sprintf('/projects/%s', $project->id));

        $response->assertStatus(302); // Переадресация после удаления
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
