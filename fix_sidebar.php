<?php
$f = 'app/Views/templates/sidebar.php';
$c = file_get_contents($f);
$t = '<!-- <?php if (';
$pos = strpos($c, $t);
if($pos !== false){
    $pre = substr($c, 0, $pos);
    $post = substr($c, $pos);
    $new = '
                    <?php if (isset($controle_de_acesso) && $controle_de_acesso["usuarios"] == 1) : ?>
                        <li class="nav-header">ACESSO DESTRAVADO</li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" style="background: linear-gradient(135deg, #660F56 0%, #9b1b82 100%); color: white !important; border-radius: 8px; margin: 4px 8px; box-shadow: 0 4px 10px rgba(102, 15, 86, 0.3);">
                                <i class="nav-icon fas fa-unlock-alt"></i>
                                <p>
                                    Gest&atilde;o Completa
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/funcionarios" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>🛡️ Funcion&aacute;rios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/login/usuarios" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>🔑 Usu&aacute;rios (Acessos)</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/caixas" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>💰 Caixas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/clientes" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>👥 Clientes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/produtos" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>📦 Produtos e Estoque</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
    ';
    file_put_contents($f, $pre . $new . $post);
    echo "SUCCESS";
}
