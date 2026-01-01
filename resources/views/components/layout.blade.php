<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Padel Court Booking' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .smooth-scroll {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen smooth-scroll">

    {{ $slot }}

    {{-- <footer class="mt-auto py-8 text-center text-white text-sm bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="container mx-auto px-4">
            <p class="mb-2">&copy; 2025 Padel Court Booking System</p>
        </div>
    </footer> --}}

    <script>
        // Auto-refresh CSRF token to prevent 419 errors
        setInterval(function () {
            fetch('/refresh-csrf', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.token) {
                        // Update all CSRF token inputs
                        document.querySelectorAll('input[name="_token"]').forEach(input => {
                            input.value = data.token;
                        });
                        // Update meta tag
                        document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    }
                })
                .catch(error => console.error('CSRF refresh error:', error));
        }, 300000); // Refresh every 5 minutes

        // Logout Confirmation
        document.addEventListener('submit', function(e) {
            if (e.target.action && e.target.action.includes('logout')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan keluar dari sesi ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            }
        });

        // Flash Message to SweetAlert
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
            });
        @endif
    </script>

</body>

</html>