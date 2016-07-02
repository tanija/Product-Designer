jQuery(document).ready(function($){
    
    
    var canvas_product = $('#playground');
    var container = $(canvas_product).parent();
    var canvas_knobs = $('#knobs-playground');
    var knobsImgReady= false;
    
    var productName='';
    var img_first = new Image();
    var rotatePoductDegr = 0;

    //Run function when browser resizes
    $(window).resize( respondCanvas );

    function respondCanvas(){ 
        canvas_product.attr('width', $(container).width() ); //max width
        canvas_product.attr('height', $(container).width() ); //max height
        canvas_knobs.attr('width', $(container).width() ); //max width
        canvas_knobs.attr('height', $(container).width() ); //max height
    }

    //Initial call 
    respondCanvas();
    
    var canvasSize = $(container).width();
    var canvasHalfSize = canvasSize/2;

    
    var countAccessoires = 0;
    var isProductSelected= false;
    var ALERT_TITLE = "Oops!";
    var ALERT_BUTTON_TEXT = "Ok";
    
    
if(document.getElementById) {
    window.alert = function(txt) {
        createCustomAlert(txt);
    }
}

function createCustomAlert(txt) {
    d = document;

    if(d.getElementById("modalContainer")) return;

    mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
    mObj.id = "modalContainer";
    mObj.style.height = d.documentElement.scrollHeight + "px";

    alertObj = mObj.appendChild(d.createElement("div"));
    alertObj.id = "alertBox";
    if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
    alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
    alertObj.style.visiblity="visible";

    h1 = alertObj.appendChild(d.createElement("h1"));
    h1.appendChild(d.createTextNode(ALERT_TITLE));

    msg = alertObj.appendChild(d.createElement("p"));
    //msg.appendChild(d.createTextNode(txt));
    msg.innerHTML = txt;

    btn = alertObj.appendChild(d.createElement("a"));
    btn.id = "closeBtn";
    btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
    btn.href = "#";
    btn.focus();
    btn.onclick = function() { removeCustomAlert();return false; }

    alertObj.style.display = "block";

}

function removeCustomAlert() {
    document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
}

        
   setTimeout(function() {
        $('.product-list img:first-child').trigger('click');
    },20);
    
    
$(document).on('click', '.product-list img', function () {  
     
     countAccessoires = 0;
       rotatePoductDegr = 0;
    $('#playground').removeLayer('product_style');
     $('#playground').removeLayer('product-first-style');

        $product_id = this.id;
        $('#cart-button').empty();
        $('#cart-button').append('<input type="button" class="add-to-cart" value="Add to cart">');
        
        $.ajax(
                         {
                 type: 'POST',
                 url: woo_product_designer_ajax.woo_product_designer_ajaxurl,
                 data: {
                     action:'product_designer_get_products_styles_list_ajax', 
                     product_id: $product_id
                 },
                 dataType: "json",
                 success: function(data)
                                 {
                                     $price =data[0];
                                     productName =data[1];
                                     $styles = data[2];
                                    
                                   if(productName=='Диадема'){
                                      rotatePoductDegr = -70;
                                      }
                                
                                
                                    $(".styles-list").empty();
                                    $(".styles-list").append($styles);
                                    $(".product-name").empty();
                                    $(".product-name").append(productName);
                                    $(".product-price").empty();
                                    $(".product-price").append("Цена: "+$price+" лв.");                          
                                     
                                    $bgn = $(".product-syles-item").css('background-image');                              $url = /url\(\s*(['"]?)(.*?)\1\s*\)/g.exec($bgn)[2];
                                                                                                           
                                    img_first.src = $url;
                                     
                                     $('canvas#playground').addLayer({
                                          type: 'image',
                                          name: 'product-first-style',
                                          source: img_first,
                                          rotate: rotatePoductDegr,
                                          
                                          draggable: false,
                                          x: canvasHalfSize, y: canvasHalfSize,
                                        imageSmoothing : false,
                                        }).drawLayers();
                                     
                                     
                                    $(document).on('click', '.add-to-cart', function () {
                                        
//                                         var knobsUrl = $('canvas#knobs-playground').toDataURL();
                                        
                                        var knobsCanvas = document.getElementById("knobs-playground");
                                        var knobsUrl = knobsCanvas.toDataURL("image/png");
                                          var img_knob = new Image();
                                          img_knob.src = knobsUrl ;
                                        knobsImgReady =true;
//                                          $('canvas#playground').addLayer({
//                                               type: 'image',
//                                               source: knobsUrl,
//                                               x: canvasHalfSize, y: canvasHalfSize,
//                                            }).drawLayers();
                                        
                                        //$imgData = $('canvas#playground').toDataURL();
                                        if (knobsImgReady){
                                        var productCanvas = document.getElementById("playground");
                                        var ctx=productCanvas.getContext("2d");   
                                        ctx.drawImage(img_knob,0,0);
                                        var $imgData = productCanvas.toDataURL("image/png");
                                          
                                        $.ajax({
                                                type: "POST",
                                                url: woo_product_designer_ajax.woo_product_designer_ajaxurl,
                                                data:{
                                                    action:'product_designer_sent_product_to_cart_ajax',            
                                                    name: $name,
                                                    price: $price, 
                                                    id:    $product_id,
                                                    imageURL: $imgData
                                                    
                                                },
                                                success: function(data)
                                                                 {
                                                                  location.reload();                                
                                                                 }                         

                                         });
                                        }

                                      });        
                                 }                           
                         });
    });
                
   
    $(document).on('click', '.product-syles-item', function () {              
        $product_id = this.id;
        $.ajax(
                {
                 type: 'POST',
                 url: woo_product_designer_ajax.woo_product_designer_ajaxurl,
                 data: {
                     action:'product_designer_get_product_style_ajax', 
                     product_id: $product_id
                 },
                 success: function(data)
                                 {  
                                   var img = new Image();
                                   img.src = data ;
                                    
                                 $('#playground').removeLayer('product_style');
                                $('#playground').removeLayer('product-first-style');
                                     
                                $('#playground').addLayer({
                                      type: 'image',
                                      name: 'product_style',
                                      source: img.src,
                                      rotate: rotatePoductDegr,
                                      draggable: false,
                                      
                                      x: canvasHalfSize, y: canvasHalfSize,
                                      imageSmoothing : false,
                                  }).drawLayers();
                              }                           
                         });      
                
    });

    
    $(document).on('click', '.accessoires img', function () {
        
        var countKnobsOfproduct= 1;
        var knobX;
        var knobY;
        if(productName=='Диадема'){
            countKnobsOfproduct= 3;
        }
        if(countAccessoires < countKnobsOfproduct){
            
            countAccessoires++;
            
            switch(countAccessoires){
                case 1: 
                   $knobX = $knobY = canvasHalfSize;
                    break;
                case 2: 
                   $knobX += 36;
                   $knobY -= 80;
                    break;
                case 3: 
                   $knobX -= 70;
                   $knobY +=160;
                    break; 
            }            
            
            var img = new Image();
            img.src = this.src ;           
            
            $('#knobs-playground').addLayer({
                      type: 'image',
                      name: 'access'+countAccessoires,
                      source: img.src,  
                      draggable: true,
                      rotate: -60,
                      shadowColor: '#000',
                      shadowBlur: 10,
                      shadowX: -5, shadowY: 5,
                      x: $knobX, y: $knobY,
                      width: canvasSize*0.22, height: canvasSize*0.22,
                      imageSmoothing : false,
                      mouseover: function(layer) {
                             var knob = layer;
                             $(this).drawText({ 
                                      name: 'X',
                                      layer:true,
                                      text: 'X',
                                      fillStyle: '#a30505',
                                      x: layer.x +10, y:  layer.y-10,
                                      fontSize: 12,
                                      fontFamily: 'Ariel,bold, sans-serif',
                                      click: function(layer) {
                                         $(this).removeLayer(knob);
                                         $(this).removeLayer(layer);
                                          countAccessoires--;
                                        }
                          });
                     },
                        mouseout: function(layer){
                            $(this).removeLayer('X');
                        }, 
                        click:function(layer){
                            $(this).removeLayer('X');
                        }, 
                
                    }).drawLayers();
            
        }else{
          
           createCustomAlert("С повече от 3 копчета диадемите не са красиви!!!");
        
        }
    });
    
})