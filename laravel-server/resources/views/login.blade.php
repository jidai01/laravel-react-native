<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Access | Quiz System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            --bg: #F9FAFB;
            --text: #111827;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            background: var(--bg); 
            margin: 0; 
            color: var(--text);
        }
        .container {
            background: white;
            padding: 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 400px;
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo span {
            background: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 1.5rem;
        }
        h1 { 
            text-align: center; 
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        p {
            text-align: center;
            color: #6B7280;
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }
        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        input { 
            width: 100%; 
            padding: 0.75rem 1rem; 
            margin-bottom: 1.25rem; 
            border: 1px solid #D1D5DB; 
            border-radius: 0.75rem; 
            box-sizing: border-box;
            transition: all 0.2s;
            font-size: 1rem;
        }
        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
        button { 
            width: 100%; 
            padding: 0.875rem; 
            background: var(--primary); 
            color: white; 
            border: none; 
            border-radius: 0.75rem; 
            cursor: pointer; 
            font-size: 1rem; 
            font-weight: 600;
            transition: background 0.2s;
            margin-top: 0.5rem;
        }
        button:hover { background: var(--primary-hover); }
        .error { 
            background: #FEE2E2;
            color: #DC2626;
            padding: 0.75rem;
            border-radius: 0.75rem;
            text-align: center;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo"><span>Q</span></div>
        <h1>Admin Portal</h1>
        <p>Enter your credentials to access the dashboard</p>
        
        <!-- SweetAlert2 handled via script -->
        
        <form action="/login" method="POST">
            @csrf
            <label>Email Address</label>
            <input type="email" name="email" placeholder="admin@quiz.com" required autofocus>
            
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
            
            <button type="submit">Sign In</button>
        </form>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: "{{ session('error') }}",
                confirmButtonColor: '#4F46E5',
                background: '#ffffff',
                customClass: {
                    title: 'swal-title',
                    confirmButton: 'swal-btn'
                }
            });
        @endif
    </script>
</body>
</html>
