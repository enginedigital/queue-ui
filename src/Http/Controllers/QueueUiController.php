<?php

namespace EngineDigital\QueueUi\Http\Controllers;

use EngineDigital\QueueUi\Http\Requests\RunRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class QueueUiController extends Controller
{
    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = DB::table('jobs');

        return view('queue-ui::index', [
            'jobs' => config('queue-ui.paginate', true) ? $jobs->paginate(config('queue-ui.paginate_size', 25)) : $jobs->get(),
        ]);
    }

    /**
     * Run an artisan command
     *
     * @param RunRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function run(RunRequest $request)
    {
        $exitCode = Artisan::call(trim(implode(' ', [
            $request->input('command'),
            $request->input('arguments', ''),
        ])));

        $message = $exitCode < 1 ? 'Task was successful' : 'There was an error running the task';

        Session::flash('status', $message);

        return back();
    }
}
