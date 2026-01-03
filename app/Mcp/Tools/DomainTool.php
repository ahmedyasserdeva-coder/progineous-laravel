<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class DomainTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        List all domains in the system.
    MARKDOWN;

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $domains = \App\Models\Domain::select('id', 'domain', 'status', 'expiry_date')
            ->limit(100)
            ->get();

        return Response::text($domains->toJson());
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\Contracts\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            //
        ];
    }
}
