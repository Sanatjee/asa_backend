<?php

namespace App\Services;

use App\Ai\Agents\EducationalAssistant;
use App\Models\ProgramKB;
use Illuminate\Support\Facades\Log;

class AIService
{
    public function answer(string $question): array
    {
        if (env('FAKE_API_RESPONSE')) {
            return [
                'message' => 'A random fake response from fakemini',
                'needs_followup' => false,
                'category' => null,
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

        $prompt = $prompt = <<<PROMPT
You are an educational assistant. Answer ONLY using the knowledge base provided below.
Return ONLY valid JSON.

Schema:
{
    "answer": "string",
    "category": "string|null",
    "needs_followup": true|false,
    "is_resolved": true|false
}

Rules:

1. If the user's current message is an affirmative response to the question "Is your query resolved?" (examples: "yes", "yes it is", "resolved", "thank you", "thanks", "it worked", "that solved my issue", "issue resolved", or any other clear affirmative confirmation):
- answer = "I'm glad I could help. Your query has been marked as resolved."
- category = null
- needs_followup = false
- is_resolved = true

2. If the answer to the user's question exists in the knowledge base:
- answer = Provide a concise and accurate answer using ONLY the knowledge base.
- At the end of the answer, append:
  "Is your query resolved? Please reply Yes or No."
- category = the exact category of the knowledge base entry from which the answer was obtained.
- needs_followup = false
- is_resolved = false

3. If the answer is NOT present in the knowledge base OR you are unsure:
- answer = "I don't have enough information to answer this question. Your query has been forwarded to our support team."
- category = null
- needs_followup = true
- is_resolved = false

Additional Rules:
- Use ONLY the information available in the knowledge base.
- Never invent or assume information.
- Never invent or infer a category.
- The category must exactly match the category of the knowledge base entry used to answer the question.
- Return ONLY valid JSON.
- Do not include markdown.
- Do not include explanations.
- Do not include any text outside the JSON object.

Knowledge Base:
{$context}

Question:
{$question}
PROMPT;

        try {
            $response = (new EducationalAssistant())->prompt($prompt);

            $outer = json_decode($response, true);

            logger()->error('AI Error', [
                'AI ANS' => $outer,
            ]);

            if (!isset($outer['value'])) {
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
                'category' => (bool) isset($decoded['category']) ? $decoded['category'] : null,
                'is_resolved' => (bool) isset($decoded['is_resolved']) ? $decoded['is_resolved'] : null,
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
