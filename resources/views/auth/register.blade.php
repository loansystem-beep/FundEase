@extends('layouts.app')

@section('content')
<style>
    body {
        background: #1a1a2e;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
        position: relative;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(18, 18, 18, 0.98);
        z-index: 1;
    }

    .brick-wall {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
        grid-template-rows: repeat(auto-fill, 30px);
        gap: 2px;
        z-index: 2;
    }

    .brick {
        width: 100%;
        height: 100%;
        background: transparent;
        border: 1px solid transparent;
        transition: border-color 0.3s ease-in-out;
    }

    .brick.glow {
        border-color: rgba(155, 89, 182, 0.8);
        box-shadow: 0 0 10px rgba(155, 89, 182, 0.5);
    }

    .register-container {
        position: relative;
        z-index: 10;
        background: rgba(26, 26, 46, 0.9);
        backdrop-filter: blur(12px);
        padding: 2.5rem;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 230, 230, 0.3);
        max-width: 900px;       /* ↑ increased max-width */
        width: 95%;             /* ↑ fill more of viewport */
        min-width: 400px;       /* ensure it doesn’t get too narrow */
    }

    .register-container h2 {
        color: #00e6e6;
        text-align: center;
        margin-bottom: 1rem;
        font-size: 1.75rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #00e6e6;
        font-weight: 600;
    }

    .form-control {
        background: rgba(30, 30, 60, 0.8);
        border: 2px solid rgba(0, 230, 230, 0.5);
        color: #ffffff;
        padding: 14px;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
        width: 100%;
        box-sizing: border-box;
    }

    .form-control::placeholder {
        color: #b3b3b3;
    }

    .form-control:focus {
        border-color: #00e6e6;
        box-shadow: 0 0 10px rgba(0, 230, 230, 0.6);
        background: rgba(40, 40, 70, 0.9);
        outline: none;
    }

    .btn-primary {
        background: linear-gradient(90deg, #9b59b6, #00e6e6);
        border: none;
        padding: 14px;
        width: 100%;
        border-radius: 5px;
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #00e6e6, #9b59b6);
        box-shadow: 0 0 15px rgba(0, 230, 230, 0.8);
    }
</style>

<div class="overlay"></div>
<div class="brick-wall">
    @for ($i = 0; $i < 20; $i++)
        @for ($j = 0; $j < 20; $j++)
            <div class="brick"></div>
        @endfor
    @endfor
</div>

<div class="register-container">
    <h2>Register</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Full Name</label>
            <input id="name"
                   type="text"
                   class="form-control"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="e.g. Jane Doe"
                   required
                   autofocus>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email"
                   type="email"
                   class="form-control"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="you@example.com"
                   required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password"
                   type="password"
                   class="form-control"
                   name="password"
                   placeholder="••••••••"
                   required>
        </div>

        <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input id="password-confirm"
                   type="password"
                   class="form-control"
                   name="password_confirmation"
                   placeholder="••••••••"
                   required>
        </div>

        <button type="submit" class="btn-primary">Create Account</button>
    </form>
</div>

<script>
    document.addEventListener("mousemove", function(event) {
        const bricks = document.querySelectorAll(".brick");
        bricks.forEach(brick => {
            const rect = brick.getBoundingClientRect();
            const dx = event.clientX - (rect.left + rect.width / 2);
            const dy = event.clientY - (rect.top + rect.height / 2);
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < 50) {
                brick.classList.add("glow");
            } else {
                brick.classList.remove("glow");
            }
        });
    });
</script>
@endsection
