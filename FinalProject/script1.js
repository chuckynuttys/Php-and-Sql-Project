const arrowBtns2 = document.querySelectorAll(".button i");
const image = document.querySelector(".button img");
var hiddenInput = document.getElementById("hiddenValue");
arrowBtns2.forEach(btn => {
    console.log(btn.id);
    btn.addEventListener("click", () => {
     // Get the current sprite number from the src attribute
    var src = image.src;
    var spriteNumber = parseInt(src.match(/sprite(\d+)/)[1]);
  if(btn.id === "left1"){
      
  
     // Update the sprite number
     if(spriteNumber != 1){
    spriteNumber -= 1;
     }
     else{
        spriteNumber = 7;
     }
  // Set the new src attribute with the updated sprite number
  
  }else{
    if(spriteNumber != 7)
    spriteNumber += 1;
else{
    spriteNumber = 1;
}
  }
  image.src = "image/sprite" + spriteNumber + ".png";


  hiddenInput.value = spriteNumber;
    })
});

function moveArrows(){
  var left1 = document.getElementById('left1');
var right1 = document.getElementById('right1');
  left1.removeAttribute('left1'); // Remove original class
  left1.setAttribute('id','left2'); // Add new class
  right1.removeAttribute('right'); // Remove original class
  right1.setAttribute('id','right2'); // Add new class
  console.log('Works!');
};




