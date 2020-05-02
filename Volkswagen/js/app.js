
    // smooth scroll
    $("[data-scroll]").on("click", function (event) {

        event.preventDefault();

        let blockId = $(this).data('scroll');
        let elementOffset = $(blockId).offset().top;
      

        $("html, body").animate({
            scrollTop: elementOffset
        }, 500)





    });




    function My_function() {
        document.getElementById("submenu").classList.toggle("show");
    }
    
    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.intro__item')) {
    
        let submenu = document.getElementsByClassName("submenu");
    
        for ( let i = 0; i < submenu.length; i++) {
          var openDropdown = submenu[i];
          if (openDropdown.classList.contains('show')) {
            
          }
        }
      }
    }

    
    let slideIndex = 1;
    showDivs(slideIndex);
    
    function plusDivs(n) {
      showDivs(slideIndex += n);
    }
    
   
    
    function showDivs(n) {
       
        let x = document.getElementsByClassName("visitingCard");
        if (n > x.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = x.length}
        for ( let i = 0; i < x.length; i++) {
          x[i].style.display = "none";  
        }
        x[slideIndex-1].style.display = "block";  

      }






    



  
    