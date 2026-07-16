<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Certificado DETRAN-PA</title>
    <style>
        @page {
            size: a4 landscape;
            margin: 25mm 35mm 20mm 35mm; 
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            color: #000000;
            background-color: #ffffff;
            line-height: 1.5;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1mm;
        }
        .header-table td {
            border: none;
            vertical-align: middle;
            width: 50%; 
        }
        .td-direita {
            text-align: right;
        }
        .logo-detran, .logo-governo { 
            height: 120px; 
            max-width: 100%;
            object-fit: contain; 
        }

        .content {
            text-align: center;
            width: 100%;
        }
        .titulo {
            font-size: 36pt;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 3mm;
            font-family: times, Times New Roman, serif;
        }
        .nome-aluno {
            font-size: 22pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3mm;
            font-family: Arial, sans-serif;
        }
        .texto-principal {
            font-size: 18pt;
            line-height: 1.8;
            text-align: center; 
            color: #222222;
            margin-bottom: 15mm;
            font-family: Arial, sans-serif;
        }
        .destaque {
            font-weight: bold;
        }

        .footer-frente {
            text-align: center;
            width: 100%;
            margin-top: 10mm;
        }
        .data-emissao {
            font-size: 19pt;
            margin-bottom: 60mm;
            font-family: Arial, sans-serif;
        }
        .assinatura-container {
            display: inline-block;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .linha-assinatura {
            width: 250px;
            border-top: 1px solid #000000;
            margin: 4px auto;
        }
        .cargo {
            font-size: 11pt;
            color: #333333;
        }

        .page-break {
            page-break-after: always;
        }
        .container-verso {
            position: relative;
            width: 100%;
            text-align: center;
            min-height: 145mm;
            padding-top: 10mm;
            padding-bottom: 20mm; 
        }
        .titulo-verso {
            font-size: 26pt;
            font-weight: bold;
            text-align: center;
            margin-top: 0;
            margin-bottom: 5mm;
            font-family: Arial, sans-serif;
        }
        .table-grade {
            width: 85%; 
            margin: 0 auto; 
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            page-break-inside: auto;
        }
        .table-grade th, .table-grade td {
            border: 1px solid #000000;
            padding: 10px;
            text-align: center;
            font-size: 11pt;
        }
        .table-grade th {
            font-weight: bold;
            text-transform: uppercase;
        }
        .table-grade tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        .total-row {
            font-weight: bold;
            page-break-inside: avoid;
        }
        .rodape-autenticacao {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12pt;
            color: #444444;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td><img src="https://www.motoragora.com.br/wp-content/uploads/2023/01/Detran-PA-1024x576.jpg" class="logo-detran" alt="DETRAN-PA"></td>
            <td class="td-direita"><img src="https://imgs.search.brave.com/xkf8MIiM7RsGA8mPyi-eotAumNeIcaUmByVlIEioXGg/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/YnJhbmRmZXRjaC5p/by9pZEZvbk1BSUJO/L3cvNDAwL2gvNDAw/L3RoZW1lL2Rhcmsv/aWNvbi5qcGVnP2M9/MWJ4aWQ2NE11cDdh/Y3pld1NBWU1YJnQ9/MTY5MzI2NDUwNTA0/NQ" class="logo-governo" alt="Governo do Pará"></td>
        </tr>
    </table>
    
    <div class="content">
        <div class="titulo">CERTIFICADO</div>
        <div class="nome-aluno">{{ $dados['nome_completo'] }}</div>
        <p class="texto-principal">
            Participou como <span class="destaque">{{ $dados['tipo_participacao'] }}</span> do curso de <span class="destaque">{{ $dados['curso'] }}</span>, realizado <br> pelo Departamento de Trânsito do Estado do Pará (DETRAN/PA), no município de <br> <span class="destaque">{{ $dados['municipio'] }}</span>, no período de <span class="destaque">{{ $dados['data_inicio'] }}</span> a <span class="destaque">{{ $dados['data_fim'] }}</span>, com carga horária de <span class="destaque">{{ $dados['carga_horaria'] }} horas/aulas</span>.
        </p>
    </div>

    <div class="footer-frente">
        <div class="data-emissao">Belém-PA, {{ $dados['data_emissao'] }}</div>
        <div class="assinatura-container">
            <span class="destaque" style="font-size: 11pt;">RENATA MIRELLA FREITAS GUIMARÃES DE SOUZA COELHO</span>
            <div class="linha-assinatura"></div>
            <div class="cargo">Diretora Geral - DETRAN/PA</div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="container-verso">
        <div class="titulo-verso">GRADE CURRICULAR DO CURSO</div>
        
        <table class="table-grade">
            <thead>
                <tr>
                    <th style="width: 25%;">Módulos</th>
                    <th style="width: 50%;">Conteúdos</th>
                    <th style="width: 25%;">Carg. Horária</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($dados['disciplinas']) && count($dados['disciplinas']) > 0)
                    @foreach($dados['disciplinas'] as $disciplina)
                    <tr>
                        <td class="destaque">{{ $disciplina->nome_disciplina }}</td>
                        <td>{{ $disciplina->conteudo ?? '-' }}</td>
                        <td>{{ $disciplina->carga_horaria }} h/a</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Total</td>
                        <td>-</td>
                        <td>{{ $dados['carga_horaria'] }} h/a</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="3" style="text-align: center; color: #666;">Sem disciplinas cadastradas</td>
                    </tr>
                    <tr class="total-row">
                        <td>Total</td>
                        <td>-</td>
                        <td>{{ $dados['carga_horaria'] }} h/a</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="rodape-autenticacao">
            Para confirmar a autenticidade deste certificado acesse www.detran.pa.gov.br/consultacertificado e informe o código: {{ $dados['codigo_validacao'] }}
        </div>
    </div>

</body>
</html>