function includeHTML() {
    const includes = document.querySelectorAll('[data-include]');
    includes.forEach(el => {
        let file = el.getAttribute('data-include');
        let file2 = el.getAttribute('style');
        
      
        fetch(file)
            .then(response => {
                if (!response.ok) throw new Error(`Could not load ${file}: ${response.statusText}`);
                return response.text();
            })
            .then(data => {
                el.innerHTML = data;
            })
            .catch(err => console.error(err));
    });

}
function delPub(){
    const pub = document.querySelector('.pub');
    // const but = document.querySelector('.quit-but');
    // but.addEventListener('click', () => {
        pub.classList.toggle('d-none');
    // });
    // pub.classList.toggle('d-non');
}

// delPub();
includeHTML() ; 

function blur()
{   
    document.addEventListener("DOMContentLoaded", function () {
        var collapses = document.querySelectorAll(".collapse");
        var blurBackground = document.getElementById("blurBackground");
      
        function checkCollapses() {
          var anyOpen = Array.from(collapses).some(function (collapse) {
            return collapse.classList.contains('show');
          });
      
          if (anyOpen) {
            blurBackground.classList.remove("hidden");
          } else {
            blurBackground.classList.add("hidden");
          }
        }
      
        // Initial check in case any collapse is already open
        checkCollapses();
      
        collapses.forEach(function (collapse) {
          collapse.addEventListener("shown.bs.collapse", function () {
            checkCollapses();
          });
          collapse.addEventListener("hidden.bs.collapse", function () {
            checkCollapses();
          });
        });
      });
}

blur() ; 

