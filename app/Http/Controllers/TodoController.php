<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function store(Request $request)
    {
         // Validate the input
       $request->validate([
        'task_details' => 'required|string|max:255',
       ]);

        $todos = new Todo();
        $todos->user_id = auth()->user()->id;
        $todos->message = $request->task_details;
        $todos->save();
        $todos->task_datails = '';
        // Redirect to the dashboard view with all the user's todos
        return redirect()->route('dashboard');
    }

    public function dashboard()
     {
     // Fetch todos for the logged-in user
     $todos = Todo::where('user_id', auth()->user()->id)->get();
     // Return the dashboard view with todos
     return view('dashboard', ['todos' => $todos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
          // Validate the input
          $request->validate([
          'task_details' => 'required|string|max:255',
           ]);

           // Find the todo and update it
           $todo = Todo::findOrFail($id);
           $todo->message = $request->task_details;
           $todo->save();

           // Redirect back to the dashboard with a success message
           return redirect()->route('dashboard')->with('success', 'Todo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
       // Find the todo by ID and delete it
      $todo = Todo::findOrFail($id);
       $todo->delete();

       // Redirect back to the dashboard with a success message
       return redirect()->route('dashboard')->with('success', 'Todo deleted successfully.');
    }

}
