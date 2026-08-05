<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $u = App\Models\Usuario::where('id_tipo_usuario', 3)->first();
    if($u) {
        $u->delete();
        echo "Deletado com sucesso!";
    } else {
        echo "Usuário Gabinete não encontrado";
    }
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
