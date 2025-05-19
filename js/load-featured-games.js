const placeholders = document.querySelectorAll(".featured-games .game-logo");

for(let i = 0; i < placeholders.length; i++){
    if (placeholders[i]) {
        placeholders[i].style.backgroundImage = `url("assets/images/featured-games/${i+1}.png")`;
    }
}