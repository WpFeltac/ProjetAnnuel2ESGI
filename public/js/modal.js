let Modal = document.getElementById("Modal");
let ModalDelete = document.getElementById("Modal-delete");
let ModalPhoto = document.getElementById("Modal-photo");
let imgLicencie = document.getElementById("img-licencie");

function displayModalDelete(idLicencie) {
  let validBtn = document.getElementById("valid-btn");

  document.body.style.overflow = "hidden";
  Modal.style.display = "block";
  ModalDelete.style.display = "flex";
  validBtn.setAttribute(
    "href",
    "./functions/licencie-delete.php?idLicencie=" + idLicencie
  );
}

function displayModalPhoto(imgPath) {
  imgLicencie.setAttribute("src", imgPath);
  document.body.style.overflow = "hidden";
  Modal.style.display = "block";
  ModalPhoto.style.display = "flex";
}

function erase() {
  document.body.style.overflow = "visible";
  Modal.style.display = "none";
  ModalDelete.style.display = "none";
  ModalPhoto.style.display = "none";
}

//When the user pressed escape close the modal
document.onkeydown = function (e) {
  if (e.key === "Escape" || e.key === "Esc") {
    erase();
  }
};

// When the user clicks anywhere outside of the modal content, close it
Modal.addEventListener("click", function (event) {
  if (event.target != imgLicencie && event.target != ModalDelete) {
    erase();
  }
});
