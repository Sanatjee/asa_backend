<?php

namespace App\Services;

use App\Ai\Agents\EducationalAssistant;
use App\Models\ProgramKB;
use Illuminate\Support\Facades\Log;

class AIService
{
    public function answer(string $question): array
    {   
        if(env('FAKE_API_RESPONSE')){
            return [
                'message' => 'A random fake response from fakemini',
                'needs_followup' => false,
            ];
        }
        $knowledge = ProgramKB::query()
            ->where('is_active', true)
            ->select('title', 'category', 'content')
            ->get();

        $context = $knowledge
            ->map(function ($item) {
                return <<<TEXT
                Title: {$item->title}
                Category: {$item->category}
                Content: {$item->content}
                TEXT;
            })
            ->implode("\n");

        $prompt = <<<PROMPT
                You are an educational assistant.Answer ONLY using the knowledge base provided below.
                Return ONLY valid JSON.
                Schema:
                {
                    "answer": "string",
                    "needs_followup": true|false
                }

                Rules:
                1. If the answer exists in the knowledge base:
                - answer = concise answer
                - needs_followup = false

                2. If the answer is NOT present OR you are unsure:
                - answer = "I don't have enough information to answer this question."
                - needs_followup = true

                Do not include markdown.
                Do not include explanation.
                Do not include any text outside JSON.

                Knowledge Base:
                {$context}

                Question:
                {$question}
                PROMPT;

        try {
            $response = (new EducationalAssistant())->prompt($prompt);
            
            $outer = json_decode($response, true);
            
            if(!isset($outer['value'])){
                return [
                    'message' => 'Sorry, something went wrong while processing your request.',
                    'needs_followup' => true,
                ];
            }
            $decoded = json_decode($outer['value'], true);

            if (
                json_last_error() !== JSON_ERROR_NONE ||
                !isset($decoded['answer']) ||
                !isset($decoded['needs_followup'])
            ) {
                return [
                    'message' => 'Sorry, something went wrong while processing your request.',
                    'needs_followup' => true,
                ];
            }

            return [
                'message' => $decoded['answer'],
                'needs_followup' => (bool) $decoded['needs_followup'],
            ];
        } catch (\Throwable $e) {

            Log::error('AI Error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'message' => 'Sorry, something went wrong while processing your request.',
                'needs_followup' => true,
            ];
        }
    }
}
