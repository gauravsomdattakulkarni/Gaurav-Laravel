<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>POS Login</title>
	<style>
		* { box-sizing: border-box; }
		body {
			min-height: 100vh;
			margin: 0;
			padding: 24px;
			display: grid;
			place-items: center;
			background: #eff8ff;
			color: #17324d;
			font-family: Arial, Helvetica, sans-serif;
		}
		.login-card {
			width: min(100%, 420px);
			padding: 36px;
			background: #fff;
			border: 1px solid #d9ebf8;
			border-radius: 16px;
			box-shadow: 0 14px 40px rgba(42, 112, 157, .12);
		}
		h1 { margin: 0 0 8px; font-size: 28px; }
		.subtitle { margin: 0 0 26px; color: #657f94; line-height: 1.5; }
		.form-group { margin-bottom: 19px; }
		label { display: block; margin-bottom: 8px; font-weight: 600; }
		input {
			width: 100%;
			padding: 12px 14px;
			border: 1px solid #c9dce9;
			border-radius: 8px;
			background: #fff;
			color: #17324d;
			font: inherit;
		}
		input:focus { outline: 3px solid #d8efff; border-color: #399bd4; }
		input[aria-invalid="true"] { border-color: #c93645; }
		.field-error { margin: 7px 0 0; color: #b42332; font-size: 14px; }
		.alert { margin-bottom: 20px; padding: 12px 14px; border-radius: 8px; line-height: 1.45; }
		.alert-success { color: #17633a; background: #e9f8ef; border: 1px solid #bce8cb; }
		.alert-error { color: #9f2633; background: #fff0f1; border: 1px solid #f2c4c8; }
		.alert ul { margin: 6px 0 0; padding-left: 20px; }
		button {
			width: 100%;
			padding: 13px 16px;
			border: 0;
			border-radius: 8px;
			background: #278bc5;
			color: #fff;
			font: inherit;
			font-weight: 700;
			cursor: pointer;
		}
		button:hover { background: #1977ad; }
		button:focus-visible { outline: 3px solid #a9ddf8; outline-offset: 3px; }
		@media (max-width: 480px) { .login-card { padding: 28px 22px; } }
	</style>
</head>
<body>
	<main class="login-card">
		<h1>POS Login</h1>
		<p class="subtitle">Enter your username and password to continue.</p>

		@if (session('success'))
			<div class="alert alert-success" role="status">{{ session('success') }}</div>
		@endif

		@if (session('error'))
			<div class="alert alert-error" role="alert">{{ session('error') }}</div>
		@endif

		@if ($errors->any())
			<div class="alert alert-error" role="alert">
				<strong>Please correct the following:</strong>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form action="{{ url('pos_login_success') }}" method="get">
			
			<div class="form-group">
				<label for="username">Username</label>
				<input
					id="username"
					name="username"
					type="text"
					value="{{ old('username') }}"
					autocomplete="username"
					maxlength="255"
					required
					autofocus
					aria-invalid="@error('username') true @else false @enderror"
					@error('username') aria-describedby="username-error" @enderror
				>
				@error('username')
					<p class="field-error" id="username-error">{{ $message }}</p>
				@enderror
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input
					id="password"
					name="password"
					type="password"
					autocomplete="current-password"
					required
					aria-invalid="@error('password') true @else false @enderror"
					@error('password') aria-describedby="password-error" @enderror
				>
				@error('password')
					<p class="field-error" id="password-error">{{ $message }}</p>
				@enderror
			</div>

			<button type="submit">Sign in</button>
		</form>
	</main>
</body>
</html>
