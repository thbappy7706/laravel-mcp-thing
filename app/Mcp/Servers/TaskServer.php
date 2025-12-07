<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\CompleteTaskTool;
use App\Mcp\Tools\CreateTaskTool;
use App\Mcp\Tools\SearchTasksTool;
use Laravel\Mcp\Server;

class TaskServer extends Server
{
    /**
     * The MCP server's name.
     */
    protected string $name = 'Task Server';

    /**
     * The MCP server's version.
     */
    protected string $version = '0.0.1';

    /**
     * The MCP server's instructions for the LLM.
     */
    protected string $instructions = <<<'MARKDOWN'
        Instructions describing how to use the server and its features.
    MARKDOWN;

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Tool>>
     */
    protected array $tools = [
        CreateTaskTool::class,
        CompleteTaskTool::class,
        SearchTasksTool::class,

    ];

    /**
     * The resources registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Resource>>
     */
    protected array $resources = [
        //
    ];

    /**
     * The prompts registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Prompt>>
     */
    protected array $prompts = [
        //
    ];
}
