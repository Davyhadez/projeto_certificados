<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Certificados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        function togglePassword() {
            const inputSenha = document.getElementById('senha_usuario');
            const icone = document.getElementById('icon-senha');

            if (inputSenha.type === 'password') {
                inputSenha.type = 'text';
                icone.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                inputSenha.type = 'password';
                icone.classList.replace('bi-eye-slash-fill', 'bi-eye-fill')
            }
        }
    </script>
    
</head>

<body class="bg-gray-200 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-xl shadow-2xl w-96 border-t-4 border-teal-800">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Acesso ao Sistema de Certificados</h2>

        <form action="{{ route('login') }}" method="POST">

            @csrf
            <div class="mb-4">

                <label for="login_usuario" class="block text-gray-700 text-sm font-bold mb-2">Login:</label>
                <input type="password" name="login_usuario" id="login_usuario" class="w-full p-2 border rounded 
                focus:ring-2 focus:ring-teal-500 outline-none transition-all" placeholder="Digite seu usuário">

            </div>

            <div class="mb-4">

                <label for="senha_usuario" class="block text-gray-700 text-sm font-bold mb-2">Senha:</label>
                <div class="relative">
                    <input type="password" name="password" id="senha_usuario" class="w-full p-2 px-4 py-2 border rounded
                    focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all" placeholder="Digite sua senha">

                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-teal-600 hover:text-teal-800">
                        <i class="bi bi-eye-fill" id="icon-senha"></i>
                    </button>
                </div>

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