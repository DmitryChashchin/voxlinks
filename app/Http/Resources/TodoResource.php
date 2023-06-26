<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attributes' => [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'id' => $this->user->id
                    ]
                ]

            ],
            'links' => [
                'self' => route('todo.show', $this->id)
            ]
        ];
    }
    public function with(Request $request)
    {
        return [
            'status' => 'succes',
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->header('Accept', 'application/json');
        $response->header('Version', 'v1');
    }
}
