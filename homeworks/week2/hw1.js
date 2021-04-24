function printStars(n) {
  const stars = "*\n";
  console.log(stars.repeat(n));
}

function printStars(n) {
  while(n > 0) {
    console.log("*");
    n--;
  }
}

printStars(5);