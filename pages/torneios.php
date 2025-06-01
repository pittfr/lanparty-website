<div class="container">
    <div class="title">
        <h1>TORNEIOS</h1>
    </div>
    <div class="games-container">
        

            <?php
                $q = "SELECT j.nome, j.imagem, j.genero, j.membros, (t.vagas - COUNT(e.id)) AS vagas_livres FROM torneios t JOIN jogos j on t.id_jogo = j.id LEFT JOIN equipas e on e.id_torneio = t.id GROUP BY j.nome, j.imagem, j.genero, j.membros";

                $procura = $db->query($q);

                if(!$procura){
                    echo "<h1 class='warning'>Erro ao carregar jogos!</h1>";
                }else{
                    if($procura->num_rows == 0){
                        echo "<h1 class='warning'>Nenhum torneio encontrado</h1>";
                    }else{
                        while($reg = $procura->fetch_object()){
                            echo "<ul class='games'>";
                            $t = gameThumbnail($reg->imagem);
                            if ($reg->vagas_livres == 0){
                                echo "<li class='game-card full'>";
                            }else{
                                echo "<li class='game-card'>";
                            }
                            if ($reg->vagas_livres <= 5){
                                if ($reg->vagas_livres == 1){
                                    echo "<span class='spots-left'>$reg->vagas_livres VAGA DISPONÍVEL</span>";
                                }else{
                                    echo "<span class='spots-left'>$reg->vagas_livres VAGAS DISPONÍVEIS</span>";
                                }
                            }
                            echo "<img src='$t' alt='$reg->nome' class='logo'>";
                            echo "<div class='game-details'>";
                            echo "<h2 class='title'>$reg->nome</h2>";
                            echo "<p class='categories'>$reg->genero</p>";
                            if ($reg->membros == 1){
                                echo "<label class='players-info'><span>$reg->membros membro por equipa</span></label>";
                            }else{
                                echo "<label class='players-info'><span>$reg->membros membros por equipa</span></label>";
                            }
                            echo "<div class='option-buttons'>";
                            echo "<a href='#' class='join-game'>Entrar</a>";
                            echo "<a href='#' class='view-rules'>Ver Regras</a>";
                            echo "</div>";
                        }
                    }
                }
            ?>
    </div>
</div>