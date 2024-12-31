<!DOCTYPE html>
<html>
<head>
    <title>Analytics Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Analytics Report</h1>

    <h2>Total Tasks by Status</h2>
    <table>
        <thead>
            <tr>
                <th class="text-center">Status</th>
                <th class="text-center">Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['total_tasks'] as $status => $count)
                <tr>
                    <td class="text-center">{{ $status }}</td>
                    <td class="text-center">{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total Tasks by Priority</h2>
    <table>
        <thead>
            <tr>
                <th class="text-center">Priority</th>
                <th class="text-center">Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">Low</td>
                <td class="text-center">{{ $data['total_low'] }}</td>
            </tr>
            <tr>
                <td class="text-center">Medium</td>
                <td class="text-center">{{ $data['total_medium'] }}</td>
            </tr>
            <tr>
                <td class="text-center">High</td>
                <td class="text-center">{{ $data['total_high'] }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Admins with Task Counts</h2>
    <table>
        <thead>
            <tr>
                <th class="text-center">Admin Name</th>
                <th class="text-center">Tasks Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['adminsWithTaskCount'] as $admin)
                <tr>
                    <td class="text-center">{{ $admin->name }}</td>
                    <td class="text-center">{{ $admin->tasks_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Tasks with Due Date</h2>
    <table>
        <thead>
            <tr>
                <th class="text-center">Task Title</th>
                <th class="text-center">Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['tasksDueDate'] as $task)
                <tr>
                    <td class="text-center">{{ $task->title }}</td>
                    <td class="text-center">{{ $task->due_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
