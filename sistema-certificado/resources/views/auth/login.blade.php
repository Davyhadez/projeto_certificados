<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Certificados</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 flex items-center justify-center h-screen">
    <body class="bg-gray-200 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-96 border-t-4 border-teal-800">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Acesso ao Sistema</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Login:</label>
                <input type="text" name="login_usuario" class="w-full p-2 border rounded focus:ring-2 focus:ring-teal-500 outline-none">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Senha:</label>
                <input type="password" name="password" class="w-full p-2 border rounded focus:ring-2 focus:ring-teal-500 outline-none">
            </div>

            <button type="submit" class="w-full bg-teal-800 text-white font-bold py-2 rounded hover:bg-teal-700 transition duration-200">
                ENTRAR
            </button>

            @if ($errors->any())
                <div class="mt-4 p-2 bg-red-100 text-red-600 text-sm rounded text-center">
                    {{ $errors->first() }}
                </div>
            @endif
        </form>
    </div>
</body>
</html>