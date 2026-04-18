<?php
$f = 'app/Views/templates/sidebar.php';
$c = file_get_contents($f);
$t = '<li class="nav-header">ACESSO DESTRAVADO</li>';
$r = '<?php if (isset($controle_de_acesso) && $controle_de_acesso["usuarios"] == 1) : ?>' . "\n                        " . $t;

if (strpos($c, $t) !== false && strpos($c, 'isset($controle_de_acesso)') === false) {
    $c = str_replace($t, $r, $c);
    file_put_contents($f, $c);
    echo "SUCCESS: Sidebar fixed.";
} else {
    echo "ERROR: Target not found or already fixed.";
}
