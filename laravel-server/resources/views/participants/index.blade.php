<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizLOS | Participants</title>
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
        
        .disqualified-row { background-color: #FFF5F5; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-active { background: #DEF7EC; color: #03543F; }
        .status-disqualified { background: #FDE2E2; color: #9B1C1C; }
        
        .btn { padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; font-weight: 700; font-size: 11px; transition: all 0.2s; font-family: inherit; }
        .btn-success { background: var(--success); color: white; }
        .btn-danger { background: var(--danger); color: white; }
        
        /* DataTables Custom */
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { margin-bottom: 1.5rem; color: var(--text-light); font-size: 0.875rem; }
        .dataTables_wrapper .dataTables_filter input { border: 1px solid #E5E7EB; border-radius: 8px; padding: 6px 12px; margin-left: 10px; }
        table.dataTable thead th { background: #F9FAFB !important; color: var(--text-light) !important; font-size: 0.75rem !important; text-transform: uppercase !important; border-bottom: 1px solid #E5E7EB !important; padding: 12px !important; }
        table.dataTable tbody td { border-bottom: 1px solid #F3F4F6 !important; padding: 1rem !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--primary) !important; color: white !important; border: none !important; border-radius: 6px !important; }

        .success-alert { background: #ECFDF5; color: var(--success); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: 600; border-left: 4px solid var(--success); }
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
        <a href="/admin/participants" class="nav-item active">Participants</a>
    </aside>

    <main class="main">
        @if(session('success')) <div class="success-alert"><span>✓</span> {{ session('success') }}</div> @endif

        <div class="stats-grid">
            <div class="stat-card" style="border-top: 4px solid var(--primary); border-radius: 16px;">
                <div class="stat-label">Total Participants</div>
                <div class="stat-value" style="color: var(--primary)">{{ $participants->count() }}</div>
                <div style="margin-top: 10px; font-size: 0.75rem; color: var(--text-light);">Registered accounts</div>
            </div>
            <div class="stat-card" style="border-top: 4px solid var(--danger); border-radius: 16px;">
                <div class="stat-label">Disqualified</div>
                <div class="stat-value" style="color: var(--danger)">{{ $participants->where('is_disqualified', true)->count() }}</div>
                <div style="margin-top: 10px; font-size: 0.75rem; color: var(--text-light);">Integrity violations</div>
            </div>
            <div class="stat-card" style="border-top: 4px solid var(--success); border-radius: 16px;">
                <div class="stat-label">Active Access</div>
                <div class="stat-value" style="color: var(--success)">{{ $participants->where('is_disqualified', false)->count() }}</div>
                <div style="margin-top: 10px; font-size: 0.75rem; color: var(--text-light);">Authorized to take quiz</div>
            </div>
        </div>

        <div class="card" style="padding: 24px; border: 1px solid #E5E7EB; border-radius: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="margin: 0; font-size: 1.5rem; letter-spacing: -0.5px;">Participants Directory</h2>
                    <p style="margin: 4px 0 0; font-size: 0.875rem; color: var(--text-light);">Manage user access and review account statuses.</p>
                </div>
            </div>

            <div class="table-responsive" style="overflow-x: auto; margin: 0 -4px;">
                <table id="participantsTable" class="display" style="width:100%; border-spacing: 0 10px; border-collapse: separate;">
                    <thead>
                        <tr>
                            <th style="border-radius: 12px 0 0 12px;">Participant Info</th>
                            <th>Email Address</th>
                            <th>Current Status</th>
                            <th>Registration Date</th>
                            <th style="border-radius: 0 12px 12px 0; text-align: center;">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $user)
                        <tr style="background: {{ $user->is_disqualified ? '#FFF1F2' : '#fff' }}; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <td style="border-radius: 12px 0 0 12px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; background: {{ $user->is_disqualified ? '#FECDD3' : '#EEF2FF' }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; color: {{ $user->is_disqualified ? 'var(--danger)' : 'var(--primary)' }};">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div style="font-weight: 700; color: var(--sidebar-bg);">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td><div style="color: var(--text-light); font-weight: 500;">{{ $user->email }}</div></td>
                            <td>
                                @if($user->is_disqualified)
                                    <div style="display: inline-flex; align-items: center; gap: 6px; background: #9B1C1C; color: white; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                                        <span style="width: 6px; height: 6px; background: white; border-radius: 50%;"></span> BANNED
                                    </div>
                                @else
                                    <div style="display: inline-flex; align-items: center; gap: 6px; background: #DEF7EC; color: #03543F; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                                        <span style="width: 6px; height: 6px; background: #10B981; border-radius: 50%;"></span> ACTIVE
                                    </div>
                                @endif
                            </td>
                            <td><div style="font-size: 13px; color: var(--text-light); font-weight: 500;">{{ $user->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }}</div></td>
                            <td style="border-radius: 0 12px 12px 0; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    @if($user->is_disqualified)
                                        <form action="/admin/participants/{{ $user->id }}/reset" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-restore-custom" onclick="return confirm('Restore access for {{ $user->name }}?')">Restore Access</button>
                                        </form>
                                    @endif
                                    
                                    <form action="/admin/participants/{{ $user->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-custom" onclick="return confirm('Delete participant {{ $user->name }} permanently?')">Delete</button>
                                    </form>
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
        .btn-restore-custom { background: #DCFCE7; color: #166534; padding: 8px 16px; border-radius: 10px; border: 1px solid #BBF7D0; font-size: 11px; font-weight: 800; cursor: pointer; transition: all 0.2s; }
        .btn-restore-custom:hover { background: #10B981; color: white; transform: translateY(-1px); }
        
        .btn-delete-custom { background: #F3F4F6; color: #6B7280; padding: 8px 16px; border-radius: 10px; border: 1px solid #E5E7EB; font-size: 11px; font-weight: 800; cursor: pointer; transition: all 0.2s; }
        .btn-delete-custom:hover { background: var(--danger); color: white; border-color: var(--danger); transform: translateY(-1px); }

        /* DataTables Integration */
        .dataTables_wrapper .dataTables_filter { margin-bottom: 2rem; }
        .dataTables_wrapper .dataTables_filter input { border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 10px 16px; width: 300px; background: #F9FAFB; transition: all 0.2s; }
        .dataTables_wrapper .dataTables_filter input:focus { background: white; border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); }
        
        table.dataTable thead th { padding: 16px 20px !important; background: #F8FAFC !important; color: #64748B !important; font-size: 0.75rem !important; font-weight: 800 !important; text-transform: uppercase !important; border: none !important; }
        table.dataTable tbody td { padding: 16px 20px !important; border: none !important; vertical-align: middle !important; }
    </style>

    <script>
        $(document).ready(function() {
            $('#participantsTable').DataTable({
                pageLength: 10,
                language: {
                    search: "",
                    searchPlaceholder: "Search participants...",
                    lengthMenu: "Display _MENU_"
                }
            });
        });
    </script>
</body>
</html>
