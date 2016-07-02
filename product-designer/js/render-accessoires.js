jQuery(document).ready(function($){
    
    $(document).on('change','select',function(){
     
        
                var term1 = $('.accessoires-cat1').val();
                var term2 = $('.accessoires-cat2').val();
         console.log(term1);
                 console.log(term2);

             $.ajax(
                         {
                 type: 'POST',
                 url: woo_product_designer_ajax.woo_product_designer_ajaxurl,
                 data: {
                     action:'product_designer_get_accessoires_list_by_cat', 
                     term1: term1,
                     term2: term2
                 },
                 success: function(data)
                                 {
                                    $(".accessoires").empty();
                                    $(".accessoires").append(data);  
                                     console.log(data);
                                  }

                         });
                 

		
	});
    
    

    
});

    //         function mouseDownHandler(e)
    //         {
    //            var x = e.pageX - e.target.offsetLeft;
    //            var y = e.pageY - e.target.offsetTop;
    //            for(var i = 0; i < theObjects.length;i++) {
    //               var theObject = theObjects[i];
    //               if (theObject.isInside({x:x,y:y})) {
    //                  dragging = true;
    //                  lastPoint.x = x;
    //                  lastPoint.y = y;
    //                  currentDragObject = theObject;
    //               }
    //            }
    //         }

    //         function mouseUpHandler(e)
    //         {
    //            dragging = false;
    //            lastPoint.x = -1;
    //            lastPoint.y = -1;
    //         }

    //         function moveHandler(e) {
    //            if (dragging) {
    //                var x = e.pageX - e.target.offsetLeft;
    //                var y = e.pageY - e.target.offsetTop;
    //                var deltaX = x - lastPoint.x;
    //                var deltaY = y - lastPoint.y;

                   
    //                currentDragObject.position.x += deltaX;
    //                currentDragObject.position.y += deltaY;
             
                   
    //                lastPoint.x = x;
    //                lastPoint.y = y;
    //                draw();
    //            }
    //         }
   

 

