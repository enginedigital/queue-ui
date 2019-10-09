<!DOCTYPE html>
<html>
<head>
    <title>Queue Jobs</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Queue Items</div>
                <div class="card-body">
                    <form action="{{ route('queue-ui.run') }}" method="GET" accept-charset="utf-8">
                        <div class="form-group mb-2">
                            <label for="command" class="sr-only">Command</label>
                            <select class="form-control" id="command">
                                @foreach (config('queue-ui.command_whitelist') as $command)
                                    <option value="{{ $command }}">{{ $command }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="arguments" class="sr-only">Arguments</label>
                            <input type="text" class="form-control" id="arguments">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Run</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Jobs Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <colgroup>
                            <col span="1" style="width: 10%;">
                            <col span="1" style="width: 10%;">
                            <col span="1" style="width: 50%;">
                            <col span="1" style="width: 30%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="th-sm">Id</th>
                                <th class="th-sm">Queue</th>
                                <th class="th-sm">Payload</th>
                                <th class="th-sm">Created At (UTC)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                            <tr>
                                <td>{{ $job->id }}</td>
                                <td>{{ $job->queue }}</td>
                                <td>{{ $job->payload }}</td>
                                <td>{{ $job->created_at->format('Y-m-d H:m') }}</td>
                            </tr>
                            @endforeach
                            @if ($jobs->count() === 0)
                                <tr>
                                    <td>#</td>
                                    <td>No jobs in the queue</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">{{ $jobs->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
