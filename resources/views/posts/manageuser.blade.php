<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Manage Users</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-xxxx" crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(to right, #fff, #ffebee);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #e91e63; /* Pink color for heading */
        }

        .table {
            background-color: #fff; /* White background for the table */
        }

        th {
            background-color: #fce4ec; /* Light pink for header background */
            color: #333; /* Dark text color for better readability */
        }

        td {
            background-color: #fff; /* White background for table data */
            color: #333; /* Dark text color */
        }

        .btn-delete {
            background: #e91e63; /* Pink background for delete button */
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background: #c2185b; /* Darker pink on hover */
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            th, td {
                font-size: 14px; /* Smaller font size for mobile */
                padding: 8px;
            }

            .btn-delete {
                padding: 4px 8px; /* Smaller buttons for mobile */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4 mt-4">Manage Users</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- DataTable Initialization -->
        <table class="table table-striped table-hover" id="usersTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <!-- Action Buttons with Confirmation -->
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- jQuery (necessary for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                paging: true,   // Enable pagination
                searching: true // Enable search box
            });
        });
    </script>
</body>
</html>
