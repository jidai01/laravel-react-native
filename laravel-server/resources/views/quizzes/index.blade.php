<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizLOS | Manage Quizzes</title>
    <link rel="icon" type="image/svg+xml" href="/logo.svg">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- SortableJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
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
        .card { background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        h2 { margin-top: 0; margin-bottom: 1.5rem; color: var(--text); font-weight: 700; }
        label { display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
        input, textarea { width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #D1D5DB; border-radius: 0.5rem; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s; }
        input:focus, textarea:focus { outline: none; border-color: var(--primary); }
        
        .option-item { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; background: #fff; }
        .drag-handle { cursor: grab; color: #9CA3AF; padding: 10px; font-size: 1.25rem; }
        .option-item input { margin-bottom: 0; flex: 1; }
        .remove-opt { background: #FEE2E2; color: var(--danger); border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .add-opt { background: #EEF2FF; color: var(--primary); border: 2px dashed #C7D2FE; padding: 10px; border-radius: 8px; width: 100%; cursor: pointer; font-weight: 600; margin-bottom: 1.5rem; }
        
        .sortable-ghost {
            opacity: 0.5;
            background: #EEF2FF !important;
            border: 2px dashed var(--primary) !important;
            border-radius: 12px;
        }

        .btn { padding: 0.75rem 1.5rem; border-radius: 0.5rem; border: none; cursor: pointer; font-weight: 600; transition: all 0.2s; font-family: inherit; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-secondary { background: #F3F4F6; color: var(--text-light); }
        .btn-danger { background: #FEE2E2; color: var(--danger); }
        .btn-edit { background: #EEF2FF; color: var(--primary); }
        
        /* DataTables Custom */
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { margin-bottom: 1.5rem; color: var(--text-light); font-size: 0.875rem; }
        .dataTables_wrapper .dataTables_filter input { border: 1px solid #E5E7EB; border-radius: 8px; padding: 6px 12px; margin-left: 10px; }
        table.dataTable thead th { background: #F9FAFB !important; color: var(--text-light) !important; font-size: 0.75rem !important; text-transform: uppercase !important; border-bottom: 1px solid #E5E7EB !important; padding: 12px !important; }
        table.dataTable tbody td { border-bottom: 1px solid #F3F4F6 !important; padding: 1rem !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--primary) !important; color: white !important; border: none !important; border-radius: 6px !important; }

        .error-alert { background: #FEE2E2; color: var(--danger); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; font-weight: 500; }
        .success-alert { background: #ECFDF5; color: var(--success); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; font-weight: 500; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="/logo.svg" alt="QLOS Logo" style="width: 32px; height: 32px; border-radius: 8px;">
            <span>QuizLOS</span>
        </div>
        <a href="/dashboard" class="nav-item">Dashboard</a>
        <a href="/admin/quizzes" class="nav-item active">Quizzes</a>
        <a href="/admin/users" class="nav-item">Users</a>
    </aside>

    <main class="main">
        <!-- SweetAlert2 handled via script -->

        <div class="card">
            <h2 style="font-size: 1.25rem;">{{ $editingQuiz ? 'Edit Quiz' : 'Add New Quiz' }}</h2>
            <form action="{{ $editingQuiz ? '/admin/quizzes/'.$editingQuiz->id : '/admin/quizzes' }}" method="POST" id="quizForm">
                @csrf
                @if($editingQuiz) @method('PUT') @endif
                
                <label>Question</label>
                <textarea name="question" required rows="2" placeholder="Enter question text here...">{{ old('question', $editingQuiz->question ?? '') }}</textarea>
                
                <label>Options (Drag to reorder)</label>
                <div id="options-container">
                    @php 
                        $oldOptions = old('options', $editingQuiz->options ?? ['', '']); 
                    @endphp
                    @foreach($oldOptions as $index => $opt)
                        <div class="option-item">
                            <div class="drag-handle">☰</div>
                            <input type="text" name="options[]" value="{{ $opt }}" required placeholder="Option text">
                            <button type="button" class="remove-opt" onclick="removeOption(this)">×</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="add-opt" onclick="addOption()">+ Add Another Option</button>
                
                <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; background: #F9FAFB; padding: 12px; border-radius: 8px;">
                    <input type="checkbox" name="shuffle_options" id="shuffle_options" style="width: auto; margin-bottom: 0;" {{ old('shuffle_options', $editingQuiz->shuffle_options ?? true) ? 'checked' : '' }}>
                    <label for="shuffle_options" style="margin-bottom: 0; cursor: pointer;">Randomize/Shuffle options on mobile devices</label>
                </div>

                <label>Correct Answer</label>
                <input type="text" name="correct_answer" value="{{ old('correct_answer', $editingQuiz->correct_answer ?? '') }}" required placeholder="Must match one of the options exactly">
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">{{ $editingQuiz ? 'Update Quiz' : 'Save Quiz' }}</button>
                    @if($editingQuiz)
                        <a href="/admin/quizzes" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">Cancel Edit</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card" style="padding: 24px; border: 1px solid #E5E7EB;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="margin: 0; font-size: 1.5rem; letter-spacing: -0.5px;">Quiz Directory</h2>
                    <p style="margin: 4px 0 0; font-size: 0.875rem; color: var(--text-light);">Manage and organize your examination questions.</p>
                </div>
            </div>

            <div class="table-responsive" style="overflow-x: auto; margin: 0 -4px;">
                <table id="quizTable" class="display" style="width:100%; border-spacing: 0 10px; border-collapse: separate;">
                    <thead>
                        <tr>
                            <th style="border-radius: 12px 0 0 12px;">Question</th>
                            <th>Options Detail</th>
                            <th>Correct Answer</th>
                            <th style="border-radius: 0 12px 12px 0; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                        <tr style="background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <td style="border-radius: 12px 0 0 12px; max-width: 350px;">
                                <div style="font-weight: 700; color: var(--sidebar-bg); line-height: 1.6;">{{ $quiz->question }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 6px; display: flex; align-items: center; gap: 8px;">
                                    <span style="background: #F3F4F6; padding: 2px 8px; border-radius: 6px; font-weight: 700;">ID #{{ $quiz->id }}</span>
                                    @if($quiz->shuffle_options)
                                        <span style="background: #EEF2FF; color: var(--primary); padding: 2px 8px; border-radius: 6px; font-weight: 700; font-size: 10px;">✨ SHUFFLE ON</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="background: #F9FAFB; padding: 12px; border-radius: 12px; border: 1px solid #F3F4F6;">
                                    @if(is_array($quiz->options))
                                        @foreach($quiz->options as $index => $opt)
                                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; font-size: 0.813rem;">
                                                <span style="width: 18px; height: 18px; background: #E5E7EB; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; color: #6B7280;">{{ $index + 1 }}</span>
                                                <span style="color: var(--text-light); font-weight: 500;">{{ $opt }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="display: inline-flex; align-items: center; gap: 8px; background: #ECFDF5; padding: 8px 16px; border-radius: 10px; border: 1px solid #A7F3D0;">
                                    <span style="font-size: 14px;">✅</span>
                                    <span style="color: #065F46; font-weight: 800; font-size: 0.875rem;">{{ $quiz->correct_answer }}</span>
                                </div>
                            </td>
                            <td style="border-radius: 0 12px 12px 0; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="/admin/quizzes?edit={{ $quiz->id }}" class="action-btn-edit">Edit</a>
                                    <form action="/admin/quizzes/{{ $quiz->id }}" method="POST" onsubmit="return confirmAction(event, this, 'Delete this question?', 'This will permanently remove the question and its options.', 'Yes, delete it!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn-delete">Delete</button>
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
        .action-btn-edit { background: #EEF2FF; color: var(--primary); padding: 8px 16px; border-radius: 10px; text-decoration: none; font-size: 11px; font-weight: 800; transition: all 0.2s; border: 1px solid #C7D2FE; }
        .action-btn-edit:hover { background: var(--primary); color: white; transform: translateY(-1px); }
        
        .action-btn-delete { background: #FFF1F2; color: var(--danger); padding: 8px 16px; border-radius: 10px; border: 1px solid #FECDD3; font-size: 11px; font-weight: 800; cursor: pointer; transition: all 0.2s; }
        .action-btn-delete:hover { background: var(--danger); color: white; transform: translateY(-1px); }

        /* DataTables Custom Styling */
        .dataTables_wrapper .dataTables_filter { margin-bottom: 2rem; }
        .dataTables_wrapper .dataTables_filter input { border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 10px 16px; width: 300px; background: #F9FAFB; transition: all 0.2s; }
        .dataTables_wrapper .dataTables_filter input:focus { background: white; border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); }
        
        table.dataTable thead th { padding: 16px 20px !important; background: #F8FAFC !important; color: #64748B !important; font-size: 0.75rem !important; font-weight: 800 !important; text-transform: uppercase !important; border: none !important; }
        table.dataTable tbody td { padding: 16px 20px !important; border: none !important; vertical-align: middle !important; }
    </style>

    <script>
        $(document).ready(function() {
            $('#quizTable').DataTable({
                pageLength: 10,
                language: {
                    search: "",
                    searchPlaceholder: "Quick search questions...",
                    lengthMenu: "Show _MENU_"
                }
            });
        });

        const container = document.getElementById('options-container');
        if (typeof Sortable !== 'undefined') {
            new Sortable(container, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost'
            });
        }

        function addOption() {
            const count = container.querySelectorAll('.option-item').length;
            if (count >= 6) {
                Swal.fire('Limit Reached', 'Maximum 6 options allowed', 'info');
                return;
            }
            
            const div = document.createElement('div');
            div.className = 'option-item';
            div.innerHTML = `
                <div class="drag-handle">☰</div>
                <input type="text" name="options[]" required placeholder="Option text">
                <button type="button" class="remove-opt" onclick="removeOption(this)">×</button>
            `;
            container.appendChild(div);
            updateRemoveButtons();
        }

        function removeOption(btn) {
            const count = container.querySelectorAll('.option-item').length;
            if (count <= 2) {
                Swal.fire('Cannot Remove', 'Minimum 2 options required', 'warning');
                return;
            }
            btn.parentElement.remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const items = container.querySelectorAll('.option-item');
            items.forEach(item => {
                const btn = item.querySelector('.remove-opt');
                btn.style.display = items.length <= 2 ? 'none' : 'block';
            });
        }

        updateRemoveButtons();
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
