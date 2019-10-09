<!DOCTYPE html>
<html>
<head>
    <title>Queue Jobs</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Jets({
                searchTag: '#jetsSearch',
                contentTag: '#jetsContent',
                columns: [2] // search column
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">Queue Items</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('queue-ui.run') }}" method="GET" accept-charset="utf-8">
                        <div class="form-group mb-2">
                            <label for="command">Command</label>
                            <select class="form-control" id="command" name="command" placeholder="command">
                                @foreach (config('queue-ui.command_whitelist') as $value => $detail)
                                    <option value="{{ $value }}">{{ $detail['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Run</button>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">Jobs Dashboard</div>
                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label for="jetsSearch" class="col-sm-2 col-form-label">Filter:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="jetsSearch" placeholder="Filter table">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Total jobs:</label>
                            <div class="col-sm-10">
                                <strong>{{ $jobs->count() }}/{{ $jobs->total() }}</strong>
                            </div>
                        </div>
                    </form>
                    <nav class="row">
                        <div class="col-sm-12">{{ $jobs->links(config('queue-ui.paginate_partial', null)) }}</div>
                    </nav>
                    <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <colgroup>
                            <col span="1" style="width: 8%;">
                            <col span="1" style="width: 12%;">
                            <col span="1" style="width: 65%;">
                            <col span="1" style="width: 15%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="th-sm">Id</th>
                                <th class="th-sm">Queue</th>
                                <th class="th-sm">Payload</th>
                                <th class="th-sm">Created At (UTC)</th>
                            </tr>
                        </thead>
                        <tbody id="jetsContent">
                            @foreach ($jobs as $job)
                            <tr>
                                <td>{{ $job->id }} {{ is_null($job->reserved_at) ? '' : '✔' }}</td>
                                <td>{{ $job->queue }}</td>
                                {{-- <td><p class="text-break">{{ json_decode($job->payload)->data->command }}</p></td> --}}
                                <td><p class="text-break">{{ $job->payload }}</p></td>
                                <td>{{ date('Y-m-d H:m', $job->created_at) }}</td>
                            </tr>
                            @endforeach
                            @if ($jobs->total() === 0)
                                <tr>
                                    <td>#</td>
                                    <td>No jobs in the queue</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <nav class="row">
                        <div class="col-sm-12">{{ $jobs->links(config('queue-ui.paginate_partial', null)) }}</div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
