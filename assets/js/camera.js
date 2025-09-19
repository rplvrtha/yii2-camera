$(document).ready(function () {
  const options = window.cameraWidgetOptions || {};
  const openCameraBtn = $("#openNativeCamera");
  const fileInput = $("#fileInput");
  const previewImage = $("#previewImage");

  // Gunakan opsi dari PHP
  const uploadUrl = options.uploadUrl;
  const retakeText = options.retakeText || "Ambil Ulang Gambar";
  const onSuccess = options.onSuccess;
  const onError = options.onError;

  openCameraBtn.on("click", function () {
    fileInput.click();
  });

  fileInput.on("change", function (event) {
    const file = event.target.files[0];
    if (!file) {
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      openCameraBtn.text(retakeText);
      previewImage.attr("src", e.target.result).show();

      const formData = new FormData();
      formData.append("imageFile", file);
      formData.append("_csrf", yii.getCsrfToken());

      $.ajax({
        url: uploadUrl,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          if (onSuccess && typeof window[onSuccess] === "function") {
            window[onSuccess](response);
          } else {
            console.log("Gambar berhasil diunggah:", response);
          }
        },
        error: function (xhr, status, error) {
          if (onError && typeof window[onError] === "function") {
            window[onError](error);
          } else {
            console.error("Error saat mengunggah gambar:", error);
          }
        },
      });
    };
    reader.readAsDataURL(file);
  });
});
