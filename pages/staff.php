<div class="container">
    <div class="title">
        <h1>STAFF</h1>
    </div>

    <?php
        // get all categories
        $categories = [];
        $categoriesQuery = $db->query("SELECT id, nome, lowercase FROM categoriasstaff ORDER BY id");
        
        if (!$categoriesQuery) {
            echo "<h1 class='warning'>Erro ao carregar categorias!</h1>";
        } else if ($categoriesQuery->num_rows == 0) {
            echo "<h1 class='warning'>Nenhuma categoria encontrada</h1>";
        } else {
            
            while ($category = $categoriesQuery->fetch_assoc()) {
                $categories[] = $category;
            }
            
            // generate category tabs
            echo "<div class='tabs-wrapper'><div class='category-tabs'>";
            foreach ($categories as $index => $category) {
                $checked = ($index == 0) ? " checked" : "";
                echo "<input type='radio' name='category' id='radio-{$category['lowercase']}' 
                      value='{$category['lowercase']}'{$checked}>";
                echo "<label for='radio-{$category['lowercase']}'>{$category['nome']}</label>";
            }
            echo "</div></div>";
            
            // generate category content containers
            foreach ($categories as $index => $category) {
                $activeClass = ($index == 0) ? " active" : "";
                echo "<div class='category{$activeClass}' id='{$category['lowercase']}'>";
                
                // get subcategories for this category
                $subcategoriesQuery = $db->query("SELECT id, nome, lowercase 
                                                 FROM subcategoriasstaff 
                                                 WHERE id_categoria = {$category['id']} 
                                                 ORDER BY id");
                
                if (!$subcategoriesQuery) {
                    echo "<h1 class='warning'>Erro ao carregar subcategorias!</h1>";
                } else if ($subcategoriesQuery->num_rows == 0) {
                    echo "<h1 class='warning'>Nenhuma subcategoria encontrada para {$category['nome']}</h1>";
                } else {
                    // generate subcategory tabs
                    echo "<div class='tabs-wrapper'><div class='subcategory-tabs'>";
                    $firstSubcategory = true;
                    $subcategories = [];
                    
                    while ($subcategory = $subcategoriesQuery->fetch_assoc()) {
                        $subcategories[] = $subcategory;
                        $checked = ($firstSubcategory) ? " checked" : "";
                        
                        echo "<input type='radio' id='radio-{$subcategory['lowercase']}' 
                              name='{$category['lowercase']}-sub' 
                              value='{$subcategory['lowercase']}'{$checked}>";
                        echo "<label for='radio-{$subcategory['lowercase']}'>{$subcategory['nome']}</label>";
                        
                        $firstSubcategory = false;
                    }
                    echo "</div></div>";
                    
                    // generate subcategory content containers
                    foreach ($subcategories as $subIndex => $subcategory) {
                        $activeClass = ($subIndex == 0) ? " active" : "";
                        echo "<div class='subcategory{$activeClass}' id='{$subcategory['lowercase']}'>";
                        
                        // show coordinator for this subcategory
                        $coordinatorQuery = $db->query("
                            SELECT u.id, u.username, u.imagem, u.email
                            FROM membrostaff m
                            JOIN utilizadores u ON m.id_utilizador = u.id
                            WHERE m.id_subcategoria = {$subcategory['id']}
                            AND m.tipo = 'coordenador'
                            LIMIT 1
                        ");
                        
                        if ($coordinatorQuery && $coordinatorQuery->num_rows > 0) {
                            $coordinator = $coordinatorQuery->fetch_assoc();
                            
                            echo "<div class='card coordinator'>
                                    <div class='person'>
                                        <div class='avatar'>";
                            
                            $imagePath = getUserImage($coordinator['id']);
                            
                            echo "<img src='{$imagePath}' alt='{$coordinator['username']}'>";
                            
                            echo "</div>
                                <div class='person-info'>
                                    <h3>{$coordinator['username']}</h3>
                                    <h5>Coordenador</h5>
                                </div>
                            </div>
                          </div>";
                        }
                        
                        // show members for this subcategory
                        $membersQuery = $db->query("
                            SELECT u.id, u.username, u.imagem
                            FROM membrostaff m
                            JOIN utilizadores u ON m.id_utilizador = u.id
                            WHERE m.id_subcategoria = {$subcategory['id']}
                            AND m.tipo = 'membro'
                            ORDER BY u.username
                        ");
                        
                        if ($membersQuery && $membersQuery->num_rows > 0) {
                            echo "<div class='members-grid'>";
                            
                            while ($member = $membersQuery->fetch_assoc()) {
                                $imagePath = getUserImage($member['id']);
                                
                                echo "<div class='card'>
                                        <div class='person'>
                                            <div class='avatar'>
                                                <img src='{$imagePath}' alt='{$member['username']}'>
                                            </div>
                                            <div class='person-info'>
                                                <h3>{$member['username']}</h3>
                                                <h5>Membro</h5>
                                            </div>
                                        </div>
                                      </div>";
                            }
                            
                            echo "</div>"; // close members-grid
                        } else {
                            echo "<p>Nenhum membro encontrado para esta subcategoria.</p>";
                        }
                        
                        echo "</div>"; // close subcategory
                    }
                }
                
                echo "</div>"; // close category
            }
        }
    ?>
</div>