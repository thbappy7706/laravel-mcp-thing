<?php

namespace App\Mcp\Tools;

use App\Models\Task;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateTaskTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Creates a new task with a title, optional description, and priority level.';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        // Validate the input with clear, helpful error messages
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'priority' => ['sometimes', 'in:low,medium,high'],
        ], [
            'title.required' => 'You must provide a task title. For example: "Review Q4 report" or "Call John about project".',
            'title.max' => 'Task title is too long. Please keep it under 255 characters.',
            'description.max' => 'Task description is too long. Please keep it under 1000 characters.',
            'priority.in' => 'Priority must be one of: low, medium, or high.',
        ]);

        $task = Task::create($validated);

        return Response::text(
            "✅ Task created successfully!\n\n" .
            "**{$task->title}**\n" .
            ($task->description ? "{$task->description}\n" : '') .
            "Priority: {$task->priority}\n" .
            "ID: {$task->id}"
        );
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\Contracts\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->description('The title of the task to be created.')->required(),
            'description' => $schema->string()->description('An optional description of the task.'),
            'priority' => $schema->string()->enum(['low', 'medium', 'high'])->description('The priority level of the task (low, medium, high).')->default('medium'),

        ];

    }
}
