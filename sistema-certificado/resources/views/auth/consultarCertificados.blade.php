<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Certificados - DETRAN-PA</title>
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
    </script>
    <style>
        body { background-color: #f4f7f6; }
    </style>
</head>
<body class="text-gray-800 antialiased font-sans">

    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        
        <div class="w-full max-w-2xl bg-white p-6 md:p-8 rounded-lg shadow-xl border border-gray-200">

            <div class="text-center mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-detran-dark">Consulta de Certificados</h1>
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

            @if(!isset($pessoa))
                <section>
                    <h2 class="text-xl font-semibold text-center text-gray-700 mb-6">Informe seus dados para acesso</h2>
                    
                    <form action="{{ route('certificados.consultar') }}" method="POST" class="space-y-5 max-w-md mx-auto">
                        @csrf
                        
                        <!-- Input CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                            <input 
                                type="text" 
                                id="cpf" 
                                name="cpf" 
                                placeholder="000.000.000-00" 
                                required
                                value="{{ old('cpf') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-detran-dark focus:border-detran-dark transition"
                            />
                        </div>

                        <div>
                            <label for="data_nascimento" class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento</label>
                            <input 
                                type="date" 
                                id="data_nascimento" 
                                name="data_nascimento" 
                                required
                                value="{{ old('data_nascimento') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-detran-dark focus:border-detran-dark transition"
                            />
                        </div>

                        <div class="pt-4 text-center">
                            <button 
                                type="submit" 
                                class="w-full md:w-auto px-12 py-3 bg-detran-dark text-white font-bold rounded-lg uppercase tracking-wider hover:bg-detran-hover transition duration-200 shadow-md"
                            >
                                Consultar
                            </button>
                        </div>
                    </form>
                </section>

            @else
                <section>
                    <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-detran-dark">Meus Certificados</h2>
                        <a href="{{ route('certificados.index') }}" class="text-sm text-gray-500 hover:text-detran-dark underline">
                            &#8592; Nova Consulta
                        </a>
                    </div>

                    <div class="mb-8 p-5 bg-gray-50 rounded-lg border border-gray-100 space-y-1.5 text-gray-700">
                        <p><span class="font-bold text-gray-800">Nome:</span> {{ strtoupper($pessoa->nome_pessoa) }}</p>
                        <p><span class="font-bold text-gray-800">CPF:</span> {{ $pessoa->cpf }}</p>
                        <p><span class="font-bold text-gray-800">Data Nascimento:</span> {{ \Carbon\Carbon::parse($pessoa->data_nascimento)->format('d/m/Y') }}</p>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm">
                        <table class="w-full border-collapse text-center text-sm md:text-base">
                            <thead class="bg-gray-200 text-detran-dark font-bold">
                                <tr>
                                    <th class="py-3 px-4 border-r border-gray-300">Curso</th>
                                    <th class="py-3 px-4 border-r border-gray-300">Data Realização</th>
                                    <th class="py-3 px-4">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($certificados as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-4 border-r border-gray-200 font-medium text-gray-800">
                                            {{ $item->turma->evento->nome_evento ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-4 border-r border-gray-200 text-gray-600">
                                            {{ $item->turma->data_fim ? \Carbon\Carbon::parse($item->turma->data_fim)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($item->turma && $item->turma->certificado_liberado)
                                                <a 
                                                    href="{{ route('certificado.emitir', $pessoa->id_pessoa) }}?turma={{ $item->id_turma }}&tipo=aluno" 
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 font-semibold hover:underline"
                                                >
                                                    Imprimir
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic text-sm">Certificado não liberado</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-10 text-center text-gray-500">
                                            Nenhum certificado encontrado para este CPF.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif

            <div class="mt-12 pt-6 border-t border-gray-100 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} DETRAN-PA -  Todos os direitos reservados Desenvolvido pelo Departamento de Trânsito do Estado do Pará
            </div>

        </div>
    </div>

</body>
</html>