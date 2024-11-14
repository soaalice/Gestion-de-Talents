// var declanche = document.getElementById('declancheur');
// declanche.addEventListener('click',function(){
//     var list = document.getElementById('lister');
//     if (list.classList.contains("positionning-down")) {        
//         list.classList.remove("positionning-down");
//         list.classList.add("positionning-high");   
//     } else {
//         list.classList.remove("positionning-high");
//         list.classList.add("positionning-down");
//     }
// });
// document.addEventListener('DOMContentLoaded', function () {


//     var boules = document.querySelectorAll('.moov');

//     var change = function(element) {
//         const childinput = element.querySelector('input');
//         if (childinput.value == 1) {
//             // element.classList.toggle('mooved');
//             element.classList.remove('bg-dark');
//             element.classList.add('bg-red');
//         } else if (childinput.value == 0) {
//             // element.classList.toggle('mooved');
//             // element.classList.add('mooved');
//             element.classList.remove('bg-red');
//             element.classList.add('bg-dark');
//         }
//     };

//     boules.forEach(function(element) {
//         // Initial change based on input value
//         change(element);
        
//         element.addEventListener('click', function() {
//         var childinput = element.querySelector('input');
//         var validbtn = document.getElementById('valid');
//             validbtn.addEventListener('click', function() {
//             if (childinput.value == 0) {
//                 childinput.value = 1;
//             } else {
//                 childinput.value = 0;
//             }
//             element.classList.toggle('mooved');
//             change(element);
//         });
//         });
//     });
// });
document.addEventListener('DOMContentLoaded', function () {
    var boules = document.querySelectorAll('.moov');
    var validbtn = document.getElementById('valid');
    var currentElement = null;

    var change = function(element) {
        const childinput = element.querySelector('input');
        // element.classList.toggle('mooved');
        if (childinput.value == 1) {
            element.classList.remove('bg-success');
            element.classList.add('mooved');
            element.classList.add('bg-red');
        } else if (childinput.value == 0) {
            element.classList.remove('bg-red');
            element.classList.remove('mooved');
            element.classList.add('bg-success');
        }
    };

    boules.forEach(function(element) {
        // Initial change based on input value
        change(element);

        element.addEventListener('click', function() {
            currentElement = element;
        });
    });

    validbtn.addEventListener('click', function() {
        if (currentElement) {
            var childinput = currentElement.querySelector('input');
            if (childinput.value == 0) {
                childinput.value = 1;
            } else {
                childinput.value = 0;
            }
            // currentElement.classList.toggle('mooved');
           
        }
    });
});

// var boules = document.querySelectorAll('.moov');
// for (let index = 0; index < boules.length; index++) {
//     const element = boules[index];
//     // const parent = element.parentNode;
//     const childinput = element.querySelector('input');
//     const validbtn = document.getElementById('valid');
//     var change = function() {
//         if (childinput.value == 0){
//             element.classList.toggle('mooved');
//         if(element.classList.contains('bg-dark')){
//             element.classList.remove('bg-dark');
//             element.classList.add('bg-red');
//         }
//     }else if (childinput.value == 1){
//             element.classList.toggle('mooved');
//         if(element.classList.contains('bg-red')){
//             element.classList.remove('bg-red');
//             element.classList.add('bg-dark');
//         }  
//     }
//     }
//     childinput.addEventListener('DOMContentLoaded', function () {
//         change();   
//     })
//     validbtn.addEventListener('click', function(){
//         if(childinput.value == 0){
//             childinput.value = 1;
//             change();
//         }else {
//             childinput.value = 0;
//             change();
//         }
//     });
//     // element.classList.toggle('mooved');
//     // if(element.classList.contains('bg-red')){
//     //     element.classList.remove('bg-red');
//     //     element.classList.add('bg-dark');
//     // }else if(element.classList.contains('bg-dark')){
//     //     element.classList.remove('bg-dark');
//     //     element.classList.add('bg-red');
//     // }
// }
document.addEventListener("DOMContentLoaded", function(event) {
   
    const showNavbar = (toggleId, navId, bodyId, headerId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId),
    bodypd = document.getElementById(bodyId),
    headerpd = document.getElementById(headerId)
    
    // Validate that all variables exist
    if(toggle && nav && bodypd && headerpd){
    toggle.addEventListener('click', ()=>{
    // show navbar
    nav.classList.toggle('show')
    // change icon
    toggle.classList.toggle('bx-x')
    // add padding to body
    bodypd.classList.toggle('body-pd')
    // add padding to header
    headerpd.classList.toggle('body-pd')
    })
    }
    }
    
    showNavbar('header-toggle','nav-bar','body-pd','header')
    
    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link')
    
    function colorLink(){
    if(linkColor){
    linkColor.forEach(l=> l.classList.remove('active'))
    this.classList.add('active')
    }
    }
    linkColor.forEach(l=> l.addEventListener('click', colorLink))
    
     // Your code to run since DOM is loaded and ready
    });