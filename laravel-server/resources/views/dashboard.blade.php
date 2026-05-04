<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizLOS | Admin Dashboard</title>
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
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg); 
            margin: 0; 
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-brand span {
            background: var(--primary);
            padding: 4px 10px;
            border-radius: 8px;
        }
        .nav-item {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: #9CA3AF;
            text-decoration: none;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
        }
        .nav-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .nav-item:hover {
            color: white;
            background: rgba(255,255,255,0.05);
        }

        /* Main Content */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .logout-btn {
            background: #FEE2E2;
            color: #DC2626;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .container { padding: 2rem; }
        .page-header { margin-bottom: 2rem; }
        .page-header h2 { margin: 0; font-size: 1.875rem; font-weight: 700; }
        .page-header p { color: #6B7280; margin: 0.5rem 0 0 0; }

        /* Table Card */
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        th { 
            background: #F9FAFB; 
            padding: 1rem 1.5rem; 
            text-align: left; 
            font-size: 0.75rem; 
            font-weight: 600; 
            color: #6B7280; 
            text-transform: uppercase;
            border-bottom: 1px solid #E5E7EB;
        }
        td { 
            padding: 1.25rem 1.5rem; 
            border-bottom: 1px solid #F3F4F6;
            font-size: 0.875rem;
            color: #374151;
        }
        tr:hover { background: #F9FAFB; }
        .score-pill {
            background: #EEF2FF;
            color: #4F46E5;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 700;
        }
        .logs-box {
            font-family: monospace;
            font-size: 0.75rem;
            color: #6B7280;
            background: #F9FAFB;
            padding: 8px;
            border-radius: 6px;
            max-height: 80px;
            overflow-y: auto;
        }
        .badge-select { color: #10B981; font-weight: 600; }
        .badge-change { color: #F59E0B; font-weight: 600; }
        .badge-disqualified { color: #DC2626; font-weight: 800; }
        .logs-box::-webkit-scrollbar { width: 4px; }
        .logs-box::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 4px; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="/logo.svg" alt="QLOS Logo" style="width: 32px; height: 32px; border-radius: 8px;">
            <span>QuizLOS</span>
        </div>
        <a href="/dashboard" class="nav-item active">Dashboard</a>
        <a href="/admin/quizzes" class="nav-item">Quizzes</a>
        <a href="/admin/users" class="nav-item">Users</a>
    </aside>

    <main class="main">
        <nav class="navbar">
            <a href="/logout" class="logout-btn">Sign Out</a>
        </nav>

        <div class="container">
            <div class="page-header">
                <h2>Activity Monitor</h2>
                <p>Tracking participant performance and live activity logs.</p>
            </div>

            <div class="card" style="padding: 24px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px -10px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding: 0 4px;">
                    <div>
                        <h2 style="margin: 0; font-size: 1.5rem; color: var(--sidebar-bg); letter-spacing: -0.5px;">Activity Monitor</h2>
                        <p style="margin: 4px 0 0; font-size: 0.875rem; color: var(--text-light);">Monitoring real-time participant engagement and integrity.</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; background: #EEF2FF; padding: 8px 16px; border-radius: 12px;">
                        <div style="width: 8px; height: 8px; background: var(--success); border-radius: 50%; animation: pulse 2s infinite;"></div>
                        <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase;">System Online</span>
                    </div>
                </div>
                
                @if(session('success'))
                    <div style="background: #ECFDF5; color: var(--success); padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600; border: 1px solid #A7F3D0; display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 1.25rem;">✓</span> {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive" style="overflow-x: auto; margin: 0 -4px;">
                    <table id="resultsTable" class="display" style="width:100%; border-spacing: 0 8px; border-collapse: separate;">
                        <thead>
                            <tr>
                                <th style="border-radius: 12px 0 0 12px;">Participant</th>
                                <th>Score</th>
                                <th style="width: 300px;">Activity Logs</th>
                                <th>Time Submitted</th>
                                <th style="border-radius: 0 12px 12px 0; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                            <tr style="background: #fff;">
                                <td style="border-radius: 12px 0 0 12px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; background: #F3F4F6; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary); font-size: 0.875rem;">
                                            {{ strtoupper(substr($result->user_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--sidebar-bg); font-size: 0.938rem;">{{ $result->user_name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 2px;">Result ID #{{ $result->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: inline-flex; align-items: center; gap: 6px; background: #F5F3FF; padding: 6px 12px; border-radius: 10px; border: 1px solid #DDD6FE;">
                                        <span style="font-weight: 800; color: var(--primary); font-size: 1.125rem;">{{ $result->score }}</span>
                                        <span style="font-size: 0.625rem; font-weight: 700; color: var(--secondary); text-transform: uppercase;">Points</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="logs-box" style="max-height: 120px; padding: 12px; background: #F9FAFB; border-radius: 12px; border: 1px solid #F3F4F6;">
                                        @if($result->logs)
                                            @foreach($result->logs as $log)
                                                <div style="margin-bottom: 8px; font-size: 0.75rem; display: flex; align-items: flex-start; gap: 8px;">
                                                    <span style="color: var(--text-light); font-family: monospace; font-weight: 600;">[{{ isset($log['timestamp']) ? \Carbon\Carbon::parse($log['timestamp'])->timezone('Asia/Makassar')->format('H:i:s') : '--:--:--' }}]</span>
                                                    <div style="flex: 1;">
                                                        <span style="font-weight: 800; color: {{ $log['action'] === 'disqualified' ? 'var(--danger)' : 'var(--success)' }}; font-size: 10px; text-transform: uppercase;">{{ $log['action'] }}</span>
                                                        @if(isset($log['question_id']))
                                                            <span style="color: var(--sidebar-bg); font-weight: 500;">Q{{ $log['question_id'] }} → {{ $log['selected_option'] }}</span>
                                                        @else
                                                            <span style="color: var(--danger); font-weight: 700;">VIOLATION DETECTED</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <span style="color: var(--text-light); font-size: 0.75rem; font-style: italic;">No activity recorded</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--sidebar-bg); font-size: 0.875rem;">{{ $result->created_at->timezone('Asia/Makassar')->format('d M Y') }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 4px; display: flex; align-items: center; gap: 4px;">
                                        <span style="width: 6px; height: 6px; background: #D1D5DB; border-radius: 50%;"></span>
                                        {{ $result->created_at->timezone('Asia/Makassar')->format('H:i:s') }} WITA
                                    </div>
                                </td>
                                <td style="border-radius: 0 12px 12px 0; text-align: center;">
                                    <form action="/admin/results/{{ $result->id }}" method="POST" onsubmit="return confirm('Delete this record permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn-custom">
                                            <span style="font-size: 14px;">🗑</span> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <script>
                $(document).ready(function() {
                    $('#resultsTable').DataTable({
                        order: [[3, 'desc']],
                        pageLength: 10,
                        language: {
                            search: "",
                            searchPlaceholder: "Search results...",
                            lengthMenu: "Show _MENU_ entries"
                        },
                        drawCallback: function() {
                            $('.dataTables_paginate .paginate_button').addClass('btn-page');
                        }
                    });
                });
            </script>
            
            <style>
                @keyframes pulse {
                    0% { opacity: 1; transform: scale(1); }
                    50% { opacity: 0.4; transform: scale(1.2); }
                    100% { opacity: 1; transform: scale(1); }
                }

                .delete-btn-custom {
                    background: #FFF1F2;
                    color: var(--danger);
                    border: 1px solid #FECDD3;
                    padding: 8px 16px;
                    border-radius: 10px;
                    font-size: 0.75rem;
                    font-weight: 700;
                    cursor: pointer;
                    transition: all 0.2s;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                }
                .delete-btn-custom:hover { background: var(--danger); color: white; border-color: var(--danger); transform: translateY(-1px); box-shadow: 0 4px 12px -4px var(--danger); }

                /* DataTables Redesign */
                .dataTables_wrapper .dataTables_filter { margin-bottom: 2rem; float: right; }
                .dataTables_wrapper .dataTables_filter input { 
                    border: 1.5px solid #E5E7EB; 
                    border-radius: 12px; 
                    padding: 10px 16px; 
                    width: 280px;
                    font-family: inherit;
                    transition: all 0.2s;
                    background: #F9FAFB;
                }
                .dataTables_wrapper .dataTables_filter input:focus { background: white; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); outline: none; }
                
                table.dataTable { border-collapse: separate !important; border-spacing: 0 12px !important; margin-top: 0 !important; }
                table.dataTable thead th { 
                    padding: 16px 20px !important; 
                    background: #F8FAFC !important; 
                    color: #64748B !important; 
                    font-size: 0.75rem !important; 
                    font-weight: 800 !important; 
                    text-transform: uppercase !important; 
                    letter-spacing: 0.05em !important;
                    border: none !important;
                }
                table.dataTable tbody tr { 
                    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
                    transition: transform 0.2s;
                }
                table.dataTable tbody tr:hover { transform: scale(1.002); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
                table.dataTable tbody td { padding: 16px 20px !important; border: none !important; vertical-align: middle !important; }

                .dataTables_wrapper .dataTables_paginate { padding-top: 1.5rem; margin-top: 1rem; border-top: 1px solid #F1F5F9; }
                .dataTables_wrapper .dataTables_paginate .paginate_button.current { 
                    background: var(--primary) !important; 
                    color: white !important; 
                    border: none !important; 
                    border-radius: 10px !important;
                    font-weight: 700 !important;
                    padding: 8px 16px !important;
                }
                .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                    background: #EEF2FF !important;
                    border: none !important;
                    color: var(--primary) !important;
                    border-radius: 10px !important;
                }
                .dataTables_wrapper .dataTables_info { padding-top: 1.5rem; font-size: 0.875rem; color: #94A3B8; font-weight: 500; }
            </style>
                <div style="text-align: center; margin-top: 3rem; color: #94A3B8; font-size: 0.75rem; font-weight: 500; border-top: 1px solid #F1F5F9; padding-top: 2rem;">
                    QuizLOS v.1.0 &copy; {{ date('Y') }} • All Systems Operational
                </div>
            </div>
        </div>
    </main>
</body>
</html>
