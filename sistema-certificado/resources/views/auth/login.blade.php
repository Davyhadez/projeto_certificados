<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Certificados - DETRAN-PA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        detran: {
                            dark: '#004d40', 
                            hover: '#00332c',
                            bg: '#f4f7f6',   
                        }
                    }
                }
            }
        }
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
    <style>
        body { background-color: #f4f7f6; }
    </style>
</head>
<body class="text-gray-800 antialiased font-sans">

    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        
        <div class="w-full max-w-2xl bg-white p-6 md:p-8 rounded-lg shadow-xl border border-gray-200">

            <div class="text-center mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-detran-dark">Sistema de Certificados</h1>
                <p class="text-gray-600">Departamento de Trânsito do Pará</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded text-red-700 shadow-inner">
                    <p class="font-bold">Atenção:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section>
                <h2 class="text-xl font-semibold text-center text-gray-700 mb-6">Informe seus dados para acesso</h2>
                
                <form action="{{ route('login') }}" method="POST" class="space-y-5 max-w-md mx-auto">
                    @csrf
                    
                    <div>
                        <label for="login_usuario" class="block text-sm font-medium text-gray-700 mb-1">Login</label>
                        <input 
                            type="text" 
                            name="login_usuario" 
                            id="login_usuario" 
                            placeholder="Digite seu usuário" 
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-detran-dark focus:border-detran-dark transition"
                        />
                    </div>

                    <div>
                        <label for="senha_usuario" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password" 
                                id="senha_usuario" 
                                required
                                placeholder="Digite sua senha"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-detran-dark focus:border-detran-dark transition pr-10"
                            />
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-detran-dark hover:text-detran-hover focus:outline-none">
                                <i class="bi bi-eye-fill" id="icon-senha"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 text-center">
                        <button 
                            type="submit" 
                            class="w-full md:w-auto px-12 py-3 bg-detran-dark text-white font-bold rounded-lg uppercase tracking-wider hover:bg-detran-hover transition duration-200 shadow-md"
                        >
                            Entrar
                        </button>
                    </div>
                </form>
            </section>

            <div class="mt-12 pt-6 border-t border-gray-100 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} DETRAN-PA - Todos os direitos reservados<br>Desenvolvido pelo Departamento de Trânsito do Estado do Pará
            </div>

        </div>
    </div>

</body>
</html>