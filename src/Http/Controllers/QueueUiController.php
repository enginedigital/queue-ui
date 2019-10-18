<?php

namespace EngineDigital\QueueUi\Http\Controllers;

use EngineDigital\QueueUi\Http\Requests\RunRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class QueueUiController extends Controller
{
    /**
     * Show the application index.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jobs = DB::table('jobs');

        if ($request->filled('filter')) {
            $jobs->where('payload', 'LIKE', sprintf('%%%s%%', $request->input('filter')));
        }

        return view('queue-ui::index', [
            'filter' => $request->input('filter', ''),
            'jobs' => config('queue-ui.paginate', true)
                ? $jobs->paginate(config('queue-ui.paginate_size', 25))->appends($request->except('page'))
                : $jobs->get(),
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
