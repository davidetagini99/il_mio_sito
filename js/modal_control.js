document.addEventListener('DOMContentLoaded', function () {
    var openModalBtns = document.querySelectorAll('.open-modal-btn');
    var modalImage = document.getElementById('modalImage');
    var modalDescription = document.getElementById('modalDescription');

    openModalBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            modalImage.src = btn.parentElement.previousElementSibling.src;
            modalDescription.textContent = btn.getAttribute('data-project-description');
            document.getElementById('myModal').style.display = 'block';
        });
    });

    var closeModalBtn = document.querySelector('.close');
    closeModalBtn.addEventListener('click', function () {
        document.getElementById('myModal').style.display = 'none';
    });
})

/*document.addEventListener('DOMContentLoaded', function () {
    // Get the modal
    var modal = document.getElementById("myModal");

    modal.style.display = "none";

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});*/
