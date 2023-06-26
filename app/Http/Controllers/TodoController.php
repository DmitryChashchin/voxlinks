<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Todo;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Resources\TodoResource;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTodoRequest;

class TodoController extends Controller
{
    public function index(Request $request): View
    {
        $todos = Todo::where('user_id', auth()->user()->id)
            ->orderBy($request->sortBy ?? 'created_at', $request->sortOrder ?? 'desc')
            ->paginate($request->input('per_page', 15));
        return view('todos.index', [
            'todos' => $todos
        ]);
    }

    public function show(Todo $todo)
    {
        return (new TodoResource($todo))
            ->response()
            ->setStatusCode(200);
    }

    public function store(CreateTodoRequest $request, User $user)
    {
        $todo = Todo::create($request->validated());
        $user->assignTodo($todo);

        if ($request->has('logo')) {
            $path = $request->file('logo')->store('public/logos');
            $todo->image = basename($path);
        }
        $todo->save();

        return (new TodoResource($todo))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());

        if ($request->has('logo')) {
            $path = $request->file('logo')->store('public/logos');
            $todo->image = basename($path);
        }
        $todo->save();

        // Handle Tags 
        $this->handleTags($request, $todo);

        return (new TodoResource($todo))
            ->response()
            ->setStatusCode(201);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(null, 204);
    }


    public function handleTags(Request $request, Todo $todo)
    {
        /**
         * Once the article has been saved, we deal with the tag logic.
         * Grab the tag or tags from the field, sync them with the article
         */
        $tagsNames = explode(',', $request->get('tags'));

        // Create all tags (unassociet)
        foreach ($tagsNames as $tagName) {
            Tag::firstOrCreate(['name' => $tagName])->save();
        }
        // Once all tags are created we can query them
        $tags = Tag::whereIn('name', $tagsNames)->get()->pluck('id')->get();
        $todo->tags()->sync($tags);
    }
}
