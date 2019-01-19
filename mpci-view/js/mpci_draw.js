/*
	This function is use in drawing in html
*/
function draw() {
	// get the canvas id
    var canvas = document.getElementById("canvas");
    if (canvas.getContext) {
        var ctx = canvas.getContext("2d");
    }

	drawImage(ctx);
	
}

function drawImage(context){
    var image = new Image();
	var x = 0;
	var y = 0;
	
	//we get the path from the html input
    image.src = getImagePath(image); 
    image.onload = function() {
        context.drawImage(image, x, y);
    };
}

function getImagePath(image){
	image.src = "mpci-view/images/products/business_cards/Abstract Design/businesscard.png";
	return image.src;
}

