<?php

use App\Mcp\Servers\TaskServer;
use App\Mcp\Tools\CreateTaskTool;
use App\Models\Task;

uses()->group('mcp');

test('can create a task with all fields', function () {
    $response = TaskServer::tool(CreateTaskTool::class, [
        'title' => 'Write tutorial',
        'description' => 'Complete the Laravel MCP tutorial',
        'priority' => 'high',
    ]);

    $response->assertOk();
    $response->assertSee('Write tutorial');
    $response->assertSee('high');

    expect(Task::first())
        ->title->toBe('Write tutorial')
        ->priority->toBe('high')
        ->completed->toBeFalse();
});

test('task title is required', function () {
    $response = TaskServer::tool(CreateTaskTool::class, [
        'description' => 'A task without a title',
    ]);

    $response->assertHasErrors();
});

test('invalid priority is rejected', function () {
    $response = TaskServer::tool(CreateTaskTool::class, [
        'title' => 'Test task',
        'priority' => 'super-urgent',
    ]);

    $response->assertHasErrors();
});

test('creates task with default priority when not specified', function () {
    $response = TaskServer::tool(CreateTaskTool::class, [
        'title' => 'Simple task',
    ]);

    $response->assertOk();

    expect(Task::first())
        ->priority->toBe('medium');
});
