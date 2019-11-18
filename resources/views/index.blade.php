<!DOCTYPE html>
<html>
<head>
    <title>Queue Jobs</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<template>
    @foreach (config('queue-ui.commands') as $value => $detail)
        @if (is_array(array_get($detail, 'arguments')))
            <div class="form-group mb-2" id="{{ $value }}">
                @foreach ($detail['arguments'] as $argument)
                    <label for="arguments[{{ $argument }}]">{{ $argument }}</label>
                    <input type="text" name="arguments[{{ $argument }}]" required>
                @endforeach
            </div>
        @endif
    @endforeach
</template>
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
                                @foreach (config('queue-ui.commands') as $value => $detail)
                                    <option value="{{ $value }}">{{ $detail['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- placeholder for additional arguments --}}
                        <div id="arguments"></div>
                        <button type="submit" class="btn btn-primary mb-2">Run</button>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">Jobs Dashboard</div>
                <div class="card-body">
                    <form action="{{ url()->current() }}" method="GET" accept-charset="utf-8">
                        <div class="form-group row">
                            <label for="filter" class="col-sm-2 col-form-label">Filter:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="filter" name="filter" placeholder="Filter table" value="{{ $filter }}">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
  const command = document.getElementById('command');
  const argument = document.getElementById('arguments');
  command.addEventListener('change', function(e) {
    const value = this.options[this.selectedIndex].value;
    const template = document.getElementsByTagName('template')[0];
    const content = template.content.getElementById(value);
    argument.innerHTML = content ? content.innerHTML : '';
  });

  const event = document.createEvent('HTMLEvents');
  event.initEvent('change', true, false);
  command.dispatchEvent(event);
});
</script>
</body>
</html>
