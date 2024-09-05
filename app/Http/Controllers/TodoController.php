<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Todo;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;

class TodoController extends Controller
{
    use BreadcrumbTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $openTodos = Todo::sort('desc')->open()->get();
        $completedTodos = Todo::sort('desc')->completed()->get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Todos List", "Todos", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('todos.index', compact('openTodos', 'completedTodos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Todo Create", "Todos", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoStoreRequest $request)
    {
        $todo = new Todo();

        $todo->description = $request->description;
        $todo->due_date = $request->due_date;
        $todo->status = 'open';

        $todo->save();

        return redirect()->route('todos.index')
                         ->with('success', 'New todo created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = Todo::find($id);
        if(!isset($todo) || empty($todo)) {
    		abort(404);
    	}

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Todo Edit", "Todos", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoUpdateRequest $request, string $id)
    {
        $todo = Todo::find($id);
        if(!isset($todo) || empty($todo)) {
    		abort(404);
    	}

        $todo->description = $request->description;
        $todo->due_date = $request->due_date;
        $todo->status = $request->status;

        $todo->update();

        return redirect()->route('todos.index')
                         ->with('success', 'Todo updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::find($id);
    	if(!isset($todo) || empty($todo)) {
    		abort(404);
    	}

        $todo->delete();

        return redirect()->route('todos.index')
                         ->with('success', 'Todo deleted successfully');
    }
}
