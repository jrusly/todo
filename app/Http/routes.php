<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {
    /**
     * Show Tasks
     */
    Route::get('/', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get(),
            'done' => 0
        ]);
    });

    /**
     * Show Only Done Tasks
     */
    Route::get('/done', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->where('done', '1')->get(),
            'done' => 1
        ]);
    });

    /**
     * Add New Task
     */
    Route::post('/task', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->date = $request->date;
        $task->save();

        return redirect('/');
    });

    /**
     * Edit Task
     */
    Route::post('/task/{id}', function ($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $task = Task::findOrFail($id);
        $task->name = $request->name;
        $task->date = $request->date;
        $task->done = $request->done;
        $task->save();

        return redirect('/');
    });

    /**
     * Delete Task
     */
    Route::delete('/task/{id}', function ($id) {
        Task::findOrFail($id)->delete();

        return redirect('/');
    });
});
