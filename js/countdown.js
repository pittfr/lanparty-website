const days = document.querySelector(".countdown .days");
const hours = document.querySelector(".countdown .hours");
const minutes = document.querySelector(".countdown .minutes");
const seconds = document.querySelector(".countdown .seconds");

const targetDate = "2025-12-25"; // (YYYY-MM-DD)

function updateCountdown() {
    const now = new Date();
    
    const target = new Date(targetDate);

    const diff = target - now; // miliseconds
    
    // if the date is in the past, stop the countdown
    if (diff <= 0) {
        days.textContent = "00";
        hours.textContent = "00";
        minutes.textContent = "00";
        seconds.textContent = "00";
        return;
    }
    
    // calculate the time units
    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
    const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const s = Math.floor((diff % (1000 * 60)) / 1000);

    days.textContent = d.toString().padStart(2, "0");
    hours.textContent = h.toString().padStart(2, "0");
    minutes.textContent = m.toString().padStart(2, "0");
    seconds.textContent = s.toString().padStart(2, "0");
}

updateCountdown();

setInterval(updateCountdown, 1000);