<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizLOS | Manage Users</title>
    <link rel="icon" type="image/svg+xml" href="/logo.svg">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <style>
        :root { 
            --primary: #4F46E5; 
            --secondary: #6366F1;
            --sidebar-bg: #111827; 
            --bg: #F9FAFB;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --text: #111827;
            --text-light: #6B7280;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); margin: 0; display: flex; min-height: 100vh; color: var(--text); }
        .sidebar { width: 260px; background: var(--sidebar-bg); color: white; padding: 2rem 1.5rem; display: flex; flex-direction: column; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 3rem; display: flex; align-items: center; gap: 10px; }
        .sidebar-brand span { background: var(--primary); padding: 4px 10px; border-radius: 8px; }
        .nav-item { padding: 0.75rem 1rem; border-radius: 0.5rem; color: #9CA3AF; text-decoration: none; margin-bottom: 0.5rem; transition: all 0.2s; font-weight: 500; }
        .nav-item.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; max-width: 1200px; margin: 0 auto; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 4px solid var(--primary); }
        .stat-label { color: var(--text-light); font-size: 0.875rem; font-weight: 600; }
        .stat-value { font-size: 1.75rem; font-weight: 800; color: var(--text); margin-top: 0.5rem; }

        .card { background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        h2 { margin-top: 0; margin-bottom: 1.5rem; color: var(--text); font-weight: 700; }
        label { display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
        input, select { width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #D1D5DB; border-radius: 0.5rem; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s; }
        input:focus, select:focus { outline: none; border-color: var(--primary); }
        
        .btn { padding: 0.75rem 1.5rem; border-radius: 0.5rem; border: none; cursor: pointer; font-weight: 600; transition: all 0.2s; font-family: inherit; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-secondary { background: #F3F4F6; color: var(--text-light); }
        .btn-danger { background: #FEE2E2; color: var(--danger); }
        
        /* DataTables Custom */
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { margin-bottom: 1.5rem; color: var(--text-light); font-size: 0.875rem; }
        .dataTables_wrapper .dataTables_filter input { border: 1px solid #E5E7EB; border-radius: 8px; padding: 6px 12px; margin-left: 10px; width: auto; }
        table.dataTable thead th { background: #F9FAFB !important; color: var(--text-light) !important; font-size: 0.75rem !important; text-transform: uppercase !important; border-bottom: 1px solid #E5E7EB !important; padding: 12px !important; }
        table.dataTable tbody td { border-bottom: 1px solid #F3F4F6 !important; padding: 1rem !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--primary) !important; color: white !important; border: none !important; border-radius: 6px !important; }

        .success-alert { background: #ECFDF5; color: var(--success); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: 600; border-left: 4px solid var(--success); }
        .error-alert { background: #FEE2E2; color: var(--danger); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: 600; border-left: 4px solid var(--danger); }
        
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .badge-admin { background: #EEF2FF; color: var(--primary); }
        .badge-participant { background: #F3F4F6; color: var(--text-light); }
        .badge-banned { background: #9B1C1C; color: white; }
        .badge-active { background: #DEF7EC; color: #03543F; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="/logo.svg" alt="QLOS Logo" style="width: 32px; height: 32px; border-radius: 8px;">
            <span>QuizLOS</span>
        </div>
        <a href="/dashboard" class="nav-item">Dashboard</a>
        <a href="/admin/quizzes" class="nav-item">Quizzes</a>
        <a href="/admin/users" class="nav-item active">Users</a>
    </aside>

    <main class="main">
        <!-- SweetAlert2 handled via script -->
        
        @if ($errors->any())
            <div class="error-alert">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card" style="border-top: 4px solid var(--primary); border-radius: 16px;">
                <div class="stat-label">Total Users</div>
                <div class="stat-value" style="color: var(--primary)">{{ $users->count() }}</div>
            </div>
            <div class="stat-card" style="border-top: 4px solid var(--secondary); border-radius: 16px;">
                <div class="stat-label">Admins</div>
                <div class="stat-value" style="color: var(--secondary)">{{ $users->where('is_admin', true)->count() }}</div>
            </div>
            <div class="stat-card" style="border-top: 4px solid var(--danger); border-radius: 16px;">
                <div class="stat-label">Disqualified</div>
                <div class="stat-value" style="color: var(--danger)">{{ $users->where('is_disqualified', true)->count() }}</div>
            </div>
        </div>

        <div class="card">
            <h2 style="font-size: 1.25rem;">{{ $editingUser ? 'Edit User' : 'Add New User' }}</h2>
            <form action="{{ $editingUser ? '/admin/users/'.$editingUser->id : '/admin/users' }}" method="POST">
                @csrf
                @if($editingUser) @method('PUT') @endif
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $editingUser->name ?? '') }}" required placeholder="John Doe">
                    </div>
                    <div>
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $editingUser->email ?? '') }}" required placeholder="john@example.com">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label>Password {{ $editingUser ? '(Leave blank to keep current)' : '' }}</label>
                        <input type="password" name="password" {{ $editingUser ? '' : 'required' }} placeholder="Min 8 characters">
                    </div>
                    <div>
                        <label>Role</label>
                        <select name="role" required>
                            <option value="participant" {{ old('role', ($editingUser && !$editingUser->is_admin) ? 'participant' : '') === 'participant' ? 'selected' : '' }}>Participant</option>
                            <option value="admin" {{ old('role', ($editingUser && $editingUser->is_admin) ? 'admin' : '') === 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary">{{ $editingUser ? 'Update User' : 'Save User' }}</button>
                    @if($editingUser)
                        <a href="/admin/users" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">Cancel Edit</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card" style="padding: 24px; border: 1px solid #E5E7EB; border-radius: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="margin: 0; font-size: 1.5rem; letter-spacing: -0.5px;">Users Directory</h2>
                    <p style="margin: 4px 0 0; font-size: 0.875rem; color: var(--text-light);">Manage user access and roles.</p>
                </div>
            </div>

            <div class="table-responsive" style="overflow-x: auto; margin: 0 -4px;">
                <table id="usersTable" class="display" style="width:100%; border-spacing: 0 10px; border-collapse: separate;">
                    <thead>
                        <tr>
                            <th style="border-radius: 12px 0 0 12px;">User Info</th>
                            <th>Role & Status</th>
                            <th>Registration Date</th>
                            <th style="border-radius: 0 12px 12px 0; text-align: center;">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr style="background: {{ $user->is_disqualified ? '#FFF1F2' : '#fff' }}; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <td style="border-radius: 12px 0 0 12px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; background: {{ $user->is_admin ? '#EEF2FF' : ($user->is_disqualified ? '#FECDD3' : '#F3F4F6') }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; color: {{ $user->is_admin ? 'var(--primary)' : ($user->is_disqualified ? 'var(--danger)' : '#6B7280') }};">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--sidebar-bg);">{{ $user->name }}</div>
                                        <div style="font-size: 12px; color: var(--text-light); font-weight: 500; margin-top: 2px;">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                    @if($user->is_admin)
                                        <div class="badge badge-admin"><span style="width: 6px; height: 6px; background: var(--primary); border-radius: 50%;"></span> Admin</div>
                                    @else
                                        <div class="badge badge-participant"><span style="width: 6px; height: 6px; background: var(--text-light); border-radius: 50%;"></span> Participant</div>
                                    @endif
                                    
                                    @if($user->is_disqualified)
                                        <div class="badge badge-banned"><span style="width: 6px; height: 6px; background: white; border-radius: 50%;"></span> Banned</div>
                                    @elseif(!$user->is_admin)
                                        <div class="badge badge-active"><span style="width: 6px; height: 6px; background: #10B981; border-radius: 50%;"></span> Active</div>
                                    @endif
                                </div>
                            </td>
                            <td><div style="font-size: 13px; color: var(--text-light); font-weight: 500;">{{ $user->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }}</div></td>
                            <td style="border-radius: 0 12px 12px 0; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="/admin/users?edit={{ $user->id }}" class="btn-edit-custom">Edit</a>
                                    
                                    @if(!$user->is_admin)
                                        <form action="/admin/users/{{ $user->id }}/toggle-status" method="POST" onsubmit="return confirmAction(event, this, 'Change user status?', 'Are you sure you want to change the status for {{ $user->name }}?', 'Yes, change it!')">
                                            @csrf
                                            <button type="submit" class="btn-toggle-custom {{ $user->is_disqualified ? 'btn-restore' : 'btn-ban' }}">
                                                {{ $user->is_disqualified ? 'Restore' : 'Ban' }}
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="/admin/users/{{ $user->id }}" method="POST" onsubmit="return confirmAction(event, this, 'Delete this user?', 'This will also delete all their quiz results. This action cannot be undone!', 'Yes, delete it!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete-custom">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <style>
        .btn-edit-custom { background: #EEF2FF; color: var(--primary); padding: 8px 16px; border-radius: 10px; border: 1px solid #C7D2FE; font-size: 11px; font-weight: 800; text-decoration: none; transition: all 0.2s; }
        .btn-edit-custom:hover { background: var(--primary); color: white; transform: translateY(-1px); }

        .btn-toggle-custom { padding: 8px 16px; border-radius: 10px; font-size: 11px; font-weight: 800; cursor: pointer; transition: all 0.2s; }
        .btn-restore { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
        .btn-restore:hover { background: #10B981; color: white; transform: translateY(-1px); }
        .btn-ban { background: #FFF1F2; color: #9B1C1C; border: 1px solid #FECDD3; }
        .btn-ban:hover { background: var(--danger); color: white; transform: translateY(-1px); }
        
        .btn-delete-custom { background: #F3F4F6; color: #6B7280; padding: 8px 16px; border-radius: 10px; border: 1px solid #E5E7EB; font-size: 11px; font-weight: 800; cursor: pointer; transition: all 0.2s; }
        .btn-delete-custom:hover { background: #4B5563; color: white; border-color: #4B5563; transform: translateY(-1px); }

        /* DataTables Integration */
        .dataTables_wrapper .dataTables_filter { margin-bottom: 2rem; }
        .dataTables_wrapper .dataTables_filter input { border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 10px 16px; width: 300px; background: #F9FAFB; transition: all 0.2s; }
        .dataTables_wrapper .dataTables_filter input:focus { background: white; border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); }
        
        table.dataTable thead th { padding: 16px 20px !important; background: #F8FAFC !important; color: #64748B !important; font-size: 0.75rem !important; font-weight: 800 !important; text-transform: uppercase !important; border: none !important; }
        table.dataTable tbody td { padding: 16px 20px !important; border: none !important; vertical-align: middle !important; }
    </style>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                pageLength: 10,
                language: {
                    search: "",
                    searchPlaceholder: "Search users...",
                    lengthMenu: "Display _MENU_"
                }
            });
        });
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4F46E5',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#EF4444'
            });
        @endif

        function confirmAction(e, form, title, text, confirmText) {
            e.preventDefault();
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: confirmText
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
